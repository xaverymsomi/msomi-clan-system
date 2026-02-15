<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'base_url',
        'api_key',
        'api_secret',
        'public_key',
        'webhook_secret',
        'is_active',
        'settings'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array'
    ];

    /**
     * Get the active gateway.
     */
    public static function active()
    {
        return self::where('is_active', true)->first();
    }
}
