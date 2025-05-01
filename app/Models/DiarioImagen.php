<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiarioImagen extends Model
{

    protected $table = 'diario_imagenes';

    protected $fillable = [
        'diario_id',
        'url_imagen',
        'descripcion',
        'is_principal',
    ];

    public function diario()
    {
        return $this->belongsTo(Diario::class);
    }
}
