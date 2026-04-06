<?php

namespace App\Mail;

use App\Models\Submission;
use App\Models\Conference;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $author;
    public $submission;
    public $conference;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $author, Submission $submission, Conference $conference)
    {
        $this->author = $author;
        $this->submission = $submission;
        $this->conference = $conference;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Submission Confirmation - " . $this->conference->nom)
            ->view('mail.submissionConfirmation');
    }
}
