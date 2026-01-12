<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
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

    }
}
