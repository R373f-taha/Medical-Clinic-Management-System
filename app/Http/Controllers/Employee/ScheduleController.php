<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Services\Employee\ScheduleService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index(Request $request)
    {
        $appointments = $this->scheduleService->getSchedule($request);

        return view('Employee.schedule.index', compact('appointments'));
    }
}
