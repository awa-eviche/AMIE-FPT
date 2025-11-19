<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Events\RealTimeNotificationEvent;
use App\Notifications\ProgressReport;
use App\Jobs\SendProgressReport;



class NotificationListener
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
    public function handle(RealTimeNotificationEvent $event): void
    {
      //  Notification::send($event->content['destinataires'], new ProgressReport($event->content));
      SendProgressReport::dispatch($event->content, $event->content['destinataires']);
    }
}
