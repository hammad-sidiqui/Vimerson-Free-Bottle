<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncompleFormEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_data)
    {        
        $this->mail_data = $mail_data;        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('info@vimerson.com', 'Vimerson Health')
            ->subject('Your free supplements are waiting for you')
            ->markdown('email.incomplete_form_email')
            ->with('mail_data', $this->mail_data);
    }
}
