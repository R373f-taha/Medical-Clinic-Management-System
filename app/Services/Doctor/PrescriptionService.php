<?php

namespace App\Services\Doctor;

use App\Models\Prescription;

class PrescriptionService
{
    public function getAll()
    {
        return Prescription::with('patient')
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