<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodeAccesInspecteurGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $inspecteur;

    /**
     * Create a new message instance.
     *
     * @param $etablissement
     */
    public function __construct($inspecteur)
    {
        $this->inspecteur = $inspecteur;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: config('constants.mail.sujet') . ' Code d\'accès du compte Administrateur de votre IA/IEF',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */

    public function build()
    {
        return $this->view('emails.inspecteur_code_administrateur_compte');
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
