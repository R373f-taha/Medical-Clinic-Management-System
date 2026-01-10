<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $appointment = Appointment::factory()->create();
        $patient = $appointment->patient;

        return [
            'patient_id' => Patient::inRandomOrder()->first()->id,
            'appointment_id' => $appointment->id,
            'tax' => $this->faker->numberBetween(0, 50),
            'discount' => $this->faker->numberBetween(0, 30),
            'status' => $this->faker->randomElement(['paid', 'unpaid']),
            'invoice_date' => $this->faker->date(),
            'total_amount' => $this->faker->numberBetween(100, 1000),
            'payment_method' => $this->faker->randomElement(['cash', 'card', 'online', 'bank_transfer']),
        ];
    }
}
