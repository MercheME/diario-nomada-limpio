<?php

namespace App\Models;

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
}
