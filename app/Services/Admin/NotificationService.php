<?php

namespace App\Services\Admin;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public function getAll()
    {
        return Notification::with('user')
            ->latest()
            ->get();
    }

    public function getUsers()
    {
        return User::all();
    }

    public function store(array $data)
    {
        return Notification::create($data);
    }

    public function update(Notification $notification, array $data)
    {
        $notification->update($data);
        return $notification;
    }

    public function delete(Notification $notification)
    {
        return $notification->delete();
    }
}