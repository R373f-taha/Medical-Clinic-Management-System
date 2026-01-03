<?php

namespace App\Services\Doctor;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use DateTime;
use Illuminate\Support\Facades\Auth;

class AppointmentService
{
    public function getAll()
    {
        return Appointment::with('patient')
            ->latest()
            ->get();
    }
    public function doctorAppointments()
    {
        return Appointment::with('patient')
            ->latest()
            ->where('doctor_id', Auth::user()->doctor->id)
            ->get();
    }
    public function today()
    {
        return Appointment::with('patient')
            ->whereDate('appointment_date', now()->toDateString())
            ->orderBy('appointment_date', 'asc')
            ->where('doctor_id', Auth::user()->doctor->id)
            ->get();
    }
    public function createAppointment()
    {
        $doctor = Auth::user()->doctor;

        $patients = Patient::whereNotIn('id', function ($query) use ($doctor) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $doctor->id)
                ->where('status', 'scheduled');
        })->get();

        return $patients;
    }
    public function store(array $data)
    {
        $doctor_id = Auth::user()->doctor->id;
        $medicalRecord_id = MedicalRecord::where('patient_id', $data['patient_id'])->first()->id;
        $newAppointmentTime = new DateTime($data['appointment_date']);

        $lastAppointment = Appointment::where('doctor_id', $doctor_id)
            ->where('status', 'scheduled')
            ->orderBy('appointment_date', 'desc')
            ->first();

        if ($lastAppointment) {
            $lastTime = new DateTime($lastAppointment->appointment_date);
            $diffInMinutes = ($newAppointmentTime->getTimestamp() - $lastTime->getTimestamp()) / 60;
            if ($diffInMinutes < 30) {
                $newAppointmentTime = (clone $lastTime)->modify('+30 minutes');
            }
        }

        return Appointment::create([
            'patient_id'        => $data['patient_id'],
            'doctor_id'         => $doctor_id,
            'medical_record_id' => $medicalRecord_id,
            'appointment_date'  => $newAppointmentTime->format('Y-m-d H:i:s'),
            'status'            => $data['status'],
            'notes'             => $data['notes'] ?? null,
            'reason'            => $data['reason'] ?? null,
        ]);
    }
    public function update(Appointment $appointment, array $data)
    {
        $doctor_id = Auth::user()->doctor->id;
        $newAppointmentTime = new DateTime($data['appointment_date']);

        $lastAppointment = Appointment::where('doctor_id', $doctor_id)
            ->where('status', 'scheduled')
            ->orderBy('appointment_date', 'desc')
            ->first();

        if ($lastAppointment) {
            $lastTime = new DateTime($lastAppointment->appointment_date);
            $diffInMinutes = ($newAppointmentTime->getTimestamp() - $lastTime->getTimestamp()) / 60;
            if ($diffInMinutes < 30) {
                $newAppointmentTime = (clone $lastTime)->modify('+30 minutes');
            }
        }
        $appointment->update([
            'appointment_date'  => $newAppointmentTime->format('Y-m-d H:i:s'),
            'status'            => $data['status'],
            'notes'             => $data['notes'] ?? null,
            'reason'            => $data['reason'] ?? null,
        ]);
        return $appointment;
    }

    public function delete(Appointment $appointment)
    {
        return $appointment->delete();
    }
}
