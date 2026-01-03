<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreMedicalRecordRequest;
use App\Http\Requests\Update\UpdateMedicalRecordRequest as UpdateUpdateMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
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
        return view("doctor.patients.medical_records", compact("records"));
    }

    public function create()
    {
        $patients = $this->medicalRecordService->create();
        return view('doctor.patients.create_medical_record', compact('patients'));
    }

    public function store(StoreMedicalRecordRequest $request)
    {
        $data = $request->validated();

        $this->medicalRecordService->store($data);

        return redirect()->route('doctor.medical_records.index')
            ->with('success', 'تم إضافة السجل الطبي بنجاح');
    }

    public function show(MedicalRecord $medicalRecord) {}

    public function edit(MedicalRecord $medicalRecord) {
        return view('doctor.patients.update_medical_record', compact('medicalRecord'));
    }

    public function update(UpdateUpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $this->medicalRecordService->update($medicalRecord, $data);

        return redirect()
            ->route('doctor.medical_records.index')
            ->with('success', 'تم تعديل السجل الطبي');
    }


    public function destroy(MedicalRecord $medicalRecord)
    {
        $this->medicalRecordService->delete($medicalRecord);
        return back()->with('success', 'تم حذف السجل الطبي');
    }
}
