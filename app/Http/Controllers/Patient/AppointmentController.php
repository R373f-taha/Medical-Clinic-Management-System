<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreAppointmentRequest;
use App\Http\Requests\Update\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Services\Patient\AppointmentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentMail;
use App\Models\Doctor;

class AppointmentController extends Controller
{
    /**
     * The appointment service instance for business logic.
     */
    protected $appointmentService;

    /**
     * Constructor for dependency injection.
     *
     * @param AppointmentService $appointmentService
     */
    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    //////////////////////////////////// Appointments Management ///////////////////////////////////////

    /**
     * Creates a new appointment for the authenticated patient.
     *
     * @param StoreAppointmentRequest $request Validated appointment data
     * @return \Illuminate\Http\JsonResponse Confirmation or error message
     */
    public function takeAppointment(StoreAppointmentRequest $request)
    {
        $check = $this->appointmentService->checkPatientAccess($request, 'api:book appointment');
        if ($check) return $check;

        try {
            $user = Auth::user();
            $patient = $user->patient;

            if (!$patient) {
                return response()->json(['error' => 'Patient profile not found'], 404);
            }

            $doctor_id = $request->doctor_id;
            $doctor = Doctor::find($doctor_id);
            if (!$doctor) {
                return response()->json(['error' => 'This doctor does not exist ❌'], 404);
            }

            $appointment = $patient->appointments()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor_id,
                'appointment_date' => $request->appointment_date,
                'notes' => $request->notes,
                'status' => $request->status ?? 'pending',
                'reason' => $request->reason
            ]);

            try {
                Mail::to($user->email)
                    ->send(new AppointmentMail($appointment, 'new'));

                return response()->json([
                    'message' => 'Welcome 🤗💛',
                    'result' => 'Yes, this appointment is registered 😎✅',
                    'patient' => $patient,
                    'appointment' => $appointment,
                    'mail' => 'We will send a confirmation email to your email address. Please stay tuned.'
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Welcome 🤗💛',
                    'result' => 'Yes, this appointment is registered 😎✅',
                    'patient' => $patient,
                    'appointment' => $appointment,
                    'mail' => 'Failed to send email, but appointment saved',
                    'mail_error' => $e->getMessage()
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['error ❌' => $e->getMessage()], 500);
        }
    }

    /**
     * Updates an existing appointment.
     *
     * @param UpdateAppointmentRequest $request Validated update data
     * @param Appointment $appointment The appointment model to update
     * @return \Illuminate\Http\JsonResponse Updated appointment data
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $check = $this->appointmentService->checkPatientAccess($appointment, 'api:update appointment');
        if ($check) return $check;

        $data = array_filter($request->validated(), fn($value) => !is_null($value));
        $appointment->update($data);

        return response()->json([
            'message' => 'this appointment is updated',
            'data' => $appointment
        ]);
    }

    /**
     * Retrieves all appointments for the authenticated patient.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse List of patient's appointments
     */
    public function show_appointments(Request $request)
    {
        $check = $this->appointmentService->checkPatientAccess($request, 'api:view own appointments');
        if ($check) return $check;

        $user = Auth::user();
        $patient = $user->patient;
        $appointments = $patient->appointments()->get();

        return response()->json([
            'message' => 'welcome💛🤗...your appointments: 😎',
            'appointments' => $appointments
        ]);
    }

