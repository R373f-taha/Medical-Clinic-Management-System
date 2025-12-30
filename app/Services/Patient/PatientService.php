<?php

namespace App\Services\Patient;

use App\Models\Patient;

class PatientService
{
    public function getAll()
    {
        return Patient::all();
    }

    public function store(array $data)// I added this method for adding a new patient into our system
    {
        return Patient::create($data);
    }
    public function update(Patient $patient, array $data)
    {
        $patient->update($data);
        return $patient;
    }
}
