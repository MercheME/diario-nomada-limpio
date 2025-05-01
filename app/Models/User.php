<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function diarios()
    {
        return $this->hasMany(Diario::class);
    }

    /**
     * Relación de muchos a muchos con otros usuarios a través de la tabla de amistades.
     * Los amigos aceptados del usuario.
     */
    public function amigos()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'aceptada')
                    ->orderBy('name', 'asc'); // Ordenar alfabéticamente los amigos
    }

    /**
     * Relación con las solicitudes de amistad enviadas por el usuario.
     * Las solicitudes pendientes que ha enviado.
     */
    public function solicitudesEnviadas()
    {
        return $this->hasMany(Friendship::class, 'user_id')
        ->where('status', 'pendiente'); // Filtramos las solicitudes pendientes
    }

    /**
     * Relación con las solicitudes de amistad recibidas por el usuario.
     * Las solicitudes pendientes que ha recibido.
     */
    public function solicitudesRecibidas()
    {
        return $this->hasMany(Friendship::class, 'friend_id')
                    ->where('status', 'pendiente'); // Solo las solicitudes pendientes
    }

     /**
     * Método para saber si el usuario ya es amigo de otro.
     */
    // public function esAmigoDe(User $user)
    // {
    //     return $this->amigos()->where('friend_id', $user->id)->exists();
    // }

    public function tieneSolicitudPendienteCon(User $user): bool
    {
        // return Friendship::between($this, $user)
        //     ->where('status', 'pendiente')
        //     ->exists();
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
