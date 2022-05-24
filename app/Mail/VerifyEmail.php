<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pin, $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $pin)
    {
        $this->pin = $pin;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Verify Email Address for Healthy First")->markdown('emails.verify');
    }
}
