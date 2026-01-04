<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $employee = Role::firstOrCreate(['name' => 'employee']);

        $user = User::find(1);
        if ($user) {
            $user->assignRole($employee);
        }
    }
}
