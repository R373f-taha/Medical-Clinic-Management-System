<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreAppointmentRequest;
use App\Http\Requests\Update\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Services\Doctor\AppointmentService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $appointmentServices;
    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentServices = $appointmentService;
    }
    /**
     * View all Appintments for the current doctor
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $appointments = $this->appointmentServices->doctorAppointments();
        return view("doctor.appointments.history", compact("appointments"));
    }
    /**
     * Create an Appointment
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $patients = $this->appointmentServices->createAppointment();
        return view("doctor.appointments.create_appointment", compact("patients"));
    }
    /**
     * Store an Appointment
     * @param StoreAppointmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAppointmentRequest $request)
    {
        try {
            $data = $request->validated();
            $this->appointmentServices->store($data);
            return redirect()->route("doctor.appointments.doctorAppointments")->with("success", "Appointment Created..!");
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('delete', 'Date must be in the future Hours: 10 - 6 minutes: 00 or 30...!');
        }
    }
    /**
     * Current doctor Appointments
     * @return \Illuminate\Contracts\View\View
     */
    public function doctorAppointments()
    {
        $appointments = $this->appointmentServices->doctorAppointments();
        return view("doctor.appointments.history", compact("appointments"));
    }
    /**
     * Update an Appointment
     * @param Appointment $appointment
     * @return \Illuminate\Contracts\View\View
     */
    public function update(Appointment $appointment)
    {
        return view("doctor.appointments.update_appointment", compact("appointment"));
    }
    /**
     * Edit an Appointment
     * @param Appointment $appointment
     * @param UpdateAppointmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Appointment $appointment, UpdateAppointmentRequest $request)
    {
        try {
            $data = array_filter($request->validated(), fn($value) => !is_null($value));
            $this->appointmentServices->update($appointment, $data);
            return redirect()->route("doctor.appointments.doctorAppointments")->with("success", "Appointment Updated..!");
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('delete', 'Date must be in the future Hours: 10 - 6 minutes: 00 or 30...!');
        }
    }
    /**
     * Today's Appointment for the current doctor
     * @return \Illuminate\Contracts\View\View
     */
    public function today()
    {
        $appointments = $this->appointmentServices->today();
        return view("doctor.appointments.today", compact("appointments"));
    }
}
