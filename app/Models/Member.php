<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Member extends Model
{
    use LogsActivity;
    protected $fillable = [
        'user_id',
        'member_number',
        'first_name',
        'last_name',
        'middle_name',
        'date_of_birth',
        'gender',
        'village',
        'district',
        'region',
        'email',
        'phone',
        'father_id',
        'mother_id',
        'marital_status',
        'occupation',
        'profession',
        'skills',
        'profile_photo',
        'bio_sw',
        'bio_en',
        'membership_status',
        'joined_date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'first_name', 'last_name', 'middle_name', 'village', 'district', 'region',
                'membership_status', 'phone', 'email', 'marital_status', 'occupation'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $casts = [
        'date_of_birth' => 'date',
        'joined_date' => 'date',
        'skills' => 'array',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function father(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'father_id');
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'mother_id');
    }

    public function childrenAsFather(): HasMany
    {
        return $this->hasMany(Member::class, 'father_id');
    }

    public function childrenAsMother(): HasMany
    {
        return $this->hasMany(Member::class, 'mother_id');
    }

    public function getChildrenAttribute()
    {
        return $this->childrenAsFather->merge($this->childrenAsMother);
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(Contribution::class);
    }

    public function eventAttendances(): HasMany
    {
        return $this->hasMany(EventAttendee::class);
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('membership_status', 'active');
    }

    public function scopeByRegion($query, $region)
    {
        return $query->where('region', $region);
    }

    public function scopeByDistrict($query, $district)
    {
        return $query->where('district', $district);
    }
}
