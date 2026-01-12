<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole("clinicManager")){
        $profits = $this->profits();
        $patients = $this->patientsperClinic();
        $status = $this->appointmentsStatusStats();
        return view("dashboard", compact(["profits", "patients", "status"]));
        }else if(Auth::user()->hasRole("doctor")){
                    $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->firstOrFail();

        $week = $this->weekRating();
        $stat = $this->statistics();


        $days = [];
        $today = Carbon::today();

        for ($i = 0; $i <= 6; $i++) {
            $days[] = $today->copy()->addDays($i)->format('l');
        }


        $finalWeek = json_encode($week);
        $finalDays = json_encode($days);
        $finalStat = json_encode($stat);
        return view('dashboard', compact('doctor', 'finalDays', 'finalWeek', 'finalStat'));
        }else if(Auth::user()->hasRole('employee')){
            return view('dashboard');
        }
    }

    public function profits()
    {
        $profits = [];

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $weeks = [];
        $currentStart = $startOfMonth->copy();

        while ($currentStart <= $endOfMonth) {
            $currentEnd = $currentStart->copy()->addDays(6);

            if ($currentEnd > $endOfMonth) {
                $currentEnd = $endOfMonth->copy();
            }

            $weeks[] = ['start' => $currentStart->copy(), 'end' => $currentEnd->copy()];

            $currentStart = $currentEnd->addDay();
        }

        foreach ($weeks as $week) {
            $profits[] = Invoice::whereBetween('invoice_date', [$week['start'], $week['end']])
                ->where('status', 'paid')->sum('total_amount');
        }

        return json_encode($profits);
    }

    public function patientsperClinic()
    {
        $specializations = [
            'Dentistry',
            'Pediatrics',
            'Ophthalmology',
            'Dermatology'
        ];

        $stats = DB::table('doctors')
            ->join('appointments', 'doctors.id', '=', 'appointments.doctor_id')
            ->whereNotNull('appointments.patient_id')
            ->select(
                'doctors.specialization',
                DB::raw('COUNT(DISTINCT appointments.patient_id) as patients_count')
            )
            ->groupBy('doctors.specialization')
            ->get()
            ->keyBy('specialization');

        $result = [];
        foreach ($specializations as $spec) {
            $result[] = $stats[$spec]->patients_count ?? 0;
        }

        return json_encode($result);
    }
    public function appointmentsStatusStats()
    {
        $statuses = [
            'completed',
            'scheduled',
            'cancelled'
        ];

        $counts = Appointment::select('status', DB::raw('COUNT(*) as total'))
            ->whereIn('status', $statuses)
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $result = [];
        foreach ($statuses as $status) {
            $result[] = $counts[$status]->total ?? 0;
        }

        return json_encode($result);
    }
    ///////////////////////////////////////////////////////////////////////////////////////////
    // public function index()
    // {
    //     $user = Auth::user();
    //     $doctor = Doctor::where('user_id', $user->id)->firstOrFail();

    //     $week = $this->weekRating();
    //     $stat = $this->statistics();


    //     $days = [];
    //     $today = Carbon::today();

    //     for ($i = 0; $i <= 6; $i++) {
    //         $days[] = $today->copy()->addDays($i)->format('l');
    //     }


    //     $finalWeek = json_encode($week);
    //     $finalDays = json_encode($days);
    //     $finalStat = json_encode($stat);
    //     return view('dashboard', compact('doctor', 'finalDays', 'finalWeek', 'finalStat'));
    // }

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
