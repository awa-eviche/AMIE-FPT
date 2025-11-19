<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $newPassword;

    public function __construct($user, $newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }

    public function build()
    {
        return $this->subject('Votre mot de passe a été réinitialisé')
                    ->view('emails.reset-password')
                    ->with([
                        'user' => $this->user,
                        'newPassword' => $this->newPassword,
                        'loginUrl' => url('/login'),
                    ]);
    }
}
