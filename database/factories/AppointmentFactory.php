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
        $patient = Patient::inRandomOrder()->first();
        $doctor  = Doctor::inRandomOrder()->first();

        // توليد يوم عشوائي بين 1 و30 يوم من اليوم
        $dayOffset = $this->faker->numberBetween(1, 30);
        $date = Carbon::now()->addDays($dayOffset);

        // توليد وقت عشوائي بين 10 صباحًا و5 مساءً
        $hour = $this->faker->numberBetween(10, 17);
        $minute = $this->faker->randomElement([0, 30]);

        return [
            'patient_id'       => $patient->id,
            'doctor_id'        => $doctor->id,
            'appointment_date' => $date->setTime($hour, $minute),
            'status'           => $this->faker->randomElement([
                'hold', 'scheduled', 'completed', 'cancelled'
            ]),
            'reason'           => $this->faker->sentence(),
            'notes'            => $this->faker->sentence(),
            'hold_expires_at'  => Carbon::now()->addHours(2),
        ];
    }
}
