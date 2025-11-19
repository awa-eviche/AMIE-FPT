<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationMenu extends Component
{
    public $linkActive = false;
    // public bool $chargeAll = false;
    public bool $chargeUnread = false;

    public function toggleChargeUnread(){
        $this->chargeUnread = !$this->chargeUnread;
    }

    public function render()
    {   $notification = null;
        if($this->chargeUnread){
            $notification = Auth::user()->unreadNotifications->take(10);
        }else
            $notification = Auth::user()->notifications->take(10);

        return view('livewire.notification-menu', [
            'unreadNotificationsCount' => Auth::user()->unreadNotifications->count(),
            'notifications' => $notification,
        ]);
    }
}
