<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'medical_record_id' => MedicalRecord::inRandomOrder()->first()->id,
            'image' => $this->faker->imageUrl(),
            'type' => $this->faker->randomElement(['x-ray', 'ct-scan', 'mri']),
        ];
    }
}
