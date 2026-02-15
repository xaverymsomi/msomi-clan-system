<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helper methods
    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public function markAsUnread(): void
    {
        $this->update(['read_at' => null]);
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function getUrl(): ?string
    {
        $data = $this->data ?? [];
        
        return match($this->type) {
            'event_reminder', 'event_rsvp' => isset($data['event_id']) ? route('events.show', $data['event_id']) : null,
            'new_announcement', 'urgent_announcement' => isset($data['announcement_id']) ? route('announcements.show', $data['announcement_id']) : null,
            'contribution_receipt' => route('contributions.my'),
            'document_upload' => isset($data['document_id']) ? route('documents.show', $data['document_id']) : null,
            'new_member' => route('members.index'),
            'comment_reply' => isset($data['announcement_id']) ? route('announcements.show', $data['announcement_id']) : null,
            default => null,
        };
    }

    public function getIcon(): string
    {
        return match($this->type) {
            'event_reminder', 'event_rsvp' => 'calendar',
            'new_announcement', 'urgent_announcement' => 'megaphone',
            'contribution_receipt' => 'currency-dollar',
            'document_upload' => 'document',
            'new_member' => 'user-plus',
            'comment_reply' => 'chat',
            default => 'bell',
        };
    }

    public function getIconColor(): string
    {
        return match($this->type) {
            'urgent_announcement' => 'text-red-500',
            'event_reminder' => 'text-green-500',
            'contribution_receipt' => 'text-orange-500',
            'document_upload' => 'text-indigo-500',
            'new_member' => 'text-teal-500',
            default => 'text-blue-500',
        };
    }
}
