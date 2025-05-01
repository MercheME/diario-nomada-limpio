<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diario extends Model
{
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


}
