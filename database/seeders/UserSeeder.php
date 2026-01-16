<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds. 
     */
    public function run(): void
    {

        // // ===== Add ADMIN =====
        // $admin = User::updateOrCreate(
        //     ['email' => 'admin@example.com'],
        //     [
        //         'name' => 'Admin',               
        //         'password' => Hash::make('admin123'),
        //     ]
        // ); 
        
        \App\Models\Patient::factory()->count(10)->create();
    }
}
