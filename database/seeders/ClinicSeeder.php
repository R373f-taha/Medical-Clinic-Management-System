<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clinic;

class ClinicSeeder extends Seeder
{
    public function run(): void
    {
        if (Clinic::count() === 0) {
            Clinic::create([
                'name' => 'عيادة الريادة',
                'address' => 'دمشق - سوريا',
                'phone' => '00963123456789',
                'email' => 'clinic@example.com',
            ]);
        }
    }
}
