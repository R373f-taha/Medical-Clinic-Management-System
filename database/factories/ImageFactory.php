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
            'medical_record_id' => MedicalRecord::factory(),
            'path' => $this->faker->imageUrl(640, 480, 'medical'),
            'type' => $this->faker->randomElement(['x-ray', 'ct-scan', 'mri']),
        ];
    }
}
