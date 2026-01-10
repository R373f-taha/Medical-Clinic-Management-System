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
$patient = Patient::inRandomOrder()->first();
$employee = Employee::inRandomOrder()->first();

return [
    'patient_id' => $patient ? $patient->id : null,
    'employee_id' => $employee ? $employee->id : null,
    'date' => $this->faker->date(),
    'time' => $this->faker->time('H:i'),
];

    }
}
