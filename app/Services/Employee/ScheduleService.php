<?php

namespace App\Services\Employee;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScheduleService
{
    /**
     * Get appointments schedule with optional filtering.
     *
     * Filters can include:
     * - Doctor name
     * - Period (daily / weekly)
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function getSchedule(Request $request)
    {
        $query = Appointment::query()
            ->select('appointments.*')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->join('users as doctors_user', 'doctors.user_id', '=', 'doctors_user.id')
            ->leftJoin('patients', 'appointments.patient_id', '=', 'patients.id')
            ->leftJoin('users as patients_user', 'patients.user_id', '=', 'patients_user.id')

            // Filter by doctor name when provided
            ->when($request->filled('doctor_name'), function ($q) use ($request) {
                $name = strtolower($request->doctor_name);
                $q->whereRaw('LOWER(doctors_user.name) LIKE ?', ["%{$name}%"]);
            });

        // Get the earliest appointment to determine the reference period
        $firstAppointment = Appointment::orderBy('appointment_date')->first();

        // Apply period filter when an appointment exists
        $query->when($firstAppointment, function ($q) use ($request, $firstAppointment) {

            // Daily schedule filter
            $q->when($request->period === 'daily', function ($q) use ($firstAppointment) {
                $day = Carbon::parse($firstAppointment->appointment_date)->toDateString();
                $q->whereDate('appointments.appointment_date', $day);
            });

            // Weekly schedule filter
            $q->when($request->period === 'weekly', function ($q) use ($firstAppointment) {
                $firstDay = Carbon::parse($firstAppointment->appointment_date)->startOfWeek();
                $lastDay  = Carbon::parse($firstAppointment->appointment_date)->endOfWeek();
                $q->whereBetween('appointments.appointment_date', [$firstDay, $lastDay]);
            });
        });

        return $query
            ->orderBy('appointments.appointment_date')
            ->get();
    }

    /**
     * Update the available working hours for a specific doctor.
     *
     * @param int $doctorId
     * @param int $hours
     * @return void
     */
    public function updateAvailableHours(int $doctorId, int $hours)
    {
        $doctor = Doctor::findOrFail($doctorId);
        $doctor->update(['available_hours' => $hours]);
    }
}
