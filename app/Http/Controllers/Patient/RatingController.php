<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
      $data=  $request->validate([
          'doctor_id' => 'required|exists:doctor,id',
            'rating'    => 'required|numeric|min:1|max:5',
            'notes'     => 'nullable|string',
        ]);

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

    public function update(Request $request, Rating $rating)
    {
       $data= $request->validate([
            'doctor_id' => 'required|exists:doctor,id',
            'rating'    => 'required|numeric|min:1|max:5',
            'notes'     => 'nullable|string',
        ]);

        $rating = $this->ratingService->update($rating, $data);


        return response()->json([
            'message' => 'تم تعديل التقييم',
            'data' => $rating
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
