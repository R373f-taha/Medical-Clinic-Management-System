<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Services\Doctor\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }
    /**
     * View all Patients for the current doctor
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $patients = $this->patientService->getAll();

        return view('doctor.patients.index', compact('patients'));
    }
}
