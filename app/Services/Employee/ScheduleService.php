<?php

namespace App\Services\Employee;

use App\Models\Doctor;

class ScheduleService
{
    public function getAll()
    {
        return Doctor::latest()->get();
    }

    public function update(Doctor $doctor, array $data)
    {
        $doctor->update($data);
        return $doctor;
    }
}
