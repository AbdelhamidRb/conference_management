<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class PcMemberInvitationMail extends Mailable
{
    use SerializesModels;

    public $user;
    public $conference;
    public $invitationLink; // Changed $token to $invitationLink

    public function __construct($user, $conference, $invitationLink) // Updated constructor parameter
    {
        $this->user = $user;
        $this->conference = $conference;
        $this->invitationLink = $invitationLink; // Assign the link
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation à rejoindre la conférence',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.pc-member-invitation-mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
