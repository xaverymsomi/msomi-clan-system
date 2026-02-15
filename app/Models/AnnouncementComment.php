<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnouncementComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'announcement_id',
        'user_id',
        'parent_id',
        'comment',
    ];

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(AnnouncementComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(AnnouncementComment::class, 'parent_id')->latest();
    }

    public function isReply(): bool
    {
        return $this->parent_id !== null;
    }
}
