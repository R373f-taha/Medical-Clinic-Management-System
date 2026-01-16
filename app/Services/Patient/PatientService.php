<?php

namespace App\Services\Patient;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentService
{
    /**
     * Checks if the authenticated user has patient access and specific permission.
     *
     * @param mixed $request The request object or appointment instance
     * @param string|null $permission Optional permission to check
     * @return \Illuminate\Http\JsonResponse|null Error response if checks fail, otherwise null
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
                'message' => 'you must ba a patient person to take an appointment 😑',
                'instruction' => 'make a patient account 🧐'
            ], 403);
        }

        return null;
    }

    /**
     * Retrieves all appointments with patient and doctor relations.
     *
     * @return \Illuminate\Database\Eloquent\Collection List of appointments
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
     * @param array $data Appointment data
     * @return \App\Models\Appointment The created appointment instance
     */
    public function store(array $data)
    {
        return Appointment::create($data);
    }

    /**
     * Updates an existing appointment.
     *
     * @param \App\Models\Appointment $appointment Appointment to update
     * @param array $data New appointment data
     * @return \App\Models\Appointment The updated appointment instance
     */
    public function update(Appointment $appointment, array $data)
    {
        $appointment->update($data);
        return $appointment;
    }

    /**
     * Deletes an appointment record.
     *
     * @param \App\Models\Appointment $appointment Appointment to delete
     * @return bool|null Deletion result
     */
    public function delete(Appointment $appointment)
    {
        return $appointment->delete();
    }
}
