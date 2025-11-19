<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuppressionAccesEtablissement extends Mailable
{
    use Queueable, SerializesModels;

    public $etablissement;

    /**
     * Create a new message instance.
     *
     * @param $etablissement
     */
    public function __construct($etablissement)
    {
        $this->etablissement = $etablissement;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: config('constants.mail.sujet') . 'Notification de suppression de compte',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */

    public function build()
    {
        return $this->view('emails.suppression_acces_etablissement');
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
