<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;
use App\Models\User;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();

        if (!$user) {
            $user = \App\Models\User::factory()->create();
        }

        return [
            'user_id' => $user->id,
            'blood_type' => $this->faker->randomElement(['A+', 'B+', 'O+', 'AB+']),
            'height' => $this->faker->numberBetween(150, 200),
            'weight' => $this->faker->numberBetween(50, 100),
            'gender' => $this->faker->randomElement(['male','female']),
            'allergies' => $this->faker->sentence(),
        ];
    }
}
