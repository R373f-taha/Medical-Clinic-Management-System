<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StorePrescriptionRequest;
use App\Http\Requests\Update\UpdatePrescriptionRequest;
use App\Models\Prescription;
use App\Services\Doctor\PrescriptionService;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;

class PrescriptionController extends Controller
{
    protected $prescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
    }

    public function index()
    {
        $prescriptions = $this->prescriptionService->getAll();
        return view('Admin.prescriptions.index', compact('prescriptions'));
    }

    public function create() {
        $medicalRecords = MedicalRecord::all();
        return view('Admin.prescriptions.create', compact('medicalRecords'));
    }

    public function store(StorePrescriptionRequest $request)
    {
        $data = $request->validated();

        $this->prescriptionService->store($data);

        return redirect()->route('prescriptions.index')
            ->with('success', 'تم إضافة الوصفة بنجاح');
    }

    public function show(Prescription $prescription) {}

    public function edit(Prescription $prescription) {
        $medicalRecords = MedicalRecord::all();
        return view('Admin.prescriptions.edit', compact('prescription', 'medicalRecords'));
    }

    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $this->prescriptionService->update($prescription, $data);

        return redirect()
            ->route('prescriptions.index')
            ->with('success', 'تم تعديل الوصفة بنجاح');
    }


    public function destroy(Prescription $prescription)
    {
        $this->prescriptionService->delete($prescription);

        return  redirect()->route('prescriptions.index')->with('success', 'تم حذف الوصفة بنجاح');
    }
}
