<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Services\Patient\AppointmentService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index()
    {
        return response()->json($this->appointmentService->getAll());
    }

    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();

        $appointment = $this->appointmentService->store($data);


        return response()->json([
            'message' => 'تم إنشاء الموعد بنجاح',
            'data' => $appointment
        ]);
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment);
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));
        // Saving old values from the null value...
        $appointment->update($data);
        // Only the entered values will be updated...
        return response()->json([
            'message' => 'تم تحديث الموعد',
            'data' => $appointment
        ]);
    }


    public function destroy(Appointment $appointment)
    {
        $this->appointmentService->delete($appointment);

        return response()->json([
            'message' => 'تم حذف الموعد'
        ]);
    }
    ////////////////////////////////////appointments management///////////////////////////////////////

    public function takeAppointment(StoreAppointmentRequest $appointment){

        $patient_id=$appointment->patient_id;

        $doctor_id=$appointment->doctor_id;

        $medical_record_id=$appointment->medical_record_id;

        $patient=Patient::find($patient_id);

        if(!$patient){

            return response()->json(['error'=> 'this patient doesn`t exist']);
        }

        if(!$doctor_id){

            return response()->json(['error'=> 'this doctor doesn`t exist']);
        }
         if(!$medical_record_id){

             return response()->json(['error'=> 'without medical record ..you can`t take an apointment']);

         }
        $patient->appointments()->create([
            'patient_id'=>$patient_id,
            'doctor_id'=>$doctor_id,
            'medical_record_id'=>$medical_record_id,
            'notes'=>$appointment->notes,
            'status'=>$appointment->status,
            'reason'=>$appointment->reason
        ]);
    }

    public function show_appointments($patient_id){

        $patient=Patient::find($patient_id);

        $appointments=$patient->appointments()->get();

        return response()->json([

            'message'=> 'welcome...your appointments:',

            'appointments'=> $appointments]);


    }
     public function cancel_appointment($patient_id,$appointment_id){

        $appointment=Appointment::find($appointment_id);

        if($patient_id==$appointment->patient_id){//check that this appointment for the passed patient

            $appointment->status= 'cancelled';}

        return response()->json([

            'message'=> 'welcome...your appointments becomes cancelled',

            ]);

    }

    public function cancell_all_appointments($patient_id){

        $patient=Patient::find($patient_id);

        if(!$patient){

            return response()->json(['error'=> 'this patient doesn`t exist']);

        }

        $patient->appointments()->update(['status'=> 'cancelled']);

        return response()->json([

            'result'=>'all appointment cancelled successfully'

        ]);
    }


    public function invoice($patient_id,$appointment_id){

        $patient=Patient::find($patient_id);

        $appointment=Appointment::find($appointment_id);

        if(!$appointment){

            return response()->json(['error'=> 'this appointment doesn`t exist']);
        }

         if($patient_id==$appointment->patient_id){

        $invoice=$appointment->invoice;

        return response()->json([
            'message'=> 'welcome...your invoice:',
            'invoice'=> $invoice]);}

    }
public function prescriptions($medical_record_id){

        $medical_record=MedicalRecord::with('prescriptions')->find($medical_record_id);
        if(!$medical_record){
            return response()->json(['medical_record'=>'this medical record doesn`t exist']);
        }

        $perscription=$medical_record->prescriptions;

      return response()->json(['message'=>'the perscription :',
      'perscription'=>$perscription]);
    }

    public function showMedicalRecord($patient_id){

        $patient=Patient::find($patient_id);

        if(!$patient){

            return response()->json(['patient'=>'this patient doesn`t exist']);

        }

        $medical_record=$patient->medical_record()->get();

        return response()->json([

            'message'=>'your medical record is',

            $medical_record
        ]
        );
    }

}
