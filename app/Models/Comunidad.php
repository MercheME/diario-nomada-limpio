<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    public function diarios()
    {
        return $this->belongsToMany(Diario::class);
    }

}
