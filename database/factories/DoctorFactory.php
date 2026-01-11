<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;    // ← هذا المطلوب
use App\Models\Doctor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        $specializations = [
            'Cardiology' => [
                'ECG Test',
                'Heart Checkup',
                'Blood Pressure Monitoring',
                'Cholesterol Test',
            ],
            'Neurology' => [
                'Brain Examination',
                'Nerve Conduction Test',
                'Migraine Treatment',
                'Epilepsy Follow-up',
            ],
            'Pediatrics' => [
                'Child Checkup',
                'Vaccination',
                'Growth Monitoring',
                'Fever Treatment',
            ],
            'Dermatology' => [
                'Acne Treatment',
                'Skin Examination',
                'Laser Therapy',
                'Hair Loss Treatment',
            ],
            'General Surgery' => [
                'Minor Surgery',
                'Wound Care',
                'Post-operative Follow-up',
                'Hernia Treatment',
            ],
        ];
        // اختيار تخصص عشوائي
        $specialization = array_rand($specializations);
        return [
            'user_id' => User::factory(),
            'specialization' => $specialization,
            'qualifications' => 'Master of Medicine and Surgery (MBBS)',
            'available_hours' => fake()->numberBetween(4, 12),
            'experience_years' => fake()->numberBetween(1, 30),
            'services' => fake()->randomElements(
                $specializations[$specialization],
                rand(2, 4)),
        ];
    }
}
