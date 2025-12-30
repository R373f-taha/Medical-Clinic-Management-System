<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Patient;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        return [
            'patient_id' => Patient::inRandomOrder()->first()->id,
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'date' => $this->faker->date(),
            'time' => $this->faker->time('H:i'),
        ];
    }
}
