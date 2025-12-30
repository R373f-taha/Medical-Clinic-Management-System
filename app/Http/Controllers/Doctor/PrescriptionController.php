<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
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

    public function create()
    {
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'medicine_name'     => 'required|string|max:255',
            'dosage'            => 'required|integer|min:1',
            'frequency'         => 'required|integer|min:1',
            'refills'           => 'nullable|string|max:50',
            'instructions'      => 'nullable|string',
            'duration'          => 'required|integer|min:1',
        ]);

        $this->prescriptionService->store($data);

        return redirect()->route('doctor.prescriptions.index')
            ->with('success', 'تم إضافة الوصفة بنجاح');
    }

    public function show(Prescription $prescription)
    {
    }

    public function edit(Prescription $prescription)
    {
    }

    public function update(Request $request, Prescription $prescription)
    {
        $data = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'medicine_name'     => 'required|string|max:255',
            'dosage'            => 'required|integer|min:1',
            'frequency'         => 'required|integer|min:1',
            'refills'           => 'nullable|string|max:50',
            'instructions'      => 'nullable|string',
            'duration'          => 'required|integer|min:1',
        ]);

        $this->prescriptionService->update($prescription, $data);

        return redirect()->route('doctor.prescriptions.index')
            ->with('success', 'تم تعديل الوصفة بنجاح');
    }

    public function destroy(Prescription $prescription)
    {
        $this->prescriptionService->delete($prescription);

        return back()->with('success', 'تم حذف الوصفة بنجاح');
    }
}
