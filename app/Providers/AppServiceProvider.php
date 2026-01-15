<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Rating;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {

            $view->with([
                'notifications' => collect(),
                'notificationsCount' => 0,
                'doctorNotifications' => collect(),
                'doctorUnreadCount' => 0,
            ]);

            if (!Auth::check()) return;

            $user = Auth::user();

            // إشعارات المدير
            if ($user->hasRole('clinicManager')) {
                $invoices = Invoice::with('patient')
                    ->where('status', 'paid')
                    ->orderBy('invoice_date', 'desc')
                    ->take(5)
                    ->get()
                    ->map(fn($invoice) => [
                        'type' => 'invoice',
                        'title' => 'Invoice Paid',
                        'message' => 'Patient ' . $invoice->patient->name . ' paid ' . $invoice->total_amount,
                        'date' => $invoice->invoice_date,
                        'link' => '#' // ضع الرابط الصحيح لاحقاً
                    ]);

                $ratings = Rating::with('doctor')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get()
                    ->map(fn($rating) => [
                        'type' => 'rating',
                        'title' => 'New Doctor Rating',
                        'message' => 'Dr. ' . $rating->doctor->name . ' received rating ' . $rating->rating,
                        'date' => $rating->created_at,
                        'link' => '#' // ضع الرابط الصحيح لاحقاً
                    ]);

                $allNotifications = $invoices->merge($ratings)->sortByDesc('date')->take(10);

                $view->with([
                    'notifications' => $allNotifications,
                    'notificationsCount' => $allNotifications->count(),
                ]);
            }

            // إشعارات الدكتور
            if ($user->hasRole('doctor') && $user->can('view notifications')) {
                $doctorNotifications = Notification::where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();

                $doctorUnreadCount = Notification::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                $view->with([
                    'doctorNotifications' => $doctorNotifications,
                    'doctorUnreadCount' => $doctorUnreadCount,
                ]);
            }
        });
    }
}
