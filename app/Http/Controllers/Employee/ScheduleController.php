<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\UpdateScheduleRequest;
use App\Models\Doctor;
use App\Services\Employee\ScheduleService;

class ScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index()
    {
        $doctors = $this->scheduleService->getAll();
        // return view('employee.schedules.index', compact('doctors'));
    }

    public function edit(Doctor $doctor)
    {
        // return view('employee.schedules.edit', compact('doctor'));
    }

    public function update(UpdateScheduleRequest $request, Doctor $doctor)
    {
        $this->scheduleService->update(
            $doctor,
            $request->validated()
        );

        return redirect()
            ->route('employee.schedules.index')
            ->with('success', 'تم تحديث جدول الطبيب بنجاح');
    }
}
