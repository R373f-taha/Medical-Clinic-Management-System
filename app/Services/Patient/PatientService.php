<?php



namespace App\Services\Patient;

use App\Models\User;
use App\Models\Patient;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class PatientService
{
    /**
     * Register a new patient
     *
     * @param array $data
     * @return array
     */
    public function registerPatient(array $data): array
    {
        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Create patient profile
        $patient = Patient::create([
            'user_id' => $user->id,
            'address' => $data['address'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'gender' => $data['gender'] ?? null,
            'emergency_contact' => $data['emergency_contact'] ?? null,
            'blood_type' => $data['blood_type'] ?? null,
            'allergies' => $data['allergies'] ?? null,
            'medical_history' => $data['medical_history'] ?? null,
        ]);

        // Assign patient role (API guard)
        $patientRole = Role::where('name', 'patient')->where('guard_name', 'api')->first();
        if ($patientRole) {
            $user->assignRole($patientRole);
        }

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'patient' => $patient,
            'token' => $token
        ];
    }

    /**
     * Update patient profile
     *
     * @param Patient $patient
     * @param array $data
     * @return Patient
     */
    public function update(Patient $patient, array $data): Patient
    {
        // Update patient data
        $patient->update($data);

        // Update user data if needed
        if (isset($data['name']) || isset($data['email'])) {
            $userData = [];
            if (isset($data['name'])) $userData['name'] = $data['name'];
            if (isset($data['email'])) $userData['email'] = $data['email'];

            $patient->user->update($userData);
        }

        return $patient->fresh();
    }

    /**
     * Get patient by user ID
     *
     * @param int $userId
     * @return Patient|null
     */
    public function getPatientByUserId(int $userId): ?Patient
    {
        return Patient::where('user_id', $userId)->first();
    }

    /**
     * Get patient with user relationship
     *
     * @param int $patientId
     * @return Patient|null
     */
    public function getPatientWithUser(int $patientId): ?Patient
    {
        return Patient::with('user')->find($patientId);
    }

    /**
     * Delete patient and associated user
     *
     * @param Patient $patient
     * @return bool
     */
    public function deletePatient(Patient $patient): bool
    {
        $user = $patient->user;

        // Delete patient
        $patient->delete();

        // Delete user
        $user->delete();

        return true;
    }


}
