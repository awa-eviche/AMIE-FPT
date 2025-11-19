<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Enums\TypeNotification;
use App\Enums\TopicNotificationEnum;

use App\Notifications\ProgressReport;
use App\Mail\SampleMail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendProgressReport;
use App\Events\RealTimeNotificationEvent;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendEmailJob;




class NotificationService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * The params required are following like this:
     *
     * @var array<User>,
     * @var message,
     * @var type
     */
    public function sendNotification($destinataires, $message, $type = TypeNotification::EMAIL, $topic = TopicNotificationEnum::DEMANDE, $objects = null, $files = null)
    {
        if ($type == TypeNotification::SYSTEME) {
            $content['message'] = $message;
            $content['notificationCount'] = auth()->user()->unreadNotifications->count() + 1 ;
            $content['destinataires'] = $destinataires;
            $content['topic'] = $topic;
            $content['objects'] = json_encode($objects);
            event(new RealTimeNotificationEvent($content));

        } else if ($type == TypeNotification::EMAIL) {
            foreach ($destinataires as $user) {
               
                $content['identite'] = $user['identite'];
                $content['message'] = $message;
                $content['files'] = $files;
                if(isset($objects) && $objects['type'] == "demande")
                {
                    $content['id'] = $objects['entity'];
                    $content['type'] = $objects['type'];
                }

               // Mail::to()->send(new SampleMail($content));
                SendEmailJob::dispatch($user['email'], $content);
            }
        }
    }
}
