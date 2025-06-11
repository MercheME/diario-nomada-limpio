<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diario extends Model
{

    protected $casts = [
        'etiquetas' => 'array',
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_final' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'user_id',
        'titulo',
        'slug',
        'estado',
        'is_public',
        'fecha_inicio',
        'fecha_final',
        'contenido',
        'impacto_ambiental',
        'impacto_cultural',
        'libros',
        'musica',
        'peliculas',
        'documentales',
        'etiquetas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imagenes()
    {
        return $this->hasMany(DiarioImagen::class);
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(DiarioImagen::class)->where('is_principal', true);
    }

    public function destinos()
    {
        return $this->hasMany(Destino::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class)->latest(); 
    }

}
