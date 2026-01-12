<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use Spatie\Permission\Models\Role;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {

        $doctorRole = Role::firstOrCreate([
            'name' => 'doctor',
            'guard_name' => 'web'
        ]);

        Doctor::factory()
            ->count(5)
            ->create()
            ->each(function ($doctor) use ($doctorRole) {
                $doctor->user->assignRole($doctorRole);
            });
    }
}
