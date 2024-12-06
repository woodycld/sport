<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $messages;

    public function __construct($name, $email, $messages)
    {
        $this->name = (string) $name;
        $this->email = (string) $email;
        $this->messages = (string) $messages;
    }

    public function build()
    {
        return $this->subject('Новая заявка с сайта')
            ->view('emails.contactform');
    }
}
