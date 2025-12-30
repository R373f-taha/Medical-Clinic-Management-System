<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;
use App\Models\Prescription;
use App\Services\Doctor\PrescriptionService;
use Illuminate\Http\Request;

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
    }

    public function create() {}

    public function store(StorePrescriptionRequest $request)
    {
        $data = $request->validated();

        $this->prescriptionService->store($data);

        return redirect()->route('doctor.prescriptions.index')
            ->with('success', 'تم إضافة الوصفة بنجاح');
    }

    public function show(Prescription $prescription) {}

    public function edit(Prescription $prescription) {}

    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $this->prescriptionService->update($prescription, $data);

        return redirect()
            ->route('doctor.prescriptions.index')
            ->with('success', 'تم تعديل الوصفة بنجاح');
    }


    public function destroy(Prescription $prescription)
    {
        $this->prescriptionService->delete($prescription);

        return back()->with('success', 'تم حذف الوصفة بنجاح');
    }
}
