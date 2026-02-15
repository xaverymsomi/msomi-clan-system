<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Document extends Model
{
    use LogsActivity;
    protected $fillable = [
        'category_id',
        'title_sw',
        'title_en',
        'description_sw',
        'description_en',
        'file_path',
        'file_type',
        'file_size',
        'access_level',
        'uploaded_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title_sw', 'title_en', 'category_id', 'access_level'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Multi-language accessor
    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_en;
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->{"description_{$locale}"} ?? $this->description_en;
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('access_level', 'public');
    }

    public function scopeForMembers($query)
    {
        return $query->whereIn('access_level', ['public', 'members']);
    }

    public function scopeForElders($query)
    {
        return $query->whereIn('access_level', ['public', 'members', 'elders']);
    }

    public function scopeForAdmins($query)
    {
        return $query->whereIn('access_level', ['public', 'members', 'elders', 'admin']);
    }

    // Helper methods
    public function getFileUrl(): string
    {
        return Storage::url($this->file_path);
    }

    public function getFileSizeFormatted(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function getFileExtension(): string
    {
        return pathinfo($this->file_path, PATHINFO_EXTENSION);
    }

    public function isPdf(): bool
    {
        return strtolower($this->file_type) === 'application/pdf' || 
               strtolower($this->getFileExtension()) === 'pdf';
    }

    public function isImage(): bool
    {
        return str_starts_with($this->file_type, 'image/');
    }
}
