<?php

namespace App\Services\Employee;

use App\Models\Appointment;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BookingService
{
    /**
     * Create a new booking with status "scheduled"
     * and notify the doctor.
     *
     * @param array $data
     * @throws ValidationException
     * @return void
     */
    public function createBooking(array $data): void
    {
        // Validate clinic working hours
        $this->validateWorkingHours($data['appointment_date']);

        // Ensure doctor availability
        $this->ensureNoConflict(
            $data['doctor_id'],
            $data['appointment_date']
        );

        $appointment = Appointment::create([
            'patient_id'       => $data['patient_id'],
            'doctor_id'        => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'reason'           => $data['reason'] ?? null,
            'status'           => 'scheduled',
        ]);

        // Notify the doctor when booking is created by an employee
        $this->notifyDoctor($appointment, 'New appointment created');
    }

    /**
     * Update an existing booking date and reason only.
     *
     * @param int $id
     * @param string $date
     * @param string|null $reason
     * @throws ValidationException
     * @return void
     */
    public function updateBooking(int $id, string $date, ?string $reason): void
    {
        $booking = Appointment::findOrFail($id);

        // Validate clinic working hours
        $this->validateWorkingHours($date);

        // Ensure no conflict only when the date has changed
        collect([
            Carbon::parse($booking->appointment_date)
                ->ne(Carbon::parse($date))
        ])->when(true, function ($collection) use ($booking, $date) {
            if ($collection->first()) {
                $this->ensureNoConflict(
                    $booking->doctor_id,
                    $date,
                    $booking->id
                );
            }
        });

        $booking->update([
            'appointment_date' => $date,
            'reason'           => $reason,
        ]);

        // Notify the doctor about the update
        $this->notifyDoctor($booking, 'Appointment updated');
    }

    /**
     * Approve a booking by setting status to "scheduled".
     *
     * @param int $id
     * @throws ValidationException
     * @return void
     */
    public function approve(int $id): void
    {
        $booking = Appointment::findOrFail($id);

        $this->validateWorkingHours($booking->appointment_date);

        // Ensure no time conflict before approval
        collect([true])->when(true, function () use ($booking) {
            $this->ensureNoConflict(
                $booking->doctor_id,
                $booking->appointment_date,
                $booking->id
            );
        });

        $booking->update(['status' => 'scheduled']);

        $this->notifyDoctor($booking, 'Appointment approved');
    }

    /**
     * Reject a booking.
     *
     * @param int $id
     * @return void
     */
    public function reject(int $id): void
    {
        $booking = Appointment::findOrFail($id);

        $booking->update(['status' => 'cancelled']);

        $this->notifyDoctor($booking, 'Appointment rejected');
    }

    /**
     * Mark a booking as completed.
     *
     * @param int $id
     * @return void
     */
    public function complete(int $id): void
    {
        $booking = Appointment::findOrFail($id);

        $booking->update(['status' => 'completed']);

        $this->notifyDoctor($booking, 'Appointment completed');
    }

    /**
     * Delete a booking.
     *
     * @param int $id
     * @return void
     */
    public function deleteBooking(int $id): void
    {
        $booking = Appointment::findOrFail($id);

        $this->notifyDoctor($booking, 'Appointment deleted');

        $booking->delete();
    }

    // ================= Helpers =================

    /**
     * Ensure the doctor does not have another appointment
     * at the same time slot.
     *
     * @param int $doctorId
     * @param string $date
     * @param int|null $ignoreId
     * @throws ValidationException
     * @return void
     */
    private function ensureNoConflict(
        int $doctorId,
        string $date,
        ?int $ignoreId = null
    ): void {
        $start = Carbon::parse($date)->startOfMinute();
        $end   = Carbon::parse($date)->endOfMinute();

        Appointment::where('doctor_id', $doctorId)
            ->whereBetween('appointment_date', [$start, $end])
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
            && throw ValidationException::withMessages([
                'appointment_date' =>
                    'This appointment time is already booked.',
            ]);
    }

    /**
     * Validate clinic working hours.
     *
     * Rules:
     * - From 10:00 to 18:00
     * - Every 30 minutes only
     *
     * @param string $date
     * @throws ValidationException
     * @return void
     */
    private function validateWorkingHours(string $date): void
    {
        $time = Carbon::parse($date);

        collect([
            $time->hour < 10 || $time->hour >= 18 =>
                'Clinic working hours are from 10:00 to 18:00.',
            !in_array($time->minute, [0, 30]) =>
                'Appointments must be scheduled every 30 minutes.',
        ])->each(function ($message, $condition) {
            $condition && throw ValidationException::withMessages([
                'appointment_date' => $message,
            ]);
        });
    }

    /**
     * Notify the doctor about the appointment.
     *
     * @param Appointment $appointment
     * @param string $title
     * @return void
     */
    private function notifyDoctor(Appointment $appointment, string $title): void
    {
        $message =
            $title . ' on ' .
            Carbon::parse($appointment->appointment_date)
                ->format('Y-m-d H:i');

        optional($appointment->doctor?->user)
            && Notification::create([
                'user_id' => $appointment->doctor->user->id,
                'title'   => $title,
                'message' => $message,
            ]);
    }
}
