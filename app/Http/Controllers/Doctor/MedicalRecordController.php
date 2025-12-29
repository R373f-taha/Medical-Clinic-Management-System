<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::with('patient')->latest()->get();
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'patient_id'   => 'required|exists:users,id',
            'description'  => 'required|string',
            'diagnosis'    => 'nullable|string',
            'treatment'    => 'nullable|string',
        ]);

        MedicalRecord::create($data);

        return redirect()->route('doctor.medical-records.index')
            ->with('success', 'تم إضافة السجل الطبي بنجاح');
    }

    public function show(MedicalRecord $medicalRecord)
    {
    }

    public function edit(MedicalRecord $medicalRecord)
    {
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
       $data= $request->validate([
            'patient_id'   => 'required|exists:users,id',
            'description'  => 'required|string',
            'diagnosis'    => 'nullable|string',
            'treatment'    => 'nullable|string',
        ]);

        $medicalRecord->update($data);

        return redirect()->route('doctor.medical-records.index')
            ->with('success', 'تم تعديل السجل الطبي');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();
        return back()->with('success', 'تم حذف السجل الطبي');
    }
}
