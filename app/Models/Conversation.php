<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['last_message_at'];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('last_read_at')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function scopeForUser($query, $user)
    {
        $userId = $user instanceof User ? $user->id : $user;
        return $query->whereHas('users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        });
    }

    public function getOtherUser($currentUser)
    {
        $currentUserId = $currentUser instanceof User ? $currentUser->id : $currentUser;
        return $this->users->where('id', '!=', $currentUserId)->first();
    }

    public function hasUnread($user)
    {
        $userId = $user instanceof User ? $user->id : $user;
        $pivot = $this->users->where('id', $userId)->first()->pivot;
        
        if (!$pivot->last_read_at) {
            return true;
        }

        return $this->last_message_at > $pivot->last_read_at;
    }
}
