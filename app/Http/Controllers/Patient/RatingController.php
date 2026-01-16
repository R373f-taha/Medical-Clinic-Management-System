<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreRateRequest;
use App\Http\Requests\UpdateRateRequest;
use App\Services\Patient\AppointmentService;
use App\Models\Doctor;
use App\Models\Rating;
use App\Services\Patient\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * The rating service instance.
     */
    protected $ratingService;

    /**
     * The appointment service instance.
     */
    protected $appointmentService;

    /**
     * Constructor for dependency injection.
     *
     * @param RatingService $ratingService
     * @param AppointmentService $appointmentService
     */
    public function __construct(RatingService $ratingService, AppointmentService $appointmentService)
    {
        $this->ratingService = $ratingService;
        $this->appointmentService = $appointmentService;
    }

    /**
     * Retrieves all ratings.
     *
     * @return \Illuminate\Http\JsonResponse List of all ratings
     */
    public function index()
    {
        return response()->json($this->ratingService->getAll());
    }

    /**
     * Creates a new rating for a doctor by authenticated patient.
     *
     * @param StoreRateRequest $request Validated rating data
     * @return \Illuminate\Http\JsonResponse Rating creation result
     */
    public function addRating(StoreRateRequest $request)
    {
        $check = $this->appointmentService->checkPatientAccess($request, 'api:create rating');
        if ($check) return $check;

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error 😑',
                'message' => 'Register First 🙄'
            ], 401);
        }

        if (!$user->patient) {
            return response()->json([
                'message' => 'you must be a patient person to add rating 😑',
                'instruction' => 'make a patient account 🧐'
            ], 403);
        }

        $patient = $user->patient;
        $validatedData = $request->validated();

        $ratingData = array_merge($validatedData, [
            'patient_id' => $patient->id,
            'date' => $validatedData['date'] ?? now()->format('Y-m-d')
        ]);

        // Check if patient already rated this doctor
        $existingRating = Rating::where('patient_id', $patient->id)
            ->where('doctor_id', $validatedData['doctor_id'])
            ->first();

        if ($existingRating) {
            return response()->json([
                'status' => 'error 🔄',
                'message' => "You have already rated this doctor.😑",
                'existing_rating' => [
                    'rating' => $existingRating->rating,
                    'date' => $existingRating->date
                ],
                'action' => "You can update your existing rating instead of creating a new one.😊"
            ], 409);
        }

        $rating = Rating::create($ratingData);
        return response()->json([
            'status' => 'success ✅',
            'message' => 'added rating successfully⭐',
            'rating' => $rating
        ], 201);
    }

    /**
     * Shows details of a specific rating.
     *
     * @param Rating $rating Rating model instance
     * @return \Illuminate\Http\JsonResponse Rating details
     */
    public function show(Rating $rating)
    {
        return response()->json($rating);
    }

    /**
     * Updates an existing rating.
     *
     * @param UpdateRateRequest $request Validated update data
     * @param Rating $rating Rating model to update
     * @return \Illuminate\Http\JsonResponse Updated rating data
     */
    public function update(UpdateRateRequest $request, Rating $rating)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));
        $rating = $this->ratingService->update($rating, $data);

        return response()->json([
            'message' => 'rating updated',
            'data' => $rating
        ]);
    }

    /**
     * Deletes a rating.
     *
     * @param Rating $rating Rating model to delete
     * @return \Illuminate\Http\JsonResponse Deletion confirmation
     */
    public function destroy(Rating $rating)
    {
        $this->ratingService->delete($rating);

        return response()->json([
            'message' => 'rating deleted'
        ]);
    }
}
