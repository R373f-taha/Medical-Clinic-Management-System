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

        return [
            'patient_id'       => $patient->id,
            'doctor_id'        => $doctor->id,
            'medical_record_id'=> null, // ممكن تملأه لاحقاً
            'appointment_date' => Carbon::now()->addDays($this->faker->numberBetween(1, 30))
                                            ->setTime($this->faker->numberBetween(8,16), [0,30][$this->faker->numberBetween(0,1)]),
            'status'           => $this->faker->randomElement(['hold','scheduled','completed','cancelled']),
            'reason'           => $this->faker->randomElement([
                                    'Check-up', 'Headache', 'Back pain', 'Flu symptoms'
                                  ]),
            'notes'            => $this->faker->sentence(),
            'hold_expires_at'  => Carbon::now()->addHours(2),
        ];
    }
}
