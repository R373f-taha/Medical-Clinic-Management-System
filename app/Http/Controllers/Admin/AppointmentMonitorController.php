<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\Patient\AppointmentService;

class AppointmentMonitorController extends Controller
{
    protected AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

 public function index()
{
    $appointments = $this->appointmentService->getAll();

return view('Admin.AppointmentMonitor.index', compact('appointments'));
}


    public function destroy(Appointment $appointment)
    {
        $this->appointmentService->delete($appointment);

        return redirect()->back()->with('success', 'Appointment deleted');
    }
}
