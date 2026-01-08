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
    public function index()
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->firstOrFail();

        $week = $this->weekRating();
        $stat = $this->statistics();


        $days = [];
        $today = Carbon::today();

        for ($i = 0; $i <= 6; $i++) {
            $days[] = $today->copy()->addDays($i)->format('l');
        }
        // $todayNumber = date('N');

        // for ($i = 0; $i < 7; $i++) {

        //     $date = date(
        //         'Y-m-d',
        //         strtotime("+" . $i . " days")
        //     );

        //     $dayName = date(
        //         'l',
        //         strtotime("+" . $i . " days")
        //     );

        //     $days[] = $dayName;
        // }
        // $stringWeek = implode(', ', $week);
        // $finalWeek = '[' . $stringWeek . ']';
        // $stringDays = implode(',', $days);
        // $finalDays = '[' . $stringDays . ']';

        $finalWeek = json_encode($week);
        $finalDays = json_encode($days);
        $finalStat = json_encode($stat);
        return view('dashboard', compact('doctor', 'finalDays', 'finalWeek', 'finalStat'));
    }

    public function weekRating()
    {
        $week = [];
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->firstOrFail();

        for ($i = 7; $i >= 1; $i--) {
            $date = Carbon::today()->subDays($i);
            $ratings = Rating::where('doctor_id', $doctor->id)
                ->where('date', $date)
                ->get();

            $avgRating = $ratings->count() > 0
                ? $ratings->avg('rating')
                : 0;
            $week[] = $avgRating;
        }
        return $week;
    }

    public function statistics()
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->firstOrFail();
        $stat = [];
        for ($i = 0; $i < 5; $i++) {
            $stat[] = Rating::where('doctor_id', $doctor->id)->where('rating', $i + 1)->count('*');
        }
        return $stat;
    }
}
