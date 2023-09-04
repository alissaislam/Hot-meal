<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
     use Queueable, SerializesModels;


    /**
     * Create a new message instance.
    //  */
    // public function __construct()
    // {

    // }

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Otp Mail',
    //         from: new Address('islam.2002820qwert@gmail.com','Islam')

    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'emails.welcom',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
public $data=[];

    public function __construct($data)
    {

        $this->data=$data;

    }

    public function build()
    {
        return $this->from('islam@gmail','Islam')->subject($this->data['subject'])->view('emails.welcome')->with('data',$this->data);
                
    }
}
