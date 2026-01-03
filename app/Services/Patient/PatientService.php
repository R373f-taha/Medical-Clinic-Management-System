<?php

namespace App\Services\Patient;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PatientService
{
    public function getAll()
    {
        return Patient::all();
    }

    public function store(array $data)// I added this method for adding a new patient into our system
    {
        $currentUser = Auth::user();

    if (!$currentUser) {

        return response()->json(['error' =>'you must reqister first'], 401);

    }

    $patient = Patient::create([

        'user_id' => $currentUser->id,

        'blood_type' => $data['blood_type'],

        'height' => $data['height'],

        'weight' => $data['weight'],

        'gender' => $data['gender'],
        
        'allergies' => $data['allergies'],

    ]);
        return Patient::create($data);
    }
    public function update(Patient $patient, array $data)
    {
        $patient->update($data);
        return $patient;
    }
}
