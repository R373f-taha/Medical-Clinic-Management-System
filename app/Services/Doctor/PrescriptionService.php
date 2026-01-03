<?php

namespace App\Services\Doctor;

use App\Models\Prescription;
use App\Models\MedicalRecord;

class PrescriptionService
{
    public function getAll()
    {
        return Prescription::with('medical_record')
            ->latest()
            ->get();
    }

    public function store(array $data)
    {
        return Prescription::create($data);
    }

    public function update(Prescription $prescription, array $data)
    {
        $prescription->update($data);
        return $prescription;
    }

    public function delete(Prescription $prescription)
    {
        return $prescription->delete();
    }
}