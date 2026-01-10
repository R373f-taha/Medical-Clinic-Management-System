<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreMedicalRecordRequest;
use App\Http\Requests\Update\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Doctor;
use App\Models\Patient;

class AdminMedicalRecordController extends Controller
{
    public function index()
    {


$records = MedicalRecord::with(['doctor.user','patient.user'])
    ->latest()
    ->paginate(10);


    return view('admin.medical_records.index', compact('records'));    }

    public function create()
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        return view('admin.medical_records.create', compact('doctors','patients'));
    }

    public function store(StoreMedicalRecordRequest $request)
    {
        MedicalRecord::create($request->validated());

        return redirect()->route('admin.medical-records.index')
                         ->with('success', 'Success');
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        return view('admin.medical_records.edit', compact('medicalRecord','doctors','patients'));
    }

    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $medicalRecord->update($request->validated());

        return redirect()->route('admin.medical-records.index')
                         ->with('success', 'Success');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return back()->with('success', 'Success');
    }
}
