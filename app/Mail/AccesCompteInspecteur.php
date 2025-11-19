<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccesCompteInspecteur extends Mailable
{
    use Queueable, SerializesModels;

    public $inspecteur;

    /**
     * Create a new message instance.
     *
     * @param $inspecteur
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
            subject: config('constants.mail.sujet') . 'Statut d\'accès au compte de votre inspection',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */

    public function build()
    {
        return $this->view('emails.acces_compte_inspecteur');
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
