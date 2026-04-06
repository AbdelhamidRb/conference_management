<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DecisionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $customizedBody;
    public $conference;

    /**
     * Create a new message instance.
     */
    public function __construct($subjectLine, $customizedBody, $conference = null)
    {
        $this->subjectLine = $subjectLine;
        $this->customizedBody = $customizedBody;
        $this->conference = $conference;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('mail.authorNotification')
                    ->with([
                        'body' => $this->customizedBody,
                        'conference' => $this->conference,
                    ]);
    }
}
