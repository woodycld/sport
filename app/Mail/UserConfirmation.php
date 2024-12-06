<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    public function build()
    {
        return $this->subject('Спасибо за вашу заявку!')
            ->view('emails.confirmation');
    }
}
