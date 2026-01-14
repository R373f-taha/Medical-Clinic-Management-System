<?php

namespace App\Services\Admin;

use App\Models\Appointment;

class AppointmentMonitorService
{
    /**
     * Retrieve all appointments with related patient and doctor information.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllAppointments()
    {
        return Appointment::with(['patient.user', 'doctor.user'])
                          ->orderBy('appointment_date', 'desc')
                          ->get();
    }

    /**
     * Delete a specific appointment by its ID.
     *
     * @param int $id
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteAppointment(int $id): void
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
    }
}
