<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function diarios()
    {
        return $this->belongsToMany(Diario::class);
    }

}
