<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::with('patient')->latest()->get();
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

        Rating::create($data);

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

        $rating->update($data);

        return redirect()->route('doctor.ratings.index')
            ->with('success', 'تم تعديل التقييم');
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();
        return back()->with('success', 'تم حذف التقييم');
    }
}
