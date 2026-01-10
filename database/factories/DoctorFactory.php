<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Doctor;
use App\Models\User;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();

        if (!$user) {
            $user = \App\Models\User::factory()->create();
        }

        return [
            'user_id' => $user->id,
            'specialization' => $this->faker->randomElement(['Cardiology','Pediatrics','Dermatology','Neurology','General Surgery']),
            'qualifications' => 'Master of Medicine and Surgery (MBBS)',
            'available_hours' => $this->faker->numberBetween(4,12),
            'experience_years' => $this->faker->numberBetween(1,30),
            'current_rate' => $this->faker->randomFloat(1,1,5),
        ];
    }
}
