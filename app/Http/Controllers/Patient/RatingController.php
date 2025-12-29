<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        return response()->json(Rating::latest()->get());
    }

    public function store(Request $request)
    {
      $data=  $request->validate([
            'doctor_id' => 'required|exists:doctor,id',
            'rating'    => 'required|numeric|min:1|max:5',
            'comment'   => 'nullable|string',
        ]);

        $rating = Rating::create($data);

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
            'comment'   => 'nullable|string',
        ]);

        $rating->update($data());

        return response()->json([
            'message' => 'تم تعديل التقييم',
            'data' => $rating
        ]);
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();

        return response()->json([
            'message' => 'تم حذف التقييم'
        ]);
    }
}
