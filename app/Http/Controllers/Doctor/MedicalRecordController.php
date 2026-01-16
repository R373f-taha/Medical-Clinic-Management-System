<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreMedicalRecordRequest;
use App\Http\Requests\Update\UpdateMedicalRecordRequest as UpdateUpdateMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Services\Doctor\MedicalRecordService;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class MedicalRecordController extends Controller
{
    protected $medicalRecordService;

    public function __construct(MedicalRecordService $medicalRecordService)
    {
        $this->medicalRecordService = $medicalRecordService;
    }
    /**
     * View all medical-records for the current doctor
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $records = $this->medicalRecordService->getAll();
        return view("doctor.patients.medical_records", compact("records"));
    }
    /**
     * Create a medical-record
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $patients = $this->medicalRecordService->create();
        return view('doctor.patients.create_medical_record', compact('patients'));
    }
    /**
     * Store a medical-record
     * @param StoreMedicalRecordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMedicalRecordRequest $request)
    {
        try {
            $data = $request->validated();
            $this->medicalRecordService->store($data);
            return redirect()->route('doctor.medical_records.index')
                ->with('success', 'Medical_Record Created...!');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('delete', "Failed...!");
        }
    }
    /**
     * Edit a medical-record
     * @param MedicalRecord $medicalRecord
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        return view('doctor.patients.update_medical_record', compact('medicalRecord'));
    }
    /**
     * Update a medical-record
     * @param UpdateUpdateMedicalRecordRequest $request
     * @param MedicalRecord $medicalRecord
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        try {
            $data = array_filter($request->validated(), fn($value) => !is_null($value));
            $this->medicalRecordService->update($medicalRecord, $data);
            return redirect()
                ->route('doctor.medical_records.index')
                ->with('success', 'Medical_Record Updated...!');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('delete', "Failed...!");
        }
    }

    /**
     * Destroy a medical-record
     * @param MedicalRecord $medicalRecord
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        $this->medicalRecordService->delete($medicalRecord);
        return back()->with('success', '  medicalRecord deleted successfully');
    }
}
