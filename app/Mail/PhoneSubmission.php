<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PhoneSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $phone;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $phone
     */
    public function __construct($name, $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Оставили номер телефона')
            ->view('emails.phoneSubmission');
    }
}
