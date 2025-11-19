<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ProgressReport extends Notification implements ShouldQueue
{
    use Queueable;
    public $content;

    /**
     * Create a new notification instance.
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'data' => json_encode($this->content),
        ];
    }

    public function toQueue($notifiable)
    {
        return [
            'data' => json_encode($this->content),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'data' => json_encode($this->content),
        ];
    }
}
