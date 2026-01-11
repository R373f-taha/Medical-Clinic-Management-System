<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StorePatientRequest ;

use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\User;
use App\Services\Patient\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pest\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB ;
use Tymon\JWTAuth\Exceptions\JWTException;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }
    public function register(StorePatientRequest $patient){

        try{
            $result=$this->patientService->registerPatient($patient->validated());

            return response()->json([
                "status"=> "success 🤗💛",
                "message"=> "successfully registration ✅",
                "data"=> [
                    'user'=>$result['user'],
                    'token'=>$result['token'],
                   'patient'=>$result['patient']  ]],201);

            }

                catch(\Exception $e){

                    return response()->json([
                     "status"=> "false 😑",

                      "error"=>'failed registeration 🙄 '.$e->getMessage()]);
                }
                }

     public function me(){
             $user=auth('api')->user();
            $patient=Patient::where('user_id',$user->id)->first();
            return [
                'user 💛✅'=> $user,
                'patient 🤧🤒'=>$patient
            ];

     }

   public function login(Request $request){

       $data=$request->only(['email','password']);

       $token=JWTAuth::attempt($data);

       if(!$token){

            return response()->json([
                'error'=>'something is wrong...🤔❌']);
       }
       $user=JWTAuth::user();

           return response()->json([
                'message'=>'welcome again...✅',
                'user'=>$user
            ]);

       }

       public function logout(){


          JWTAuth::invalidate(JWTAuth::getToken());

           return response()->json([
            'status'=> 'success 😎💛',
            'message'=> 'you are logged out successfully ..✅'
           ]);

       }

       public function refresh(Request $request){
        try {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'status' => 'error ❌',
                'message' => 'Token not provided or invalid format 😒'
            ], 401);
        }

            $token = str_replace('Bearer ', '', $authHeader);

          $new_token = JWTAuth::setToken($token)->refresh();

        return response()->json([
            'status' => 'success ✅',
            'token' => $new_token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);

    }
    catch (JWTException $e) {
        return response()->json([
            'status' => 'error ❌',
            'message' => 'Token refresh failed 😒',
            'error' => $e->getMessage()
        ], 401);
    }
}


    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $patient = $this->patientService->update($patient, $data);


        return response()->json([

            'message' => 'successfully updated 😊💛',
            'data'    => $patient
        ]);
    }

}
