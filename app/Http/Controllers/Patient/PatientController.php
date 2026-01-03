<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StorePatientRequest as StoreStorePatientRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Services\Patient\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pest\Support\Str;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function index()
    {
        return response()->json($this->patientService->getAll());
    }
    public function create()
    {
       $patients = $this->patientService->getAll();
    }

    public function store(StoreStorePatientRequest $request)
    {
        $data = $request->validated();

        $patient = $this->patientService->store($data,);

        return response()->json([

            'message' => 'Patient was added',

            'data' => $patient,

        ],201);
    }

    public function show(Patient $patient)
    {
        return response()->json($patient);
    }

    public function edit(Patient $patient)
    {
        return response()->json($patient);
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $patient = $this->patientService->update($patient, $data);


        return response()->json([

            'message' => 'تم تحديث بيانات المريض',
            'data'    => $patient
        ]);
    }

    




    }


