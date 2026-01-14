<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StorePrescriptionRequest;
use App\Http\Requests\Update\UpdatePrescriptionRequest;
use App\Models\Prescription;
use App\Services\Doctor\PrescriptionService;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use Barryvdh\DomPDF\Facade\Pdf;
class PrescriptionController extends Controller
{
    protected $prescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
    }
    /**
     * View all Prescriptions for the current doctor
     * @return \Illuminate\Contracts\View\View
     */
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
    public function show(Prescription $prescription)
    {
        return view('doctor.prescriptions.show', compact('prescription'));
    }
    /**
     * Create a Prescription
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $medicalRecords = MedicalRecord::all();
        return view('doctor.prescriptions.create', compact('medicalRecords'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to load create prescription page');
        }
    }
    /**
     * Store a Prescription
     * @param StorePrescriptionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePrescriptionRequest $request)
    {
        try {
            $data = $request->validated();
            $this->prescriptionService->store($data);
            return redirect()->route('doctor.prescriptions.index')
                ->with('success', 'Prescription Created...!');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('delete', "Failed...!");
        }
    }
    /**
     * Edit a Prescription
     * @param Prescription $prescription
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Prescription $prescription)
    {
        $medicalRecords = MedicalRecord::all();
        return view('doctor.prescriptions.edit', compact('prescription', 'medicalRecords'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to load edit prescription page');
        }
    }
    /**
     * Update a Prescription
     * @param UpdatePrescriptionRequest $request
     * @param Prescription $prescription
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        try {
            $data = array_filter($request->validated(), fn($value) => !is_null($value));
            $this->prescriptionService->update($prescription, $data);
            return redirect()
                ->route('doctor.prescriptions.index')
                ->with('success', 'Prescription Updated...!');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('delete', "Failed...!");
        }
    }

    /**
     * Destroy a Prescription
     * @param Prescription $prescription
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Prescription $prescription)
    {
        try{
        $this->prescriptionService->delete($prescription);

        return  redirect()->route('doctor.prescriptions.index')->with('success', 'Prescription Deleted...!');
    }

    public function download(Prescription $prescription)
    {
        $pdf = Pdf::loadView(
            'doctor.prescriptions.pdf',
            compact('prescription')
        )->setPaper('a4');

        return $pdf->download(
            'prescription_' . $prescription->id . '.pdf'
        );
    }
}
