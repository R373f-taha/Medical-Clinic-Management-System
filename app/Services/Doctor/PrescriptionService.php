<?php

namespace App\Services\Doctor;

use App\Models\Prescription;
use App\Models\MedicalRecord;

class PrescriptionService
{
    /**
     * get all Prescription
     * @return \Illuminate\Database\Eloquent\Collection<int, Prescription>
     */
    public function getAll()
    {
        return Prescription::with('medical_record')
            ->latest()
            ->get();
    }

    /**
     * Store a Prescription
     * @param array $data
     * @return Prescription
     */
    public function store(array $data)
    {
        return Prescription::create($data);
    }
    /**
     * Update a Prescription
     * @param Prescription $prescription
     * @param array $data
     * @return Prescription
     */
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
