<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Services\Doctor\MedicalRecordService;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    protected $medicalRecordService;

    public function __construct(MedicalRecordService $medicalRecordService)
    {
        $this->medicalRecordService = $medicalRecordService;
    }

    public function index()
    {
         $records = $this->medicalRecordService->getAll();
    }

    public function create()
    {
        return view('doctor.medical_records.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'doctor_id'      => 'required|exists:doctors,id',
            'notes'          => 'nullable|string',
            'diagnosis'      => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
        ]);

        $this->medicalRecordService->store($data);

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
       $data = $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'doctor_id'      => 'required|exists:doctors,id',
            'notes'          => 'nullable|string',
            'diagnosis'      => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
        ]);

        $this->medicalRecordService->update($medicalRecord, $data);

        return redirect()->route('doctor.medical-records.index')
            ->with('success', 'تم تعديل السجل الطبي');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $this->medicalRecordService->delete($medicalRecord);
        return back()->with('success', 'تم حذف السجل الطبي');
    }
}
