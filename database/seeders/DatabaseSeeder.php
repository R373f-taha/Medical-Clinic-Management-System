<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Permission::firstOrCreate([
            'name' => 'manage invoices',
            'guard_name' => 'web',
        ]);

        Permission::firstOrCreate([
            'name' => 'manage appointments',
            'guard_name' => 'web',
        ]);

        $employeeRole = Role::firstOrCreate([
            'name' => 'employee',
            'guard_name' => 'web',
        ]);

        $employeeRole->syncPermissions([
            'manage invoices',
            'manage appointments',
        ]);


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

        
        $employeenrole = Role::firstOrCreate([
            'name' => 'employee', 'guard_name' => 'web']);
        $user = User::updateOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name'     => 'employee',
                'password' => Hash::make('password123123'),
            ]
        );
        $user->assignRole($employeenrole);
    

        $this->call([
            ClinicSeeder::class,
            UserSeeder::class,
            DoctorSeeder::class,
            EmployeeSeeder::class,
            MedicalRecordSeeder::class,
             AppointmentSeeder::class,
            PrescriptionSeeder::class,
            ImageSeeder::class,
            InvoiceSeeder::class,
            RatingSeeder::class,
            NotificationSeeder::class,
            ClinicSePatientSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);
    }
}

