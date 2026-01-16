<?php

namespace App\Services\Admin;

use App\Models\MedicalRecord;

class AdminMedicalRecordService
{
    /**
     * get all
     */
    public function getAll()
    {
        return MedicalRecord::with([
            'doctor.user',
            'patient.user'
        ])
        ->latest()
        ->paginate(10);
    }

    /**
     * get by id
     */
    public function findById($id)
    {
        return MedicalRecord::with([
            'doctor.user',
            'patient.user'
        ])->findOrFail($id);
    }

    /**
     * delete by id
     */
    public function delete(MedicalRecord $record)
    {
        $record->delete();
    }

}
