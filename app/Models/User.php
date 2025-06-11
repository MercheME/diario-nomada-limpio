<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'profile_image',
    ];

    public function diarios()
    {
        return $this->hasMany(Diario::class);
    }

    public function getProfileImageUrlAttribute(): string
    {

        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }

       return url('profile_images/avatar-default.png');
    }

    protected static function booted(): void
    {
        static::creating(function ($user) {
            $user->uuid = Str::uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Relación de muchos a muchos con otros usuarios a través de la tabla de amistades
     * Los amigos aceptados del usuario
     */
    public function amigos()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->withPivot('status')
            ->wherePivot('status', 'aceptada')
            ->orderBy('name', 'asc');
    }

    /**
     * Relación con las solicitudes de amistad enviadas por el usuario
     * Las solicitudes pendientes que ha enviado
     */
    public function solicitudesEnviadas()
    {
        return $this->hasMany(Friendship::class, 'user_id')
        ->where('status', 'pendiente');
    }

    /**
     * Relación con las solicitudes de amistad recibidas por el usuario
     * Las solicitudes pendientes que ha recibido
     */
    public function solicitudesRecibidas()
    {
        return $this->hasMany(Friendship::class, 'friend_id')
                    ->where('status', 'pendiente');
    }

    public function tieneSolicitudPendienteCon(User $user): bool
    {
        return Friendship::where(function ($query) use ($user) {
            $query->where('user_id', $this->id)
                  ->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', $this->id);
        })->where('status', 'pendiente')->exists();
    }

    public function esAmigoDe(User $user): bool
    {
        return Friendship::between($this, $user)
            ->where('status', 'aceptada')
            ->exists();
    }

    /**
     * Los diarios que el usuario ha marcado como favoritos
     * Se accede a ellos a través de la tabla pivot 'favoritos_diarios'
     */
    public function diariosFavoritos()
    {
        return $this->belongsToMany(Diario::class, 'favoritos_diarios', 'user_id', 'diario_id')
                    ->withTimestamps();
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
