<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Storage;

class ContactFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public string $adminUrl;

    /**
     * The contact instance.
     *
     * @var \App\Models\Contact
     */
    public Contact $contact;

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
        $this->adminUrl = route('admin.contacts.index');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouveau message de contact: ' . $this->contact->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */

    public function attachments(): array
    {
        if ($this->contact->attachment && Storage::disk('public')->exists($this->contact->attachment)) {
            return [
                Attachment::fromStorageDisk('public', $this->contact->attachment)
                    ->as($this->contact->attachment_name)
                    ->withMime('application/octet-stream'),
            ];
        }

        return [];
    }

}
