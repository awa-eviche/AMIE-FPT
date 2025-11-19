<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ProgressReport;
use Illuminate\Support\Facades\Log;


class RealTimeNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public array $content;

    public function __construct(array $content)
    {
        $this->content = $content;
        Log::info('RealTimeNotificationEvent constructed:', $content);
    }

    public function broadcastOn()
    {
        return new Channel('real-time-notifications');
    }

    public function broadcastAs() { 
        return 'RealTimeNotificationEvent'; 
    }
}
