<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\Doctor;
use App\Models\Patient;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        foreach ($doctors as $doctor) {

            $ratingsCount = rand(3, min(7, $patients->count()));

            $randomPatients = $patients->random($ratingsCount);

            foreach ($randomPatients as $patient) {
                Rating::factory()
                    ->for($doctor)
                    ->for($patient)
                    ->create();
            }
        }
    }
}
