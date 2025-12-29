<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function index()
    {
        $patients = Patient::all(); 
        return response()->json($patients);
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
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id, 
            'phone' => 'required|string|max:20',
        ]);

        $patient->update($data);

        return response()->json([
            'message' => 'تم تحديث بيانات المريض',
            'data' => $patient
        ]);
    }
}
