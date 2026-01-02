<?php

namespace App\Services\Employee;

use App\Models\Appointment;

class BookingService
{
    /**
     * جلب جميع الحجوزات مع العلاقات
     */
    public function getAll()
    {
        return Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'asc')
            ->get();
    }

    /**
     * تحديث بيانات الحجز (جزئي)
     */
    public function update(Appointment $appointment, array $data)
    {
        $appointment->update($data);
        return $appointment;
    }

    /**
     * قبول الحجز
     */
    public function approve(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'scheduled',
        ]);

        return $appointment;
    }

    /**
     * رفض الحجز
     */
    public function reject(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'cancelled',
        ]);

        return $appointment;
    }
}
