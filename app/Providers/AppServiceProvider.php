<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use App\Models\Invoice;
use App\Models\Rating;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {View::composer('*', function ($view) {

        // قيم افتراضية لكل المستخدمين
        $view->with([
            'notifications' => collect(),
            'notificationsCount' => 0,
        ]);
    
        if (!auth()->check()) {
            return;
        }
    
        // Admin only
        if (auth()->user()->hasRole('clinicManager')) {
    
            /* ======================
               Invoice Notifications
            ====================== */
            $invoices = Invoice::with('patient')
                ->where('status', 'paid')
                ->orderBy('invoice_date', 'desc')
                ->take(5)
                ->get()
                ->map(function ($invoice) {
                    return [
                        'type' => 'invoice',
                        'title' => 'Invoice Paid',
                        'message' => 'Patient ' . $invoice->patient->user->name .
                                     ' paid an amount of ' . $invoice->total_amount,
                        'date' => $invoice->invoice_date,
                    ];
                });
    
            /* ======================
               Rating Notifications
            ====================== */
            $ratings = Rating::with('doctor')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($rating) {
                    return [
                        'type' => 'rating',
                        'title' => 'New Doctor Rating',
                        'message' => 'Dr. ' . $rating->doctor->user->name .
                                     ' received a rating of ' . $rating->rating,
                        'date' => $rating->created_at,
                    ];
                });
    
            $notifications = $invoices
                ->merge($ratings)
                ->sortByDesc('date')
                ->take(10);
    
            $view->with([
                'notifications' => $notifications,
                'notificationsCount' => $notifications->count(),
            ]);
        }
    });
}
}
