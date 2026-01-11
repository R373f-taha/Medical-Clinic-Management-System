<?php

namespace App\Http\Controllers\Patient;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreAppointmentRequest as StoreAppointmentRequest;
use App\Http\Requests\Update\UpdateAppointmentRequest as UpdateUpdateAppointmentRequest;
//use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Services\Patient\AppointmentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }


    public function update(UpdateUpdateAppointmentRequest $request, Appointment $appointment)
    {

       $check=$this->appointmentService->checkPatientAccess($appointment,'api:update appointment');

        if ($check) return $check;

        $data = array_filter($request->validated(), fn($value) => !is_null($value));
        $appointment->update($data);
        return response()->json([
            'message' => 'this appointment is updated',
            'data' => $appointment
        ]);
    }


    ////////////////////////////////////appointments management///////////////////////////////////////

    public function takeAppointment(StoreAppointmentRequest $appointment){

        $check=$this->appointmentService->checkPatientAccess($appointment,'api:book appointment');

        if ($check) return $check;

        try{

            $user=Auth::user();

        $patient=$user->patient;

        $patient_id=$patient->id;

        $doctor_id=$appointment->doctor_id;


        if(!$doctor_id){

            return response()->json(['error'=> 'this doctor doesn`t exist ❌']);
        }

        $patient->appointments()->create([
            'patient_id'=>$patient_id,
            'doctor_id'=>$doctor_id,
            'appointment_date'=>$appointment->appointment_date,
            'notes'=>$appointment->notes,
            'status'=>$appointment->status,
            'reason'=>$appointment->reason
        ]);

        return response()->json([
            'message'=> 'welcome 🤗💛',
            'result'=> 'yes...this appointment is registered 😎✅',
            'patient'=> $patient]);

    }
    catch(Exception $e){

        return response()->json(['error ❌ '=> $e->getMessage()]);
    }


    }
    public function show_appointments(Request $request){

     $check=$this->appointmentService->checkPatientAccess($request, 'api:view own appointments');

        if ($check) return $check;

        $user=Auth::user();

        $patient=$user->patient;

        $appointments=$patient->appointments()->get();

        return response()->json([

            'message'=> 'welcome💛🤗...your appointments: 😎',

            'appointments'=> $appointments]);


    }
     public function cancel_appointment(Request $request,$appointment_id){

        $check=$this->appointmentService->checkPatientAccess($request,'api:cancel own appointments');

        if ($check) return $check;

         $user=Auth::user();

        $patient=$user->patient;

         $appointment = Appointment::with(['patient', 'doctor'])
            ->where('id', $appointment_id)
            ->first();

        if (!$appointment) {
            return response()->json([
                'error' => 'this appointment doesn`t exist 😒',
            ], 404);
        }

        if($patient->id!=$appointment->patient_id){//check that this appointment for the passed patient

             return response()->json([
                'error' => 'you cannot cancel this appointment because it`s not to you 😑😑'
            ], 403);;}

             if ($appointment->status == 'cancelled') {
            return response()->json([
                'message' => 'this appointment is already cancelled..🙄🙄'
            ], 400);
        }
        $appointment->status = 'cancelled';
         $appointment->save();

         return response()->json([

            'message'=> 'welcome...your appointments becomes cancelled ✅🤷‍♀️🤷‍♀️',

            'appointment'=>$appointment

            ]);}

    public function cancel_all_appointments(Request $request){

        $check=$this->appointmentService->checkPatientAccess($request,'api:cancel own appointments');

        if ($check) return $check;

        $user=Auth::user();

        $patient=$user->patient;

         $activeAppointmentsCount = $patient->appointments()
            ->whereIn('status', ['scheduled', 'pending'])
            ->count();

         if ($activeAppointmentsCount === 0) {
            return response()->json([
                'status' => 'info 😊👩‍🔬',
                'message' => 'you don`t have any active appointment to cancel it 🧐🤦‍♀️'
            ]);
        }
          DB::beginTransaction();

        $cancelledCount = $patient->appointments()
            ->whereIn('status', ['scheduled', 'pending'])
            ->update([
                'status' => 'cancelled',
            ]);


        DB::commit();

          return response()->json([
            'status' => 'success 👩‍🔬🥼✅',
            'message' => 'successfully canceled for all your appointments ✅😑',]);
    }


    public function invoice(Request $request  ,$appointment_id){

        $check=$this->appointmentService->checkPatientAccess($request,'api:view invoices');

        if ($check) return $check;

        $user=Auth::user();

        $patient=$user->patient;
        try{
        $appointment = $patient->appointments()
            ->where('id', $appointment_id)
            ->with('invoice')
            ->first();

        if(!$appointment){

            return response()->json(['error'=> 'this appointment is not for you 🙄🧐']);
        }


         if (!$appointment->invoice) {
            return response()->json([
                'status' => 'info',
                'message' => 'The invoice for this appointment has not been determined yet 💵💵'
            ]);
                }

        return response()->json([
            'status' => 'success',
            'message' => 'you can pay in any method you want 💵😊',
            'data' => $appointment->invoice
        ]);}

       catch (Exception $e) {
        return response()->json(['error 🧐 '=> $e->getMessage()]);
       }}

    public function prescriptions(Request $request,$medical_record_id){

       $check=$this->appointmentService->checkPatientAccess($request,'api:view own prescriptions');

        if ($check) return $check;

       $user=Auth::user();

       $patient=$user->patient;

       $medicalRecord = MedicalRecord::with(['prescriptions', 'patient'])->find($medical_record_id);

      if (!$medicalRecord) {

        return response()->json([
            'status' => 'error',
            'message' => 'thid medical record doesn`t exist '
        ], 404);
    }


    if($medicalRecord->patient_id!=$patient->id)

        return response()->json(['error'=>'this medical record is not for you']);


    $medical_record=MedicalRecord::with('prescriptions')->find($medical_record_id);


    $prescription=$medical_record->prescriptions;

      return response()->json([

      'message'=>'the prescription : ',

      'perscription'=>$prescription]);
    }

    public function showMedicalRecord(Request $request){

       $check=$this->appointmentService->checkPatientAccess($request,'api:view own medical record');


       if ($check) return $check;

        $user=Auth::user();

        $patient=$user->patient;

        $medical_record=$patient->medicalRecord()->get();

        return response()->json([

            'message'=>'your medical record is 💛🤧',

            'data'=>$medical_record
        ]
        );
    }

}
