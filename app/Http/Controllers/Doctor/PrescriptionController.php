<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StorePrescriptionRequest;
use App\Http\Requests\Update\UpdatePrescriptionRequest;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Services\Doctor\PrescriptionService;
use Barryvdh\DomPDF\Facade\Pdf;

class PrescriptionController extends Controller
{
    protected $prescriptionService;

    /**
     * PrescriptionController constructor.
     *
     * @param PrescriptionService $prescriptionService Service for handling prescriptions
     */
    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->prescriptionService = $prescriptionService;
    }

    /**
     * Display a listing of all prescriptions for the current doctor.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $prescriptions = $this->prescriptionService->getAll();
            return view('doctor.prescriptions.index', compact('prescriptions'));
        } catch (\Exception $e) {
            // Return back with error message if loading fails
            return back()->with('error', 'Failed to load prescriptions');
        }
    }

    /**
     * Display a single prescription.
     *
     * @param Prescription $prescription
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Prescription $prescription)
    {
        return view('doctor.prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for creating a new prescription.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        try {
            $medicalRecords = MedicalRecord::all();
            return view('doctor.prescriptions.create', compact('medicalRecords'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load create prescription page');
        }
    }

    /**
     * Store a newly created prescription in the database.
     *
     * @param StorePrescriptionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePrescriptionRequest $request)
    {
        try {
            $data = $request->validated();

            // Store prescription via service
            $this->prescriptionService->store($data);

            return redirect()->route('doctor.prescriptions.index')
                ->with('success', 'Prescription Created...!');
        } catch (\Throwable $e) {
            // Return back with input and error if storing fails
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create prescription!');
        }
    }

    /**
     * Show the form for editing a prescription.
     *
     * @param Prescription $prescription
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Prescription $prescription)
    {
        try {
            $medicalRecords = MedicalRecord::all();
            return view('doctor.prescriptions.edit', compact('prescription', 'medicalRecords'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load edit prescription page');
        }
    }

    /**
     * Update the specified prescription in the database.
     *
     * @param UpdatePrescriptionRequest $request
     * @param Prescription $prescription
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        try {
            $data = array_filter($request->validated(), fn($value) => !is_null($value));

            // Update prescription via service
            $this->prescriptionService->update($prescription, $data);

            return redirect()
                ->route('doctor.prescriptions.index')
                ->with('success', 'Prescription Updated...!');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update prescription!');
        }
    }

    /**
     * Remove the specified prescription from the database.
     *
     * @param Prescription $prescription
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Prescription $prescription)
    {
        try {
            // Delete prescription via service
            $this->prescriptionService->delete($prescription);

            return redirect()
                ->route('doctor.prescriptions.index')
                ->with('success', 'Prescription Deleted...!');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete prescription!');
        }
    }

    /**
     * Download the specified prescription as a PDF.
     *
     * @param Prescription $prescription
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function download(Prescription $prescription)
    {
        try {
            $pdf = Pdf::loadView('doctor.prescriptions.pdf', compact('prescription'))
                ->setPaper('a4');

            return $pdf->download('prescription_' . $prescription->id . '.pdf');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to download prescription PDF!');
        }
    }
}
