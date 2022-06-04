<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Login extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $time;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $time)
    {
        $this->name = $name;
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.notification-login');
    }
}
