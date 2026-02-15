<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 30px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #111827;
        }
        .excerpt {
            margin-bottom: 30px;
            color: #4b5563;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4f46e5;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MSOMI CLAN</h1>
        </div>
        <div class="content">
            <div class="title">{{ $announcement->title }}</div>
            <div class="excerpt">
                {!! nl2br(e($announcement->getExcerpt(250))) !!}
            </div>
            <div style="text-align: center;">
                <a href="{{ route('announcements.show', $announcement) }}" class="button">Read Full Announcement</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Msomi Clan Management System. All rights reserved.</p>
            <p>You are receiving this email because you are a registered member of the Msomi Clan.</p>
        </div>
    </div>
</body>
</html>
