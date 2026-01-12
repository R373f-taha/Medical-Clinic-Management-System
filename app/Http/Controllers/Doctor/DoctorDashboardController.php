<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Rating;
use Carbon\Carbon;
use Carbon\Traits\ToStringFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{



     public function DoctorRate($doctor_id){//the result should be in the blade section

         $doctor = Doctor::find($doctor_id);

    // if (!$doctor) {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'doctor doesn`t exist'
    //     ], 404);
    // }

    $averageRating = Rating::where('doctor_id', $doctor_id)->avg('rating');
    $totalRatings = Rating::where('doctor_id', $doctor_id)->count();

     }

}
