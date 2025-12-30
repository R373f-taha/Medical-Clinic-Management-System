<?php

namespace App\Services\Admin;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Clinic_Doctor;

class ClinicDoctorService
{
    public function getAll()
    {
        return Clinic_Doctor::with(['clinic', 'doctor'])
            ->latest()
            ->get();
    }

    public function getClinics()
    {
        return Clinic::all();
    }

    public function getDoctors()
    {
        return Doctor::all();
    }

    public function store(array $data)
    {
        return Clinic_Doctor::create($data);
    }

    public function update(Clinic_Doctor $clinicDoctor, array $data)
    {
        $clinicDoctor->update($data);
        return $clinicDoctor;
    }

    public function delete(Clinic_Doctor $clinicDoctor)
    {
        return $clinicDoctor->delete();
    }
}
