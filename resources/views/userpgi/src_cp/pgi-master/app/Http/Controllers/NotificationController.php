<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index(bool $onlyUnread = true)
    {
        if ($onlyUnread) {
            $notifications = auth()->user()->unreadNotifications()->paginate(20);
        } else {
            $notifications = auth()->user()->notifications()->paginate(20);
        }
        return view('notifications.index', compact('notifications', 'onlyUnread'));
    }

    public function allNotificaions()
    {
        return $this->index(false);
    }
}
