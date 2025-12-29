<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'patient_id' => Patient::inRandomOrder()->first()->id,
            'doctor_id' => Doctor::inRandomOrder()->first()->id,
            'medical_record_id' => MedicalRecord::inRandomOrder()->first()->id,
            'notes' => fake()->optional()->sentence(),
            'appointment_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement([
                'pending',
                'confirmed',
                'completed',
                'cancelled'
            ]),
            'reason' => fake()->optional()->sentence(),
        ];
    }
}
