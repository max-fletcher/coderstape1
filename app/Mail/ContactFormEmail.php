<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormEmail extends Mailable
{
    use Queueable, SerializesModels;

//make entire $data array available to mail class without filtering
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
     // Constructor method is catching $data that is being sent just like mail
    public function __construct($data)
    {
        // Make a copy of the array/data sent
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact.contact-form');
    }
}
