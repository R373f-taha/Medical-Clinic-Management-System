<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Notification;
use App\Models\User;
use App\Services\Admin\NotificationService;
use Illuminate\Http\Request;

/**
 * Class NotificationController
 *
 * Handles admin notification management.
 */
class NotificationController extends Controller
{
    /**
     * Notification service instance.
     *
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * Create a new controller instance.
     *
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of notifications.
     *
     * @return void
     */
    public function index()
    {
        $notifications = $this->notificationService->getAll();
    }

    /**
     * Show the form for creating a new notification.
     *
     * @return void
     */
    public function create()
    {
        $users = $this->notificationService->getUsers();
    }

    /**
     * Store a newly created notification.
     *
     * @param StoreNotificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreNotificationRequest $request)
    {
        $data = $request->validated();

        $this->notificationService->store($data);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification sent successfully');
    }

    /**
     * Display the specified notification.
     *
     * @param Notification $notification
     * @return void
     */
    public function show(Notification $notification) {}

    /**
     * Show the form for editing the specified notification.
     *
     * @param Notification $notification
     * @return void
     */
    public function edit(Notification $notification)
    {
        $users = $this->notificationService->getUsers();
    }

    /**
     * Update the specified notification.
     *
     * @param UpdateNotificationRequest $request
     * @param Notification $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $data = array_filter(
            $request->validated(),
            fn ($value) => !is_null($value)
        );

        $this->notificationService->update($notification, $data);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification updated successfully');
    }

    /**
     * Delete the specified notification.
     *
     * @param Notification $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Notification $notification)
    {
        $this->notificationService->delete($notification);

        return back()->with('success', 'Notification deleted successfully');
    }
}
