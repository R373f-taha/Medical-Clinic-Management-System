<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('patient')->latest()->get();
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

        Appointment::create($data);

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

        $appointment->update($data);


        return redirect()->route('doctor.appointments.index')
            ->with('success', 'تم تعديل الموعد');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return back()->with('success', 'تم حذف الموعد');
    }
}
