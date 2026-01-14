<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StorePrescriptionRequest;
use App\Http\Requests\Update\UpdatePrescriptionRequest;
use App\Models\Prescription;
use App\Services\Doctor\PrescriptionService;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;


// doctor controller responsible for displaying , editing and deleting prescription 

class PrescriptionController extends Controller
{
    protected $prescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
    }

    public function index()
    {
        try{
        $prescriptions = $this->prescriptionService->getAll();
        return view('doctor.prescriptions.index', compact('prescriptions'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to load prescriptions');
        }
    }

    public function create() {
        try{
        $medicalRecords = MedicalRecord::all();
        return view('doctor.prescriptions.create', compact('medicalRecords'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to load create prescription page');
        }
    }

    public function store(StorePrescriptionRequest $request)
    {
        try{
        $data = $request->validated();
        $this->prescriptionService->store($data);
        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription created successfully');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to create prescription');
            }
    }

    

    public function edit(Prescription $prescription) {
        try{
        $medicalRecords = MedicalRecord::all();
        return view('doctor.prescriptions.edit', compact('prescription', 'medicalRecords'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to load edit prescription page');
        }
    }

    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        try{
        $data = array_filter($request->validated(), fn($value) => !is_null($value));
        $this->prescriptionService->update($prescription, $data);

        return redirect()
            ->route('prescriptions.index')
            ->with('success', 'Prescription updated successfully');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to update prescription');
        }
    }


    public function destroy(Prescription $prescription)
    {
        try{
        $this->prescriptionService->delete($prescription);
        return  redirect()->route('prescriptions.index')->with('success', 'Prescription deleted successfully');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to delete prescription');
        }
    }
}
