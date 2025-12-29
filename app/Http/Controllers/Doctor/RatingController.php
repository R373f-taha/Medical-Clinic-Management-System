<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Services\Doctor\RatingService;
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
           $ratings = $this->ratingService->getAll();
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
       $data= $request->validate([
            'patient_id' => 'required|exists:users,id',
            'rating'     => 'required|numeric|min:1|max:5',
            'comment'    => 'nullable|string',
        ]);

        $this->ratingService->store($data);

        return redirect()->route('doctor.ratings.index')
            ->with('success', 'تم إضافة التقييم بنجاح');
    }

    public function show(Rating $rating)
    {
    }

    public function edit(Rating $rating)
    {
    }

    public function update(Request $request, Rating $rating)
    {
       $data= $request->validate([
            'patient_id' => 'required|exists:users,id',
            'rating'     => 'required|numeric|min:1|max:5',
            'comment'    => 'nullable|string',
        ]);

        $this->ratingService->update($rating, $data);

        return redirect()->route('doctor.ratings.index')
            ->with('success', 'تم تعديل التقييم');
    }

    public function destroy(Rating $rating)
    {
        $this->ratingService->delete($rating);
        return back()->with('success', 'تم حذف التقييم');
    }
}
