<?php

namespace App\Services\Doctor;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientService
{
    public function getAll()
    {
        $doctor = Auth::user()->doctor;

        $patients = Patient::whereIn('id', function ($query) use ($doctor) {
            $query->select('patient_id')
                ->from('medical_records')
                ->where('doctor_id', $doctor->id);
        })->get();
        return $patients;
    }

    public function store(array $data)
    {
        return Patient::create($data);
    }
    public function update(Patient $patient, array $data)
    {
        $patient->update($data);
        return $patient;
    }
}
