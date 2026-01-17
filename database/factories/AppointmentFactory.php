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
        $patient = Patient::inRandomOrder()->first()
            ?? Patient::factory()->create();

        $doctor  = Doctor::inRandomOrder()->first()
            ?? Doctor::factory()->create();

        // 👇 unique لمنع تكرار (doctor + datetime)
        $dateTime = $this->faker->unique()->numberBetween(1, 30) . '-' .
                    $this->faker->numberBetween(10, 17) . '-' .
                    $this->faker->randomElement([0, 30]);

        [$dayOffset, $hour, $minute] = explode('-', $dateTime);

        $date = Carbon::now()
            ->addDays((int) $dayOffset)
            ->setTime((int) $hour, (int) $minute);

        return [
            'patient_id'       => $patient->id,
            'doctor_id'        => $doctor->id,
            'appointment_date' => $date,
            'status'           => $this->faker->randomElement([
                'hold', 'scheduled', 'completed', 'cancelled'
            ]),
            'reason'           => $this->faker->sentence(),
            'notes'            => $this->faker->sentence(),
            'hold_expires_at'  => Carbon::now()->addHours(2),
        ];
    }
}
