<?php

namespace Database\Factories;

use App\Models\MedicalRecord;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalRecordFactory extends Factory
{
    protected $model = MedicalRecord::class;

    public function definition(): array
    {
        $patients=Patient::all();
        //foreach($patients as $patient){
        return [
            'doctor_id' => Doctor::inRandomOrder()->first()->id,
            'patient_id' => Patient::inRandomOrder()->first()->id,
           // 'patient_id' => Patient::factory(), // ربط السجل بالمريض
            'notes' => $this->faker->optional()->paragraph(),
            'diagnosis' => $this->faker->optional()->sentence(),
            'treatment_plan' => $this->faker->optional()->paragraph(),
            'follow_up_date' => $this->faker->optional()->dateTimeBetween('now', '+2 months'),
        ];}
   // }
}
