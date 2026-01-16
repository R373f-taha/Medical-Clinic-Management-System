<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Rating;
use App\Models\Appointment;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {

            $bellNotifications = collect();
            $bellUnreadCount = 0;

            if (!Auth::check()) {
                $view->with(compact('bellNotifications', 'bellUnreadCount'));
                return;
            }

            $user = Auth::user();

            // ================== Clinic Manager (Invoices + Ratings) ==================
            if ($user->hasRole('clinicManager')) {

                $invoices = Invoice::with('patient.user')
                    ->where('status', 'paid')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn ($i) => [
                        'type' => 'invoice',
                        'title' => 'Paid Invoice',
                        'date' => $i->created_at,
                        'patient' => $i->patient->user->name ?? '---',
                        'amount'  => $i->total_amount,
                        'status'  => $i->status,
                        'details' => 'Invoice paid: ' . $i->total_amount,
                    ]);

                $ratings = Rating::with('doctor.user')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn ($r) => [
                        'type' => 'rating',
                        'title' => 'New Rating',
                        'date' => $r->created_at,
                        'doctor' => $r->doctor->user->name ?? '---',
                        'rating' => $r->rating,
                        'comment'=> $r->comment ?? 'No comment',
                        'details'=> 'Doctor rated: ' . $r->rating,
                    ]);

                $bellNotifications = $invoices
                    ->merge($ratings)
                    ->sortByDesc('date')
                    ->values();

                $bellUnreadCount = $bellNotifications->count();
            }

            // ================== Doctor (Appointments) ==================
            if ($user->hasRole('doctor')) {

                $appointments = Appointment::with(['patient.user'])
                    ->where('doctor_id', $user->doctor->id)
                    ->latest()
                    ->take(10)
                    ->get()
                    ->map(fn ($a) => [
                        'type' => 'appointment',
                        'title' => 'Book an Appointment',
                        'date' => $a->created_at,  // للإشعارات فقط
                        'patient' => $a->patient->user->name ?? '---',
                        'appointment_date' => $a->appointment_date, // هذا التاريخ الوحيد
                        'reason' => $a->reason ?? '---',
                        'status' => $a->status,
                        'details'=> '', // أي ملاحظات إضافية يمكن تركها فارغة
                    ]);

                $bellNotifications = $appointments;
                $bellUnreadCount  = $appointments->count();
            }

            $view->with(compact('bellNotifications', 'bellUnreadCount'));
        });
    }
}
