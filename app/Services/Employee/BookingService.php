<?php

namespace App\Services\Employee;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BookingService
{
    /**
     * Create a new booking with status 'hold'.
     *
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    public function createBooking(array $data): void
    {
        $this->validateWorkingHours($data['appointment_date']);
        $this->ensureNoConflict($data['doctor_id'], $data['appointment_date']);

        Appointment::create([
            'patient_id'       => $data['patient_id'],
            'doctor_id'        => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'reason'           => $data['reason'] ?? null,
            'status'           => 'hold',
        ]);
    }

    /**
     * Update an existing booking's date and reason.
     *
     * @param int $id
     * @param string $date
     * @param string|null $reason
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    public function updateBooking(int $id, string $date, ?string $reason): void
    {
        $booking = Appointment::findOrFail($id);

        $this->validateWorkingHours($date);

        if ($booking->appointment_date !== $date) {
            $this->ensureNoConflict($booking->doctor_id, $date, $booking->id);
        }

        $booking->update([
            'appointment_date' => $date,
            'reason'           => $reason,
        ]);
    }

    /**
     * Approve a booking by setting status to 'scheduled'.
     *
     * @param int $id
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    public function approve(int $id): void
    {
        $booking = Appointment::findOrFail($id);

        $this->validateWorkingHours($booking->appointment_date);
        $this->ensureNoConflict($booking->doctor_id, $booking->appointment_date, $booking->id);

        $booking->update(['status' => 'scheduled']);
    }

    /**
     * Reject a booking by setting status to 'cancelled'.
     *
     * @param int $id
     * @return void
     */
    public function reject(int $id): void
    {
        Appointment::findOrFail($id)->update(['status' => 'cancelled']);
    }

    /**
     * Mark a booking as completed.
     *
     * @param int $id
     * @return void
     */
    public function complete(int $id): void
    {
        Appointment::findOrFail($id)->update(['status' => 'completed']);
    }

    // ================= Helpers =================

    /**
     * Ensure that the doctor does not have another appointment at the same date/time.
     *
     * @param int $doctorId
     * @param string $date
     * @param int|null $ignoreId
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    private function ensureNoConflict(int $doctorId, string $date, ?int $ignoreId = null): void
    {
        $query = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'appointment_date' => 'This doctor already has an appointment at this time.',
            ]);
        }
    }

    /**
     * Validate that the appointment time is within working hours (10:00 - 18:00)
     * and on a 30-minute interval.
     *
     * @param string $date
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    private function validateWorkingHours(string $date): void
    {
        $time = Carbon::parse($date);

        if ($time->hour < 10 || $time->hour >= 18) {
            throw ValidationException::withMessages([
                'appointment_date' => 'Appointment must be between 10:00 and 18:00.',
            ]);
        }

        if (!in_array($time->minute, [0, 30])) {
            throw ValidationException::withMessages([
                'appointment_date' => 'Appointments must be every 30 minutes.',
            ]);
        }
    }
}
