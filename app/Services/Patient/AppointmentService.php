<?php

namespace App\Services\Patient;

use App\Models\Appointment;

class AppointmentService
{
    public function getAll()
    {
        return Appointment::with(['patient', 'doctor'])
            ->latest()
            ->get();
    }

    public function store(array $data)
    {
        return Appointment::create($data);
    }

    public function update(Appointment $appointment, array $data)
    {
        $appointment->update($data);
        return $appointment;
    }

    public function delete(Appointment $appointment)
    {
        return $appointment->delete();
    }
}
