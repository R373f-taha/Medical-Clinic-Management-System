<?php

namespace App\Services\Patient;
use Illuminate\Http\Request;
use App\Models\Appointment;


class AppointmentService
{

public function checkPatientAccess( $request, $permission = null)
{

    $user = $request->user();

      if (!$user) {
            return response()->json([
                'status' => 'error 😑',
                'message' => 'Register First 🙄'
            ], 401);
        }

   if (!$user->hasRole('patient','api')) {
        return response()->json([
            'status' => 'error',
            'message' => 'this page only for patient'
        ], 403);
    }

    if ($permission && !$user->hasPermissionTo($permission,'api')) {
        return response()->json([
            'status' => 'error',
            'message' => 'it is not allowed to do that'
        ], 403);
    }
    if(!$user->patient){
                  return response()->json([
                    'message'=>'you must ba a patient person to take an appointment 😑',
                    'instruction'=>'make a patient account 🧐'],403);
            }

    return null;

}

    public function getAll()
    {
        return Appointment::with(['patient', 'doctor'])
            ->latest()
            ->get();
    }

    public function store(array $data)
    {
        return Appointment::create($data);
    }

    public function update(Appointment $appointment, array $data)
    {
        $appointment->update($data);
        return $appointment;
    }

    public function delete(Appointment $appointment)
    {
        return $appointment->delete();
    }
}
