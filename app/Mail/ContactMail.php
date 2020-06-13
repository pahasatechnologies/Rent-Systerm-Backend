<?php

namespace App\Mail;

use App\ContactUS;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactUS $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->subject($this->contact->subject)
            ->from($this->contact->email)
            ->to(env('ADMIN_EMAIL'))
            ->markdown("Email.contact");
        // return $this->markdown("Email.contact")->with(['contact' => $this->contact]);
    }
}
