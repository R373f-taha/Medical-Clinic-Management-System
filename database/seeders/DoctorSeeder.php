<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\User;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $users = \App\Models\User::all();
        foreach ($users->take(5) as $user) {
            Doctor::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }
}
