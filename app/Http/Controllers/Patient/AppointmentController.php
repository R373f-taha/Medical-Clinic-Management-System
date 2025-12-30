<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
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
}
