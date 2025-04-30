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

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'diario_tags');
    }

    public function comunidades()
    {
        return $this->belongsToMany(Comunidad::class, 'diario_comunidades');
    }
}
