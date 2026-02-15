<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Event extends Model
{
    use LogsActivity;
    protected $fillable = [
        'title_sw',
        'title_en',
        'description_sw',
        'description_en',
        'event_type',
        'start_date',
        'end_date',
        'location',
        'venue',
        'max_attendees',
        'created_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title_sw', 'title_en', 'event_type', 'start_date', 'location'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'max_attendees' => 'integer',
    ];

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class);
    }

    // Accessors
    public function getTitleAttribute(): string
    {
        $lang = app()->getLocale();
        return $this->{"title_{$lang}"} ?? $this->title_sw;
    }

    public function getDescriptionAttribute(): ?string
    {
        $lang = app()->getLocale();
        return $this->{"description_{$lang}"} ?? $this->description_sw;
    }

    public function getIsFullAttribute(): bool
    {
        if (!$this->max_attendees) {
            return false;
        }
        return $this->attendees()->where('status', 'registered')->count() >= $this->max_attendees;
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('start_date', '<', now());
    }

    public function scopeByType($query, $type)
    {
        return $query->where('event_type', $type);
    }
}
