<?php

namespace App\Services\Employee;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BookingService
{
    // إنشاء موعد
    public function createBooking(array $data)
    {
        $this->validateWorkingHours($data['appointment_date']);

        $this->ensureNoConflict(
            $data['doctor_id'],
            $data['appointment_date']
        );

        Appointment::create([
            'patient_id'       => $data['patient_id'],
            'doctor_id'        => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'reason'           => $data['reason'] ?? null,
            'status'           => 'scheduled',
        ]);
    }

    // تعديل موعد
    public function updateBooking($id, $date, $reason)
    {
        $booking = Appointment::findOrFail($id);

        $this->validateWorkingHours($date);

        if ($booking->appointment_date != $date) {
            $this->ensureNoConflict(
                $booking->doctor_id,
                $date,
                $booking->id
            );
        }

        $booking->update([
            'appointment_date' => $date,
            'reason'           => $reason,
            'status'           => 'scheduled',
        ]);
    }

    // الموافقة على موعد
    public function approve($id)
    {
        $booking = Appointment::findOrFail($id);

        $this->validateWorkingHours($booking->appointment_date);
        $this->ensureNoConflict($booking->doctor_id, $booking->appointment_date, $booking->id);

        $booking->update([
            'status' => 'scheduled',
        ]);
    }

    // رفض موعد
    public function reject($id)
    {
        Appointment::findOrFail($id)->update([
            'status' => 'cancelled',
        ]);
    }

    // تحديد موعد كمكتمل
    public function complete($id)
    {
        Appointment::findOrFail($id)->update([
            'status' => 'completed',
        ]);
    }

    // ================== PRIVATE ==================

    private function ensureNoConflict($doctorId, $date, $ignoreId = null)
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

    private function validateWorkingHours($date)
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
