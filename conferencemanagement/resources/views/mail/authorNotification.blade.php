<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        h2 {
            color: #004085;
        }
        .remarks {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .remark-item {
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Main dynamic body --}}
        <p>{!! nl2br(e($body)) !!}</p>

        {{-- Optional footer --}}
        <div class="footer">
            <p>This message was sent as part of the conference management process. Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
