<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth; // Import Auth

class ConferenceCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $conferenceTitle; // You can pass data to the Mailable

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conferenceTitle)
    {
        $this->conferenceTitle = $conferenceTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Conférence Créée : ' . $this->conferenceTitle)
            ->view('mail.conference_created') // Create this view
            ->with([
                'conferenceTitle' => $this->conferenceTitle,
                'userName' => Auth::user()->name, // Pass user name
            ]);
    }
}
