<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        static $usedSlots = [];

        $patient = Patient::inRandomOrder()->first();
        $doctor  = Doctor::inRandomOrder()->first();

        do {
            $dayOffset = $this->faker->numberBetween(1, 30);
            $hour      = $this->faker->numberBetween(10, 17);
            $minute    = $this->faker->randomElement([0, 30]);

            $appointmentDate = Carbon::now()
                ->addDays($dayOffset)
                ->setTime($hour, $minute);

            $key = $doctor->id . '_' . $appointmentDate->format('Y-m-d H:i');

        } while (isset($usedSlots[$key]));

        $usedSlots[$key] = true;

        return [
            'patient_id'        => $patient->id,
            'doctor_id'         => $doctor->id,
            'medical_record_id' => null,
            'appointment_date'  => $appointmentDate,
            'status'            => $this->faker->randomElement([
                'hold', 'scheduled', 'completed', 'cancelled'
            ]),
            'reason'            => $this->faker->sentence(),
            'notes'             => $this->faker->sentence(),
            'hold_expires_at'   => now()->addHours(2),
        ];
    }
}
