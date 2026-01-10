<?php

namespace App\Services\Admin;

use App\Models\Appointment;

class AppointmentMonitorService
{
    public function getAllAppointments()
    {
        // Eager loading للمرضى والدكاترة
        return Appointment::with(['patient.user', 'doctor.user'])
                          ->orderBy('appointment_date', 'desc')
                          ->get();
    }

    public function deleteAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
    }
}
