<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodeAccesApprenantGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $apprenant;

    /**
     * Create a new message instance.
     *
     * @param $apprenant
     */
    public function __construct($apprenant)
    {
        $this->apprenant = $apprenant;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: config('constants.mail.sujet') . ' Code d\'accès du compte Administrateur de votre établissement',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */

    public function build()
    {
        return $this->view('emails.apprenant_code_administrateur_compte');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
