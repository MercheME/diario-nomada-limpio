<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoImagen extends Model
{

    use HasFactory;

    protected $fillable = ['proyecto_id', 'url_imagen'];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
