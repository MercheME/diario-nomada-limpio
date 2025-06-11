<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'friend_id', 'status'];

    // Relación con el usuario (quien envió la solicitud)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el amigo (quien recibió la solicitud)
    public function amigo()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    /**
     * Query Scope para encontrar una amistad entre dos usuarios, en cualquier dirección
     */
    public function scopeBetween(Builder $query, User $user1, User $user2): void
    {
        $query->where(function (Builder $q) use ($user1, $user2) {
            $q->where('user_id', $user1->id)->where('friend_id', $user2->id);
        })->orWhere(function (Builder $q) use ($user1, $user2) {
            $q->where('user_id', $user2->id)->where('friend_id', $user1->id);
        });
    }
}
