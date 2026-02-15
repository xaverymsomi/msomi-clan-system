<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    protected $fillable = [
        'user_id',
        'notification_type',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getDefaultTypes(): array
    {
        return [
            'event_reminder' => 'Event Reminders',
            'new_announcement' => 'New Announcements',
            'urgent_announcement' => 'Urgent Announcements',
            'contribution_receipt' => 'Contribution Receipts',
            'document_upload' => 'Document Uploads',
            'new_member' => 'New Member Registrations',
            'event_rsvp' => 'Event RSVPs',
            'comment_reply' => 'Comment Replies',
        ];
    }
}
