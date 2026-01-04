<?php

namespace App\Services\Doctor;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class MedicalRecordService
{
    public function getAll()
    {
        $doctor = Auth::user()->doctor;

        return MedicalRecord::with('patient')
            ->where('doctor_id', $doctor->id)
            ->latest()
            ->get();
    }

    public function create()
    {
        $doctor = Auth::user()->doctor;

        $patients = Patient::whereNotIn('id', function ($query) use ($doctor) {
            $query->select('patient_id')
                ->from('medical_records')
                ->where('doctor_id', $doctor->id);
        })->get();

        return $patients;
    }

    public function store(array $data)
    {
        return MedicalRecord::create([
            'patient_id'=> $data['patient_id'],
            'doctor_id'=> $data['doctor_id'],
            'notes'=> $data['notes'],
            'diagnosis'=> $data['diagnosis'],
            'treatment_plan'=> $data['treatment_plan'],
            'follow_up_date'=> $data['follow_up_date'],
        ]);
    }

    public function update(MedicalRecord $medicalRecord, array $data)
    {
        $medicalRecord->update(
            attributes: [
            'patient_id'=> $data['patient_id'] ?? $medicalRecord->patient_id,
            'doctor_id'=> Auth::user()->doctor->id,
            'notes'=> $data['notes'] ?? $medicalRecord->notes,
            'diagnosis'=> $data['diagnosis'] ?? $medicalRecord->diagnosis,
            'treatment_plan'=> $data['treatment_plan'] ?? $medicalRecord->treatment_plan,
            'follow_up_date'=> $data['follow_up_date'] ?? $medicalRecord->follow_up_date,
        ]
        );
        return $medicalRecord;
    }

    public function delete(MedicalRecord $medicalRecord)
    {
        return $medicalRecord->delete();
    }
}
