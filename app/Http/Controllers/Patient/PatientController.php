<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\User;
use App\Services\Patient\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class PatientController extends Controller
{
    /**
     * The patient service instance for business logic.
     */
    protected $patientService;

    /**
     * Constructor for dependency injection.
     *
     * @param PatientService $patientService
     */
    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * Registers a new patient in the system.
     *
     * @param StorePatientRequest $patient Validated patient data
     * @return \Illuminate\Http\JsonResponse Registration result with token
     */
    public function register(StorePatientRequest $patient)
    {
        try {
            $result = $this->patientService->registerPatient($patient->validated());

            return response()->json([
                "status" => "success 🤗💛",
                "message" => "successfully registration ✅",
                "data" => [
                    'user' => $result['user'],
                    'token' => $result['token'],
                    'patient' => $result['patient']
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "status" => "false 😑",
                "error" => 'failed registeration 🙄 ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Returns the currently authenticated patient's profile.
     *
     * @return array Authenticated user and patient data
     */
    public function me()
    {
        $user = auth('api')->user();
        $patient = Patient::where('user_id', $user->id)->first();

        return [
            'user 💛✅' => $user,
            'patient 🤧🤒' => $patient
        ];
    }

    /**
     * Authenticates a patient and returns a JWT token.
     *
     * @param Request $request Login credentials
     * @return \Illuminate\Http\JsonResponse Authentication result
     */
    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']);
        $token = JWTAuth::attempt($data);

        if (!$token) {
            return response()->json([
                'error' => 'something is wrong...🤔❌'
            ]);
        }

        $user = JWTAuth::user();

        return response()->json([
            'message' => 'welcome again...✅',
            'user' => $user
        ]);
    }

    /**
     * Logs out the current patient by invalidating the JWT token.
     *
     * @return \Illuminate\Http\JsonResponse Logout confirmation
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'status' => 'success 😎💛',
            'message' => 'you are logged out successfully ..✅'
        ]);
    }

    /**
     * Refreshes the current JWT token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse New token or error
     */
    public function refresh(Request $request)
    {
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
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error ❌',
                'message' => 'Token refresh failed 😒',
                'error' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Updates patient profile information.
     *
     * @param UpdatePatientRequest $request Validated update data
     * @param Patient $patient Patient model to update
     * @return \Illuminate\Http\JsonResponse Updated patient data
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));
        $patient = $this->patientService->update($patient, $data);

        return response()->json([
            'message' => 'successfully updated 😊💛',
            'data' => $patient
        ]);
    }
}
