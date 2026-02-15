<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TraditionCategory extends Model
{
    protected $fillable = [
        'name_sw',
        'name_en',
        'description_sw',
        'description_en',
        'icon',
        'color',
    ];

    // Relationships
    public function traditions(): HasMany
    {
        return $this->hasMany(Tradition::class, 'category_id');
    }

    // Accessors
    public function getNameAttribute(): string
    {
        $lang = app()->getLocale();
        return $this->{"name_{$lang}"} ?? $this->name_sw;
    }

    public function getDescriptionAttribute(): ?string
    {
        $lang = app()->getLocale();
        return $this->{"description_{$lang}"} ?? $this->description_sw;
    }
}
