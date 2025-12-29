<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('user')->latest()->get();
    }

 
    public function create()
    {
        $users = User::all();
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Notification::create([
            'title'   => $request->title,
            'message' => $request->message,
            'user_id' => $request->user_id,
        ]);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'تم إرسال الإشعار بنجاح');
    }


    public function show(Notification $notification)
    {
    }


    public function edit(Notification $notification)
    {
        $users = User::all();
    }


    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $notification->update([
            'title'   => $request->title,
            'message' => $request->message,
            'user_id' => $request->user_id,
        ]);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'تم تعديل الإشعار');
    }

    /**
     * حذف الإشعار
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'تم حذف الإشعار');
    }
}
