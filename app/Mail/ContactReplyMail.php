<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The contact instance.
     *
     * @var \App\Models\Contact
     */
    public $contact;

    /**
     * The reply instance.
     *
     * @var \App\Models\ContactReply
     */
    public $reply;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Contact  $contact
     * @param  \App\Models\ContactReply  $reply
     * @return void
     */
    public function __construct(Contact $contact, ContactReply $reply)
    {
        $this->contact = $contact;
        $this->reply = $reply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $mail = $this->subject('Re: ' . $this->contact->subject)
                    ->view('emails.contact-reply');

        if ($this->reply->attachment) {
            $mail->attach(storage_path('app/public/' . $this->reply->attachment), [
                'as' => $this->reply->attachment_name,
            ]);
        }

        return $mail;
    }
}
