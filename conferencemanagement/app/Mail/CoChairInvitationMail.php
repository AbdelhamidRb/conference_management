<?php
// app/Mail/CoChairInvitationMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoChairInvitationMail extends Mailable
{
use Queueable, SerializesModels;

public $user;
public $conference;

public function __construct($user, $conference)
{
$this->user = $user;
$this->conference = $conference;
}

public function build()
{
return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
->subject('Invitation en tant que co-président')
->view('mail.co_chair_invitation');
}
}