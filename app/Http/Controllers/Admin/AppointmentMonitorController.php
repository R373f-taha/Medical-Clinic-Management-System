<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AppointmentMonitorService;
use Illuminate\Http\Request;

class AppointmentMonitorController extends Controller
{
    protected $service;

    public function __construct(AppointmentMonitorService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $appointments = $this->service->getAllAppointments();
        return view('Admin.AppointmentMonitor.index', compact('appointments'));
    }

    public function destroy($id)
    {
        $this->service->deleteAppointment($id);
        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Appointment deleted successfully.');
    }
}
