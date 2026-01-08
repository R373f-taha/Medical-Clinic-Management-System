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
    public function index()
    {
        $appointments = $this->appointmentServices->getAll();
        return view("doctor.appointments.history", compact("appointments"));
    }

    public function create()
    {
        $patients = $this->appointmentServices->createAppointment();
        return view("doctor.appointments.create_appointment", compact("patients"));
    }
    public function store(StoreAppointmentRequest $request)
    {
        try {
            $data = $request->validated();
            $this->appointmentServices->store($data);
            return redirect()->route("doctor.appointments.doctorAppointments")->with("success", "Appointment Created..!");
        } catch (\DomainException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('delete', $e->getMessage());
        }
    }
    public function doctorAppointments()
    {
        $appointments = $this->appointmentServices->doctorAppointments();
        return view("doctor.appointments.history", compact("appointments"));
    }
    public function update(Appointment $appointment)
    {
        return view("doctor.appointments.update_appointment", compact("appointment"));
    }
    public function edit(Appointment $appointment, UpdateAppointmentRequest $request)
    {
        try {
            $data = array_filter($request->validated(), fn($value) => !is_null($value));
            $this->appointmentServices->update($appointment, $data);
            return redirect()->route("doctor.appointments.doctorAppointments")->with("success", "Appointment Updated..!");
        } catch (\DomainException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('delete', $e->getMessage());
        }
    }
    public function today()
    {
        $appointments = $this->appointmentServices->today();
        return view("doctor.appointments.today", compact("appointments"));
    }
}
