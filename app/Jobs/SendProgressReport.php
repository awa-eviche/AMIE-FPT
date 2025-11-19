<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\ProgressReport;
use Illuminate\Support\Facades\Notification;

class SendProgressReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // protected $notifiable;
    protected $content;
    protected $destinataires;

    /**
     * Create a new job instance.
     */
    /*public function __construct($notifiable, $content)
    {
        $this->notifiable = $notifiable;
        $this->content = $content;
    }*/

    public function __construct($content, $destinataires)
    {
        $this->content = $content;
        $this->destinataires = $destinataires;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
       //$notifiable = $this->notifiable;
        $content = $this->content;

      //  $notifiable->notify(new ProgressReport($content));
        Notification::send($this->destinataires, new ProgressReport($this->content));
    }
}
