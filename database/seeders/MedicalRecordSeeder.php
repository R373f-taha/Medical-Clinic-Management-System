<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Doctor;
use App\Models\Patient;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        if ($doctors->isEmpty() || $patients->isEmpty()) {
            $this->command->info(' There are not any doctors or patient ');
            return;
        }

        foreach ($patients as $patient) {
            MedicalRecord::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctors->random()->id,
            ]);
        }
    }
}
