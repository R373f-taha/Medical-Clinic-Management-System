<?php

namespace App\Services\Employee;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScheduleService
{
    public function getSchedule(Request $request)
    {
        $query = Appointment::query()
            ->select('appointments.*')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->join('users as doctors_user', 'doctors.user_id', '=', 'doctors_user.id')
            ->leftJoin('patients', 'appointments.patient_id', '=', 'patients.id')
            ->leftJoin('users as patients_user', 'patients.user_id', '=', 'patients_user.id');

        // فلترة حسب اسم الدكتور (case-insensitive)
        if ($request->filled('doctor_name')) {
            $name = strtolower($request->doctor_name);
            $query->whereRaw('LOWER(doctors_user.name) LIKE ?', ["%{$name}%"]);
        }

        // جلب أقرب موعد موجود (لتحديد اليوم / الأسبوع)
        $firstAppointment = Appointment::orderBy('appointment_date')->first();

        // فلترة يومية
        if ($request->period === 'daily' && $firstAppointment) {
            $day = Carbon::parse($firstAppointment->appointment_date)->toDateString();
            $query->whereDate('appointments.appointment_date', $day);
        }

        // فلترة أسبوعية
        if ($request->period === 'weekly' && $firstAppointment) {
            $firstDay = Carbon::parse($firstAppointment->appointment_date)->startOfWeek();
            $lastDay = Carbon::parse($firstAppointment->appointment_date)->endOfWeek();
            $query->whereBetween('appointments.appointment_date', [$firstDay, $lastDay]);
        }

        return $query->orderBy('appointments.appointment_date')->get();
    }
}
