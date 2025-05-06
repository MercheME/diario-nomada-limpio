<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinoImagen extends Model
{

    protected $table = 'destino_imagenes';

    protected $fillable = [
        'destino_id',
        'url_imagen',
        'descripcion'
    ];

    public function destino()
    {
        return $this->belongsTo(Destino::class);
    }
}
