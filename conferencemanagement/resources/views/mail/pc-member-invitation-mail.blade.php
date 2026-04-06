<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation to Join the Scientific Committee of {{ $conference->title }}</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 0 auto;">
        <h2 style="color: #007bff; margin-top: 0;">Invitation to Join the Scientific Committee of {{ $conference->title }}</h2>
        <p>Dear {{ $user->firstName }} {{ $user->lastName }},</p>
        <p>We are pleased to invite you to join the Scientific Committee of the "<strong>{{ $conference->title }}</strong>" conference. Your expertise and contribution would be invaluable to the success of this event.</p>
        <p>To accept or decline this invitation, please click the link below:</p>
        <p>
            <a href="{{ $invitationLink }}" style="color: #ffffff; background-color: #28a745; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;">Accept or Decline Invitation</a>
        </p>
        <p>If the link above does not work, you can copy and paste the following URL into your browser:</p>
        <p><a href="{{ $invitationLink }}" style="color: #007bff; text-decoration: underline;">{{ $invitationLink }}</a></p>
        <p>Thank you for considering this invitation. We hope to have you as a member of our Scientific Committee.</p>
        <p>Sincerely,</p>
        <p>The Organizing Committee of the "{{ $conference->title }}" Conference</p>
        <p style="font-size: 0.8em; color: #777777;">This is an automated email. Please do not reply directly to this message.</p>
    </div>
</body>

</html>