<?php

namespace App\Services\Patient;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentService
{
    /**
     * Checks patient authentication, role, permissions, and profile existence.
     *
     * @param mixed $request The request object or appointment
     * @param string|null $permission Optional specific permission to verify
     * @return \Illuminate\Http\JsonResponse|null Error response or null if authorized
     */
    public function checkPatientAccess($request, $permission = null)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error 😑',
                'message' => 'Register First 🙄'
            ], 401);
        }

        if (!$user->hasRole('patient', 'api')) {
            return response()->json([
                'status' => 'error',
                'message' => 'this page only for patient'
            ], 403);
        }

        if ($permission && !$user->hasPermissionTo($permission, 'api')) {
            return response()->json([
                'status' => 'error',
                'message' => 'it is not allowed to do that'
            ], 403);
        }

        if (!$user->patient) {
            return response()->json([
                'message' => 'you must be a patient person to take an appointment 😑',
                'instruction' => 'make a patient account 🧐'
            ], 403);
        }

        return null;
    }

    /**
     * Retrieves all appointments with patient and doctor relationships.
     *
     * @return \Illuminate\Database\Eloquent\Collection All appointments ordered by latest
     */
    public function getAll()
    {
        return Appointment::with(['patient', 'doctor'])
            ->latest()
            ->get();
    }

    /**
     * Creates a new appointment record.
     *
     * @param array $data Validated appointment data
     * @return \App\Models\Appointment Created appointment instance
     */
    public function store(array $data)
    {
        return Appointment::create($data);
    }

    /**
     * Updates an existing appointment with new data.
     *
     * @param \App\Models\Appointment $appointment Appointment model to update
     * @param array $data New appointment data
     * @return \App\Models\Appointment Updated appointment instance
     */
    public function update(Appointment $appointment, array $data)
    {
        $appointment->update($data);
        return $appointment;
    }

    /**
     * Deletes an appointment from the database.
     *
     * @param \App\Models\Appointment $appointment Appointment to delete
     * @return bool|null True if deleted, false otherwise
     */
    public function delete(Appointment $appointment)
    {
        return $appointment->delete();
    }
}
