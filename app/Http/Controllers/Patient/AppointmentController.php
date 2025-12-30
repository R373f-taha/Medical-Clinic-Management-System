<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
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

    public function store(Request $request)
    {
       $data= $request->validate([
             'doctor_id' => 'required|exists:doctors,id',
            'date'      => 'required|date',
            'time'      => 'required',
            'status'    => 'required|string|max:50',
            'notes'     => 'nullable|string',
            'reason'    => 'nullable|string',
        ]);

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

  public function update(Request $request, Appointment $appointment)
{
    $data = $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'date'      => 'required|date',
        'time'      => 'required',
        'status'    => 'required|string|max:50',
        'notes'     => 'nullable|string',
        'reason'    => 'nullable|string',
    ]);

    $appointment = $this->appointmentService->update($appointment, $data);

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
}
