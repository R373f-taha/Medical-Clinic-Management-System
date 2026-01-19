<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
          $adminrole = Role::firstOrCreate([
            'name' => 'clinicManager', 'guard_name' => 'web']);
        $user = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'admin',
                'password' => Hash::make('password123'),
            ]
        );
        $user->assignRole($adminrole);

    }
}
