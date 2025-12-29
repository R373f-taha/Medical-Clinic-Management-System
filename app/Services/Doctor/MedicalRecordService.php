<?php

namespace App\Services\Doctor;

use App\Models\MedicalRecord;

class MedicalRecordService
{
    public function getAll()
    {
        return MedicalRecord::with('patient')
            ->latest()
            ->get();
    }

    public function store(array $data)
    {
        return MedicalRecord::create($data);
    }

    public function update(MedicalRecord $medicalRecord, array $data)
    {
        $medicalRecord->update($data);
        return $medicalRecord;
    }

    public function delete(MedicalRecord $medicalRecord)
    {
        return $medicalRecord->delete();
    }
}