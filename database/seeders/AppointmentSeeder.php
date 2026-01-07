<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        // نعمل 20 appointment
        Appointment::factory()->count(20)->create();

        $this->command->info('Appointments seeded successfully using factory!');
    }
}
