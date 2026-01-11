<?php

namespace App\Services\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\Store\StorePatientRequest;
use App\Models\Patient;
use App\Models\User;
//use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\Hash;

use RequestParseBodyException;
use Tymon\JWTAuth\Facades\JWTAuth;

class PatientService
{
    public function registerPatient($data){

        DB::beginTransaction();
        $user=User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
        ]);
        $user->assignRole('patient');

        $patient=Patient::create([
            'user_id'=>$user->id,
            'blood_type'=>$data['blood_type']??'A+',
            'height'=>$data['height']??'160',
            'gender'=>$data['gender']??'other',
            'weight'=>$data['weight']??'60',
            'allergies'=>$data['allergies']??'']);

            $token=JWTAuth::fromUser($user);//token generation
            DB::commit();

            return[
                'user'=> $user,
                'patient'=>$patient,
                'token'=>$token
            ];

        }


    public function getAll()
    {
        return Patient::all();
    }

    public function store(array $data)
    {
        $currentUser = Auth::user();

    if (!$currentUser) {

        return response()->json(['error' =>'you must reqister first'], 401);

    }

    $patient = Patient::create([

        'user_id' => $currentUser->id,

        'blood_type' => $data['blood_type'],

        'height' => $data['height'],

        'weight' => $data['weight'],

        'gender' => $data['gender'],

        'allergies' => $data['allergies'],

    ]);
        return Patient::create($data);
    }
    public function update(Patient $patient, array $data)
    {
        $patient->update($data);
        return $patient;
    }
}
