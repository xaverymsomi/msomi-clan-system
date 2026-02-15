<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Tradition extends Model
{
    use LogsActivity;
    protected $table = 'customs_traditions';

    protected $fillable = [
        'category_id',
        'title_sw',
        'title_en',
        'description_sw',
        'description_en',
        'content_sw',
        'content_en',
        'featured_image',
        'status',
        'views_count',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title_sw', 'title_en', 'status', 'category_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $casts = [
        'views_count' => 'integer',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(TraditionCategory::class, 'category_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(TraditionMedia::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
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

    public function getContentAttribute(): ?string
    {
        $lang = app()->getLocale();
        return $this->{"content_{$lang}"} ?? $this->content_sw;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeFeatured($query)
    {
        return $query->whereNotNull('featured_image');
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
