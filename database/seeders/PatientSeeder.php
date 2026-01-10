<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        foreach ($users->skip(5)->take(5) as $user) {
            Patient::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }
}
