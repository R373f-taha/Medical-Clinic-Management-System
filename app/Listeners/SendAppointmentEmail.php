<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use App\Mail\AppointmentMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAppointmentEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentCreated $event): void
    {
        Mail::to($event->appointment->patient->email)->send(new AppointmentMail($event->appointment,'new'));
    }
}
