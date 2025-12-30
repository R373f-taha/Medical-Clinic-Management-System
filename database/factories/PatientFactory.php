<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), // ينشئ مستخدم جديد تلقائياً
            'blood_type' => fake()->randomElement(['A+', 'O-', 'B+']),
            'height' => fake()->randomFloat(2, 150, 200),
            'weight' => fake()->randomFloat(2, 50, 120),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'allergies' => fake()->sentence(),
        ];
    }
}
