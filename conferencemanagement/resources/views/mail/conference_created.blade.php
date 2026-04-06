<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Created</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            color: #0056b3;
            text-align: center;
            margin-bottom: 30px;
        }

        p {
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .highlight {
            font-weight: bold;
            color: #0056b3;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777777;
            font-size: 0.9em;
        }

        .footer a {
            color: #0056b3;
            text-decoration: none;
        }

        .logo {
            display: block;
            margin: 0 auto 30px;
            max-width: 150px;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ asset('images/logo-fst.png') }}" alt="FSTconference Logo" class="logo">
        <h1>Conference Created Successfully</h1>
        <p>Dear <span class="highlight">{{ $userName }}</span>,</p>
        <p>We are pleased to inform you that your conference titled "<span class="highlight">{{ $conferenceTitle }}</span>" has been successfully created on the FSTconference platform.</p>
        <p>This marks the beginning of your journey in organizing a great event. You can now manage various aspects of the conference, such as paper submissions, participant management, and session scheduling.</p>
        <p>If you need any assistance or have questions, our support team is here to help. Please feel free to reach out by replying to this email.</p>
        <p>Thank you for choosing FSTconference to host your event.</p>
        <div class="footer">
            <p>Sincerely,</p>
            <p>The FSTconference Team</p>
        </div>
    </div>
</body>

</html>