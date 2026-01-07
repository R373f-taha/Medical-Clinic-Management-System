<?php

namespace App\Services\Employee;

use App\Models\Appointment;

class BookingService
{
    public function createBooking(array $data)
    {
        $this->ensureNoConflict(
            $data['doctor_id'],
            $data['appointment_date']
        );

        Appointment::create([
            'patient_id'       => $data['patient_id'],
            'doctor_id'        => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'reason'           => $data['reason'] ?? null,
            'status'           => $data['status'] ?? 'hold',
        ]);
    }

    public function updateBooking($id, $date, $reason, $status)
    {
        $booking = Appointment::findOrFail($id);

        if ($booking->appointment_date != $date) {
            $this->ensureNoConflict(
                $booking->doctor_id,
                $date,
                $booking->id
            );
        }

        $booking->update([
            'appointment_date' => $date,
            'reason' => $reason,
            'status' => $status,
        ]);
    }

    public function approve($id)
    {
        Appointment::findOrFail($id)->update([
            'status' => 'scheduled',
        ]);
    }

    public function reject($id)
    {
        Appointment::findOrFail($id)->update([
            'status' => 'cancelled',
        ]);
    }

    private function ensureNoConflict($doctorId, $date, $ignoreId = null)
    {
        $query = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            abort(422, 'This doctor already has an appointment at this time.');
        }
    }
}
