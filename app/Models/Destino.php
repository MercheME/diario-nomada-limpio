<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $casts = [
        'fecha_inicio_destino' => 'date:d-m-Y',
        'fecha_final_destino' => 'date:d-m-Y',
    ];

    protected $fillable = [
        'diario_id',
        'nombre_destino',
        'ubicacion',
        'slug',
        'fecha_inicio_destino',
        'fecha_final_destino',
        'alojamiento',
        'personas_conocidas',
        'relato',
    ];

    public function imagenes()
    {
        return $this->hasMany(DestinoImagen::class);
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(DestinoImagen::class)->where('is_principal', true);
    }

    public function diario()
    {
        return $this->belongsTo(Diario::class);
    }

}
