<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Services\Admin\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
          $notifications = $this->notificationService->getAll();
    }

 
    public function create()
    {
        $users = $this->notificationService->getUsers();
    }

 
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);


        $this->notificationService->store($data);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'تم إرسال الإشعار بنجاح');
    }


    public function show(Notification $notification)
    {
    }


    public function edit(Notification $notification)
    {
        $users = $this->notificationService->getUsers();
    }


    public function update(Request $request, Notification $notification)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->notificationService->update($notification, $data);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'تم تعديل الإشعار');
    }

    /**
     * حذف الإشعار
     */
    public function destroy(Notification $notification)
    {
        $this->notificationService->delete($notification);
        return back()->with('success', 'تم حذف الإشعار');
    }
}
