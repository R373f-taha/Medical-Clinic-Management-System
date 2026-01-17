<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        // جلب موعد لا يملك فاتورة
        $appointment = Appointment::whereDoesntHave('invoice')
            ->with('patient')
            ->inRandomOrder()
            ->first();

        // في حال ما بقي مواعيد
        if (!$appointment) {
            return [];
        }

        // subtotal منطقي (سعر كشفية)
        $subtotal = $this->faker->numberBetween(100, 500);

        return [
            'patient_id'     => $appointment->patient_id,
            'appointment_id' => $appointment->id,

            // حسابات
            'subtotal'       => $subtotal,
            'tax'            => $this->faker->numberBetween(5, 20), // نسبة %
            'discount'       => $this->faker->numberBetween(0, 50),

            // بيانات الفاتورة
            'status'         => $this->faker->randomElement(['paid', 'unpaid']),
            'invoice_date'   => $this->faker->date(),

            // الدفع
            'payment_method' => $this->faker->randomElement([
                'cash',
                'card',
                'online',
                'bank_transfer'
            ]),
        ];
    }
}
