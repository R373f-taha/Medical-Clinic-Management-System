<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AppointmentMonitorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentMonitorController extends Controller
{
    protected AppointmentMonitorService $service;

    /**
     * AppointmentMonitorController constructor.
     *
     * @param AppointmentMonitorService $service The service responsible for appointment operations
     */
    public function __construct(AppointmentMonitorService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a list of all appointments.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            // Fetch all appointments with patient and doctor info
            $appointments = $this->service->getAllAppointments();

            return view('Admin.AppointmentMonitor.index', compact('appointments'));
        } 
        catch (\Throwable $e) {
            Log::error('Fetching appointments failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Unable to fetch appointments.']);
        }
    }

    /**
     * Delete a specific appointment.
     *
     * @param int $id The ID of the appointment to delete
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->service->deleteAppointment($id);

            DB::commit();

            return redirect()->route('admin.appointments.index')
                             ->with('success', 'Appointment deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Delete appointment failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to delete appointment.']);
        }
    }
}
