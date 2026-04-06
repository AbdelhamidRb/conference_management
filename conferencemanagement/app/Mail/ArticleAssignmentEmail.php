<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Conference;

class ArticleAssignmentEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The email subject
     */
    

    /**
     * The email message content
     */
    public string $message;

    /**
     * The conference instance
     */
    public Conference $conference;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subject, string $message, Conference $conference)
    {
        $this->subject($subject);
        $this->message = $message;
        $this->conference = $conference;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.article-assignement',
            with: [
                'content' => $this->message,
                'conference' => $this->conference,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}