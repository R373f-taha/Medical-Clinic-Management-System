<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{

    public function index()
    {
        $profits = $this->profits();
        $patients = $this->patientsperClinic();
        $status = $this->appointmentsStatusStats();
        return view("dashboard", compact(["profits", "patients", "status"]));
    }
    // public function profits()
    // {
    //     $profits = [];

    //     $startOfMonth = Carbon::now()->startOfMonth();
    //     $endOfMonth = Carbon::now()->endOfMonth();

    //     $weeks = [];
    //     $currentStart = $startOfMonth->copy();
    //     while ($currentStart <= $endOfMonth) {
    //         $currentEnd = $currentStart->copy()->endOfWeek();
    //         if ($currentEnd > $endOfMonth) {
    //             $currentEnd = $endOfMonth->copy();
    //         }
    //         $weeks[] = ['start' => $currentStart->copy(), 'end' => $currentEnd->copy()];
    //         $currentStart = $currentEnd->addDay();
    //     }

    //     foreach ($weeks as $week) {
    //         $profits[] = Invoice::whereBetween('invoice_date', [$week['start'], $week['end']])
    //             ->where('status', 'paid')->sum('total_amount');
    //     }

    //     return json_encode($profits);
    // }

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
}
