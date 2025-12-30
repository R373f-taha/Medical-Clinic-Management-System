<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Services\Patient\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function index()
    {
        return response()->json($this->patientService->getAll());
    }


    public function show(Patient $patient)
    {
        return response()->json($patient);
    }

    public function edit(Patient $patient)
    {
        return response()->json($patient);
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
             'blood_type' => 'nullable|string|max:5',
            'height'     => 'nullable|numeric',
            'weight'     => 'nullable|numeric',
            'gender'     => 'nullable|string|in:male,female,other',
            'allergies'  => 'nullable|string',
            'name'       => 'nullable|string|max:255',       // من جدول users
            'email'      => 'nullable|email|unique:users,email,' . $patient->user_id,
            'phone'      => 'nullable|string|max:20',
        ]);

        $patient = $this->patientService->update($patient, $data);

        return response()->json([
            'message' => 'تم تحديث بيانات المريض',
            'data' => $patient
        ]);
    }
}
