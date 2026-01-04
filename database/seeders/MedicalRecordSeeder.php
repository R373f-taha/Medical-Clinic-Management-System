<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Patient;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {

        $patients = Patient::orderBy('id')->get();//to ensure that the patient and his medical record
        //is connected

        foreach ($patients as $index => $patient) {

            MedicalRecord::factory()->create([

                'patient_id' => $patient->id,

            ]);
        }
        MedicalRecord::factory()->count(30)->create();
    }
}
