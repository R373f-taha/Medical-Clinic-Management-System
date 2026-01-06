<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Spatie\Permission\Models\Role;
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


        ]);

        // Create Employee Role"
        $employeeRole = Role::create(['name' => 'employee']);

        // Invoices and appointments Role
        Permission::create(['name' => 'manage invoices']);
        Permission::create(['name' => 'manage appointments']);

        $employeeRole->givePermissionTo(['manage invoices', 'manage appointments']);
    }
}
