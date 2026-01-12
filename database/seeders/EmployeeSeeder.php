<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EmployeeSeeder extends Seeder

{
  
     public function run(): void
    {

        $employeeRole = Role::firstOrCreate([
            'name' => 'employee',
            'guard_name' => 'web'
        ]);

    Employee ::factory()
            ->count(5)
            ->create()
            ->each(function ($employee) use ($employeeRole) {
                $employee->user->assignRole($employeeRole);
            });
    }
    
}
