<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRateRequest;
use App\Http\Requests\UpdateRateRequest;
use App\Models\Rating;
use App\Services\Patient\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function index()
    {
        return response()->json($this->ratingService->getAll());
    }

    public function store(StoreRateRequest $request)
    {
        $data =  $request->validated();

        $rating = $this->ratingService->store($data);

        return response()->json([
            'message' => 'تم إضافة التقييم',
            'data' => $rating
        ]);
    }

    public function show(Rating $rating)
    {
        return response()->json($rating);
    }

    public function update(UpdateRateRequest $request, Rating $rating)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $rating = $this->ratingService->update($rating, $data);

        return response()->json([
            'message' => 'تم تعديل التقييم',
            'data'    => $rating
        ]);
    }


    public function destroy(Rating $rating)
    {
        $this->ratingService->delete($rating);

        return response()->json([
            'message' => 'تم حذف التقييم'
        ]);
    }
}