    /**
     * Cancels a specific appointment for the authenticated patient.
     *
     * @param Request $request
     * @param int $appointment_id ID of the appointment to cancel
     * @return \Illuminate\Http\JsonResponse Cancellation confirmation
     */
    public function cancel_appointment(Request $request, $appointment_id)
    {
        $check = $this->appointmentService->checkPatientAccess($request, 'api:cancel own appointments');
        if ($check) return $check;

        $user = Auth::user();
        $patient = $user->patient;

        $appointment = Appointment::with(['patient', 'doctor'])
            ->where('id', $appointment_id)
            ->first();

        if (!$appointment) {
            return response()->json([
                'error' => 'this appointment doesn`t exist 😒',
            ], 404);
        }

        if ($patient->id != $appointment->patient_id) {
            return response()->json([
                'error' => 'you cannot cancel this appointment because it`s not to you 😑😑'
            ], 403);
        }

        if ($appointment->status == 'cancelled') {
            return response()->json([
                'message' => 'this appointment is already cancelled..🙄🙄'
            ], 400);
        }

        try {
            $appointment->status = 'cancelled';
            $appointment->save();

            try {
                Mail::to($user->email)
                    ->send(new AppointmentMail($appointment, 'new'));

                return response()->json([
                    'message' => 'Welcome 🤗💛',
                    'result' => 'Yes, this appointment is cancelled😎✅',
                    'patient' => $patient,
                    'appointment' => $appointment,
                    'mail' => 'We will send a cancellation confirmation email to your email address. Please stay tuned.'
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Welcome 🤗💛',
                    'result' => 'Yes, this appointment is cancelled 😎✅',
                    'patient' => $patient,
                    'appointment' => $appointment,
                    'mail' => 'Failed to send email, but appointment cancelled',
                    'mail_error' => $e->getMessage()
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something Wrong ✅🤷‍♀️🤷‍♀️',
                'appointment' => $appointment
            ]);
        }
    }

    /**
     * Cancels all active appointments for the authenticated patient.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Bulk cancellation result
     */
    public function cancel_all_appointments(Request $request)
    {
        $check = $this->appointmentService->checkPatientAccess($request, 'api:cancel own appointments');
        if ($check) return $check;

        $user = Auth::user();
        $patient = $user->patient;

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
            'message' => 'successfully canceled for all your appointments ✅😑',
        ]);
    }

    /**
     * Retrieves the invoice for a specific appointment.
     *
     * @param Request $request
     * @param int $appointment_id ID of the appointment
     * @return \Illuminate\Http\JsonResponse Invoice data or status message
     */
    public function invoice(Request $request, $appointment_id)
    {
        $check = $this->appointmentService->checkPatientAccess($request, 'api:view invoices');
        if ($check) return $check;

        $user = Auth::user();
        $patient = $user->patient;

        try {
            $appointment = $patient->appointments()
                ->where('id', $appointment_id)
                ->with('invoice')
                ->first();

            if (!$appointment) {
                return response()->json(['error' => 'this appointment is not for you 🙄🧐']);
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
            ]);
        } catch (Exception $e) {
            return response()->json(['error 🧐' => $e->getMessage()]);
        }
    }

    /**
     * Retrieves prescriptions for a specific medical record.
     *
     * @param Request $request
     * @param int $medical_record_id ID of the medical record
     * @return \Illuminate\Http\JsonResponse Prescriptions list
     */
    public function prescriptions(Request $request, $medical_record_id)
    {
        $check = $this->appointmentService->checkPatientAccess($request, 'api:view own prescriptions');
        if ($check) return $check;

        $user = Auth::user();
        $patient = $user->patient;

        $medicalRecord = MedicalRecord::with(['prescriptions', 'patient'])->find($medical_record_id);

        if (!$medicalRecord) {
            return response()->json([
                'status' => 'error',
                'message' => 'this medical record doesn`t exist '
            ], 404);
        }

        if ($medicalRecord->patient_id != $patient->id) {
            return response()->json(['error' => 'this medical record is not for you']);
        }

        $medical_record = MedicalRecord::with('prescriptions')->find($medical_record_id);
        $prescription = $medical_record->prescriptions;

        return response()->json([
            'message' => 'the prescription : ',
            'prescription' => $prescription
        ]);
    }

    /**
     * Retrieves the medical record for the authenticated patient.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Patient's medical record data
     */
    public function showMedicalRecord(Request $request)
    {
        $check = $this->appointmentService->checkPatientAccess($request, 'api:view own medical record');
        if ($check) return $check;

        $user = Auth::user();
        $patient = $user->patient;
        $medical_record = $patient->medicalRecord()->get();

        return response()->json([
            'message' => 'your medical record is 💛🤧',
            'data' => $medical_record
        ]);
    }
}
