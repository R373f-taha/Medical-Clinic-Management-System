<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Patient;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ClinicSeeder::class,
            UserSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            EmployeeSeeder::class,
            ReservationSeeder::class,
            MedicalRecordSeeder::class,
            AppointmentSeeder::class,
            PrescriptionSeeder::class,
            ImageSeeder::class,
            InvoiceSeeder::class,
            RatingSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
