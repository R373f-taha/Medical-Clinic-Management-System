<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Services\Employee\ScheduleService;
use App\Http\Requests\Employee\UpdateScheduleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    protected ScheduleService $scheduleService;

    /**
     * Inject ScheduleService instance.
     *
     * @param ScheduleService $scheduleService
     */
    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Display the doctor's schedule with optional filters.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            $appointments = $this->scheduleService->getSchedule($request);
            return view('Employee.schedule.index', compact('appointments'));
        } catch (\Throwable $e) {
            Log::error('Fetching schedule failed: '.$e->getMessage());
            return back()->withErrors(['error' => 'Unable to fetch schedule.']);
        }
    }

    /**
     * Update the available hours for a specific doctor.
     *
     * @param UpdateScheduleRequest $request
     * @param int $doctorId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateScheduleRequest $request, int $doctorId)
    {
        DB::beginTransaction();
        try {
            $this->scheduleService->updateAvailableHours($doctorId, $request->available_hours);
            DB::commit();

            return back()->with('success', 'Doctor schedule updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update schedule failed', [
                'doctor_id' => $doctorId, 
                'error' => $e->getMessage()
            ]);

            return back()->withErrors(['error' => 'Failed to update schedule.']);
        }
    }
}
