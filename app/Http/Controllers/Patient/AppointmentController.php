<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json(Appointment::latest()->get());
    }

    public function store(Request $request)
    {
       $data= $request->validate([
            'doctor_id' => 'required|exists:doctor,id',
            'date'      => 'required|date',
            'time'      => 'required',
            'status'    => 'required|string|max:50',
        ]);

        $appointment = Appointment::create($data());

        return response()->json([
            'message' => 'تم إنشاء الموعد بنجاح',
            'data' => $appointment
        ]);
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctor,id',
            'date'      => 'required|date',
            'time'      => 'required',
            'status'    => 'required|string|max:50',
        ]);

        $appointment->update($request->all());

        return response()->json([
            'message' => 'تم تحديث الموعد',
            'data' => $appointment
        ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'message' => 'تم حذف الموعد'
        ]);
    }
}
