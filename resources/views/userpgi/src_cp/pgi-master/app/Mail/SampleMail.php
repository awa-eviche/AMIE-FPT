<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class SampleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $files;

    /**
     * Create a new message instance.
     *
     * @param $content
     * @param $files
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: config('constants.mail.sujet') . 'Traitement en cours...',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */

    public function build()
    {
    //    return $this->view('emails.sample_mail')->attachments();
            return $this->view('emails.sample_mail')
            ->subject(config('constants.mail.sujet') . 'Traitement en cours...')
            ->attachments();
      // return $this->view('emails.sample_mail');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    // public function attachments(): array
    // {
    //     $arr = [];
    //     if($this->content['files'] != NULL)
    //     {
    //         foreach ($this->content['files'] as $file) {
    //            /* $this->attach(public_path($file), [
    //                 'as' => $file->getClientOriginalName(),
    //                 'mime' => $file->getClientMimeType(),
    //             ]);*/

    //             $arr =  $this->attach($file, [
    //                 'as' => '*',
    //                 'mime' => '*',
    //             ]);
    //         }
    //     }
    //     return $arr;

    // }

    public function attachments(): array
    {
        $attachments = [];

        if ($this->content['files'] !== null) {
            foreach ($this->content['files'] as $file) {
                $attachments[] = Attachment::fromPath(storage_path($file));
            }
        }

        return $attachments;
    }

    // protected function attachFiles()
    // {
    //     if ($this->content['files'] !== null) {
    //         foreach ($this->content['files'] as $file) {
    //             $this->attach(
    //                 $file->getRealPath(),
    //                 [
    //                     'as' => $file->getClientOriginalName(),
    //                     'mime' => $file->getClientMimeType(),
    //                 ]
    //             );
    //         }
    //     }

    //     return $this;
    // }
}
