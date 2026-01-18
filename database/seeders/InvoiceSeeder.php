<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Appointment;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $appointmentsCount = Appointment::count();

        if ($appointmentsCount === 0) {
            $this->command->warn('No appointments found. Skipping invoice seeding.');
            return;
        }

        $count = min(10, $appointmentsCount);

        Invoice::factory()->count($count)->create();
    }
}
