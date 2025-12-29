<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\Doctor\AppointmentService;
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
        $appointments = $this->appointmentService->getAll();
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
       $data= $request->validate([
            'patient_id' => 'required|exists:users,id',
            'date'       => 'required|date',
            'time'       => 'required',
            'status'     => 'required|string|max:50',
        ]);

        $this->appointmentService->store($data);

        return redirect()->route('doctor.appointments.index')
            ->with('success', 'تم إضافة الموعد بنجاح');
    }

    public function show(Appointment $appointment)
    {
    }

    public function edit(Appointment $appointment)
    {
    }

    public function update(Request $request, Appointment $appointment)
    {
       $data= $request->validate([
            'patient_id' => 'required|exists:users,id',
            'date'       => 'required|date',
            'time'       => 'required',
            'status'     => 'required|string|max:50',
        ]);

        $this->appointmentService->update($appointment, $data);


        return redirect()->route('doctor.appointments.index')
            ->with('success', 'تم تعديل الموعد');
    }

    public function destroy(Appointment $appointment)
    {
        $this->appointmentService->delete($appointment);
        return back()->with('success', 'تم حذف الموعد');
    }
}
