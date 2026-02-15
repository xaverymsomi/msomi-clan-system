<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraditionMedia extends Model
{
    protected $fillable = [
        'tradition_id',
        'type',
        'file_path',
        'duration',
        'caption_sw',
        'caption_en',
    ];

    // Relationships
    public function tradition(): BelongsTo
    {
        return $this->belongsTo(Tradition::class);
    }

    // Accessors
    public function getCaptionAttribute(): ?string
    {
        $lang = app()->getLocale();
        return $this->{"caption_{$lang}"} ?? $this->caption_sw;
    }
}
