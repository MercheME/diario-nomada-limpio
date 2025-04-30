<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    public function imagenes()
    {
        return $this->hasMany(ProyectoImagen::class);
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(proyectoImagen::class)->where('is_principal', true);
    }
}
