<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    // صفحة قائمة الإشعارات
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get();

        return view('doctor.notifications.index', compact('notifications'));
    }

    // تعليم كمقروء
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        return back();
    }
}
