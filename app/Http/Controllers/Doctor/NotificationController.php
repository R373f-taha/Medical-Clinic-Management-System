<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Notification;

/**
 * Class NotificationController
 *
 * Handles doctor notification listing and read status.
 */
class NotificationController extends Controller
{
    /**
     * Display the latest notifications for the authenticated doctor.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get();

        return view('doctor.notifications.index', compact('notifications'));
    }

    /**
     * Mark the specified notification as read.
     *
     * @param Notification $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        // Update notification read status
        $notification->update(['is_read' => true]);

        return back();
    }
}
