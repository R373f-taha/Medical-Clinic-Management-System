<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prescription;

class PrescriptionFactory extends Factory
{
    protected $model = Prescription::class;

    public function definition(): array
    {
        return [
            'medical_record_id' => \App\Models\MedicalRecord::factory(),
            'medicine_name' => fake()->word(),
            'dosage' => fake()->numberBetween(1, 500),
            'frequency' => fake()->numberBetween(1, 4),
            'refills' => fake()->randomElement(['none', '1', '2', '3']),
            'instructions' => fake()->sentence(),
            'duration' => fake()->numberBetween(1, 30),
        ];
    }
}
