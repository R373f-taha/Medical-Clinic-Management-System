<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;    // ← هذا المطلوب
use App\Models\Doctor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'specialization' => fake()->randomElement(['Cardiology', 'Neurology', 'Pediatrics', 'Dermatology', 'General Surgery']),
            'qualifications' => 'Master of Medicine and Surgery (MBBS)',
            'available_hours' => fake()->numberBetween(4, 12),
            'experience_years' => fake()->numberBetween(1, 30),
            'Current_rate' => fake()->numberBetween(1, 5),
        ];
    }
}
