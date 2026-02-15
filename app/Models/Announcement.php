<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Announcement extends Model
{
    use LogsActivity;
    protected $fillable = [
        'title_sw',
        'title_en',
        'content_sw',
        'content_en',
        'category',
        'priority',
        'published_at',
        'expires_at',
        'created_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title_sw', 'title_en', 'category', 'priority', 'published_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $casts = [
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(AnnouncementComment::class)->whereNull('parent_id')->latest();
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(AnnouncementComment::class);
    }

    // Multi-language accessors
    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_en;
    }

    public function getContentAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"content_{$locale}"} ?? $this->content_en;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now())
                     ->orWhereNull('published_at');
    }

    public function scopeActive($query)
    {
        return $query->published()
                     ->where(function($q) {
                         $q->where('expires_at', '>', now())
                           ->orWhereNull('expires_at');
                     });
    }

    public function scopeByPriority($query, $priority = null)
    {
        if ($priority) {
            return $query->where('priority', $priority);
        }
        return $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeUrgent($query)
    {
        return $query->where('category', 'urgent');
    }

    // Helper methods
    public function isPublished(): bool
    {
        return $this->published_at && $this->published_at->isPast();
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isActive(): bool
    {
        return $this->isPublished() && !$this->isExpired();
    }

    public function getExcerpt(int $length = 150): string
    {
        $content = strip_tags($this->content);
        if (strlen($content) <= $length) {
            return $content;
        }
        return substr($content, 0, $length) . '...';
    }

    public function getPriorityBadgeClass(): string
    {
        return match($this->priority) {
            'high' => 'bg-red-100 text-red-800',
            'medium' => 'bg-blue-100 text-blue-800',
            'low' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getCategoryBadgeClass(): string
    {
        return match($this->category) {
            'urgent' => 'bg-red-100 text-red-800',
            'event' => 'bg-purple-100 text-purple-800',
            'financial' => 'bg-green-100 text-green-800',
            'general' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
