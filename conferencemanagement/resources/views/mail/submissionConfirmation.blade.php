<!DOCTYPE html>
<html>

<head>
    <title>Submission Confirmation</title>
</head>

<body>
    <p>Dear {{ $author->firstName }} {{ $author->lastName }},</p>

    <p>We are pleased to inform you that your submission to {{ $conference->title }} has been received successfully.</p>

    <p>Submission Details:</p>
    <ul>
        <li><strong>Submission ID:</strong> {{ $submission->idSubmission }}</li>
        <li><strong>Title:</strong> {{ $submission->titre }}</li>
        <li><strong>Submission Date:</strong> {{ $submission->created_at->format('Y-m-d H:i:s') }}</li>
    </ul>

    <p>Please keep your submission ID for future reference. You will be notified when the review process is complete.</p>

    <p>Thank you for your submission.</p>

    <p>Best regards,<br>
        The Conference Committee</p>
</body>

</html>