<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

    $this->call([
            ClinicSeeder::class,
            UserSeeder::class,
            DoctorSeeder::class,
            EmployeeSeeder::class,
            ReservationSeeder::class,
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
