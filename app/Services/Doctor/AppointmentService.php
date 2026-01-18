<?php

namespace App\Services\Doctor;

use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AppointmentService
{
    /**
     * get All Appointment
     * @return \Illuminate\Database\Eloquent\Collection<int, Appointment>
     */
    public function getAll()
    {
        return Appointment::with('patient')
            ->latest()
            ->get();
    }

    /**
     * get current_doctor's Appointments
     * @return \Illuminate\Database\Eloquent\Collection<int, Appointment>
     */
    public function doctorAppointments()
    {
        return Appointment::with('patient')
            ->latest()
            ->where('doctor_id', Auth::user()->doctor->id)
            ->get();
    }

    /**
     * get today's Appointment for the current doctor
     * @return \Illuminate\Database\Eloquent\Collection<int, Appointment>
     */
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

    /**
     * Create an Appointment
     */
    public function createAppointment()
    {
        $doctor = Auth::user()->doctor;

        return Patient::whereNotIn('id', function ($query) use ($doctor) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $doctor->id)
                ->where('status', 'scheduled');
        })->get();
    }

    /**
     * Store an Appointment
     * @param array $data
     * @throws \DomainException
     * @return Appointment
     */
    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $doctorId = Auth::user()->doctor->id;
            $patientId = $data['patient_id'];
            $appointmentTime = Carbon::parse($data['appointment_date']);

            Appointment::query()->when(
                $appointmentTime->lessThanOrEqualTo(now()),
                fn() => throw new \DomainException(
                    'Appointment time must be in the future'
                )
            );

            self::validate($appointmentTime->toDateTimeString());

            $patientConflict = Appointment::where('patient_id', $patientId)
                ->where('status', 'scheduled')
                ->where('appointment_date', $appointmentTime)
                ->lockForUpdate()
                ->exists();

            Appointment::query()->when(
                $patientConflict,
                fn() => throw new \DomainException(
                    'This patient already has an appointment at this time'
                )
            );

            $doctorConflict = Appointment::where('doctor_id', $doctorId)
                ->where('status', 'scheduled')
                ->where('appointment_date', $appointmentTime)
                ->lockForUpdate()
                ->exists();

            Appointment::query()->when(
                $doctorConflict,
                fn() => throw new \DomainException(
                    'This doctor already has an appointment at this time'
                )
            );

            $appointment = Appointment::create([
                'doctor_id'        => $doctorId,
                'patient_id'       => $patientId,
                'appointment_date' => $appointmentTime->format('Y-m-d H:i:s'),
                'status'           => 'scheduled',
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

    /**
     * Update an Appointment
     * @param Appointment $appointment
     * @param array $data
     * @throws \DomainException
     * @return Appointment
     */
    public function update(Appointment $appointment, array $data)
    {
        try {
            DB::beginTransaction();

            $doctorId = Auth::user()->doctor->id;
            $patientId = $appointment->patient_id;
            $appointmentTime = Carbon::parse($data['appointment_date']);

            Appointment::query()->when(
                $appointmentTime->lessThanOrEqualTo(now()),
                fn() => throw new \DomainException(
                    'Appointment time must be in the future'
                )
            );

            self::validate($appointmentTime->toDateTimeString());

            $patientConflict = Appointment::where('patient_id', $patientId)
                ->where('status', 'scheduled')
                ->where('id', '!=', $appointment->id)
                ->where('appointment_date', $appointmentTime)
                ->lockForUpdate()
                ->exists();

            Appointment::query()->when(
                $patientConflict,
                fn() => throw new \DomainException(
                    'This patient has another appointment at this time'
                )
            );

            $doctorConflict = Appointment::where('doctor_id', $doctorId)
                ->where('status', 'scheduled')
                ->where('id', '!=', $appointment->id)
                ->where('appointment_date', $appointmentTime)
                ->lockForUpdate()
                ->exists();

            Appointment::query()->when(
                $doctorConflict,
                fn() => throw new \DomainException(
                    'This doctor has another appointment at this time'
                )
            );

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

    public static function validate(string $date): void
    {
        $time = Carbon::parse($date);

        if ($time->hour < 10 || $time->hour >= 14) {
            throw ValidationException::withMessages([
                'appointment_date' =>
                'Appointments are available from 10:00 to 14:00 only.',
            ]);
        }

        if (!in_array($time->minute, [0, 30])) {
            throw ValidationException::withMessages([
                'appointment_date' =>
                'Appointments must be scheduled every 30 minutes.',
            ]);
        }
    }
}
