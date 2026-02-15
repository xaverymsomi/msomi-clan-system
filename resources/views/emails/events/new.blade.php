<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #10b981; color: #ffffff; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background-color: #ffffff; padding: 30px; border: 1px solid #e5e7eb; border-radius: 0 0 8px 8px; }
        .title { font-size: 24px; font-weight: bold; margin-bottom: 20px; color: #111827; }
        .details { margin-bottom: 30px; border-left: 4px solid #10b981; padding-left: 15px; }
        .button { display: inline-block; padding: 12px 24px; background-color: #10b981; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; }
        .footer { margin-top: 20px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>NEW CLAN EVENT</h1>
        </div>
        <div class="content">
            <div class="title">{{ $event->title }}</div>
            <div class="details">
                <p><strong>Date:</strong> {{ $event->start_date->format('F d, Y') }} at {{ $event->start_date->format('H:i') }}</p>
                <p><strong>Location:</strong> {{ $event->location }}</p>
                <p><strong>Type:</strong> {{ ucfirst($event->event_type) }}</p>
            </div>
            <p>{{ Str::limit($event->description, 200) }}</p>
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('events.show', $event) }}" class="button">View Event & RSVP</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Msomi Clan Management System</p>
        </div>
    </div>
</body>
</html>
