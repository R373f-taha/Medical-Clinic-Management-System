<?php

namespace App\Services\Doctor;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->whereBetween('appointment_date', [
                now()->startOfDay(),
                now()->endOfDay()
            ])
            ->where('doctor_id', Auth::user()->doctor->id)
            ->orderBy('appointment_date', 'asc')
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
        try {
            DB::beginTransaction();

            $doctorId  = Auth::user()->doctor->id;
            $patientId = $data['patient_id'];
            $appointmentTime = Carbon::parse($data['appointment_date']);
            $from = $appointmentTime->copy()->subMinutes(30);
            $to   = $appointmentTime->copy()->addMinutes(30);

            $patientConflict = Appointment::where('patient_id', $patientId)
                ->where('status', 'scheduled')
                ->whereBetween('appointment_date', [$from, $to])
                ->lockForUpdate()
                ->exists();

            if ($patientConflict) {
                throw new \DomainException(
                    'This patient has an appointment with another doctor in this time'
                );
            }

            $doctorConflict = Appointment::where('doctor_id', $doctorId)
                ->where('status', 'scheduled')
                ->whereBetween('appointment_date', [$from, $to])
                ->lockForUpdate()
                ->exists();

            if ($doctorConflict) {
                throw new \DomainException(
                    'This doctor has an appointment with another patient in this time'
                );
            }

            $appointment = Appointment::create([
                'doctor_id'         => $doctorId,
                'patient_id'        => $patientId,
                'appointment_date'  => $appointmentTime->format('Y-m-d H:i:s'),
                'medical_record_id' => $data['medical_record_id'] ?? null,
                'status'            => 'scheduled',
                'notes'             => $data['notes'] ?? null,
                'reason'            => $data['reason'] ?? null,
            ]);

            DB::commit();
            return $appointment;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function update(Appointment $appointment, array $data)
    {
        try {
            DB::beginTransaction();

            $doctorId  = Auth::user()->doctor->id;
            $patientId = $appointment->patient_id;
            $appointmentTime = Carbon::parse($data['appointment_date']);

            $from = $appointmentTime->copy()->subMinutes(30);
            $to   = $appointmentTime->copy()->addMinutes(30);

            $patientConflict = Appointment::where('patient_id', $patientId)
                ->where('status', 'scheduled')
                ->where('id', '!=', $appointment->id)
                ->whereBetween('appointment_date', [$from, $to])
                ->lockForUpdate()
                ->exists();

            if ($patientConflict) {
                throw new \DomainException(
                    'This patient has another appointment in this time'
                );
            }

            $doctorConflict = Appointment::where('doctor_id', $doctorId)
                ->where('status', 'scheduled')
                ->where('id', '!=', $appointment->id)
                ->whereBetween('appointment_date', [$from, $to])
                ->lockForUpdate()
                ->exists();

            if ($doctorConflict) {
                throw new \DomainException(
                    'This doctor has another appointment in this time'
                );
            }

            $appointment->update([
                'appointment_date' => $appointmentTime->format('Y-m-d H:i:s'),
                'status'           => $data['status'],
                'notes'            => $data['notes'] ?? null,
                'reason'           => $data['reason'] ?? null,
            ]);

            DB::commit();
            return $appointment;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Appointment $appointment)
    {
        return $appointment->delete();
    }
}
