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
    public function store(array $data): Appointment
    {
        $doctorId = Auth::user()->doctor->id;
        $appointmentTime = Carbon::parse($data['appointment_date']);

        // validate working hours
        self::validate($appointmentTime->toDateTimeString());

        // ensure no doctor conflict
        $this->ensureNoConflict($doctorId, $appointmentTime);

        return Appointment::create([
            'doctor_id'        => $doctorId,
            'patient_id'       => $data['patient_id'],
            'appointment_date' => $appointmentTime->format('Y-m-d H:i:s'),
            'status'           => 'scheduled',
            'notes'            => $data['notes'] ?? null,
            'reason'           => $data['reason'] ?? null,
        ]);
    }


    /**
     * Update an Appointment
     * @param Appointment $appointment
     * @param array $data
     * @throws \DomainException
     * @return Appointment
     */
    public function update(Appointment $appointment, array $data): Appointment
    {
        $appointmentTime = Carbon::parse($data['appointment_date']);

        // validate working hours
        self::validate($appointmentTime->toDateTimeString());

        // ensure no conflict if date changed
        Appointment::query()->when(
            Carbon::parse($appointment->appointment_date)->ne($appointmentTime),
            fn() => $this->ensureNoConflict(
                $appointment->doctor_id,
                $appointmentTime,
                $appointment->id
            )
        );

        $appointment->update([
            'appointment_date' => $appointmentTime->format('Y-m-d H:i:s'),
            'status'           => $data['status'],
            'notes'            => $data['notes'] ?? null,
            'reason'           => $data['reason'] ?? null,
        ]);

        return $appointment;
    }



    public function delete(Appointment $appointment)
    {
        return $appointment->delete();
    }
    /**
     * Helper function for validate time
     * @param string $date
     * @return void
     */
    public static function validate(string $date): void
    {
        $time = Carbon::parse($date);

        if ($time->hour < 10 || $time->hour >= 18) {
            throw ValidationException::withMessages([
                'appointment_date' =>
                'Appointments are available from 10:00 to 18:00 only.',
            ]);
        }

        if (!in_array($time->minute, [0, 30])) {
            throw ValidationException::withMessages([
                'appointment_date' =>
                'Appointments must be scheduled every 30 minutes.',
            ]);
        }
    }

    /**
     * Helper function for validate date
     * @param int $doctorId
     * @param Carbon $date
     * @param mixed $ignoreId
     * @return void
     */
    private function ensureNoConflict(
        int $doctorId,
        Carbon $date,
        ?int $ignoreId = null
    ): void {
        $start = $date->copy()->startOfMinute();
        $end   = $date->copy()->endOfMinute();

        $query = Appointment::where('doctor_id', $doctorId)
            ->whereBetween('appointment_date', [$start, $end]);

        Appointment::query()->when(
            $ignoreId,
            fn() => $query->where('id', '!=', $ignoreId)
        );

        Appointment::query()->when(
            $query->exists(),
            fn() => throw ValidationException::withMessages([
                'appointment_date' =>
                'This appointment time is already booked.',
            ])
        );
    }
}
