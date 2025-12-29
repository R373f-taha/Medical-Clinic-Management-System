<?php

namespace App\Services\Patient;

use App\Models\Patient;

class PatientService
{
    public function getAll()
    {
        return Patient::all();
    }

    public function update(Patient $patient, array $data)
    {
        $patient->update($data);
        return $patient;
    }
}