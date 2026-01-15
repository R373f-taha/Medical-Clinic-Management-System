<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\MedicalRecord;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * This factory:
     * - Retrieves a random medical record with its associated doctor
     * - Determines the doctor's specialization
     * - Maps the specialization to a specific image folder
     * - Randomly selects an image from the corresponding folder (if available)
     * - Assigns a random medical image type
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /**
         * Retrieve a random medical record along with its related doctor.
         */
        $medicalRecord = MedicalRecord::with('doctor')
            ->inRandomOrder()
            ->first();

        /**
         * Get the doctor's specialization to determine the image folder.
         */
        $specialization = $medicalRecord->doctor->specialization;

        /**
         * Map doctor specializations to their corresponding image directories.
         */
        $folderMap = [
            'Cardiology'       => 'Cardiology',
            'Neurology'        => 'Neurology',
            'Pediatrics'       => 'Pediatrics',
            'Dermatology'      => 'Dermatology',
            'General Surgery'  => 'GeneralSurgery',
        ];

        /**
         * Resolve the folder name based on specialization,
         * defaulting to 'General' if not found.
         */
        $folderName = $folderMap[$specialization] ?? 'General';

        /**
         * Build the absolute path to the image directory.
         */
        $path = public_path("images/{$folderName}");

        /**
         * Initialize the image path as null.
         */
        $imagePath = null;

        /**
         * Check if the directory exists and contains files,
         * then randomly select one image.
         */
        if (File::exists($path)) {
            $files = File::files($path);

            if (count($files) > 0) {
                $file = $files[array_rand($files)];
                $imagePath = "images/{$folderName}/" . $file->getFilename();
            }
        }

        /**
         * Return the factory attributes for the Image model.
         */
        return [
            'medical_record_id' => $medicalRecord->id,
            'image'             => $imagePath,
            'type'              => $this->faker->randomElement([
                'Cardiology'      => ['ecg'],
                'Neurology'       => ['ct-scan', 'mri'],
                'Pediatrics'      => ['x-ray'],
                'Dermatology'     => ['real-photo'],
                'General Surgery' => ['x-ray', 'ct-scan'],
            ][$specialization] ?? ['x-ray', 'ct-scan', 'mri']),
        ];
    }
}
