<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectoImagen;
use Illuminate\Http\Request;

class ProyectoImagenController extends Controller
{
    // public function store(Request $request, Proyecto $proyecto)
    // {
    //     $request->validate([
    //         'imagen' => 'required|image|mimes:jpeg,png,jpg,gif',
    //     ]);

    //     $path = $request->file('imagen')->store('imagenes/proyectos');

    //     ProyectoImagen::create([
    //         'proyecto_id' => $proyecto->id,
    //         'url_imagen' => $path,
    //         'descripcion' => $request->descripcion,
    //         'is_principal' => $request->has('is_principal'),
    //     ]);

    //     return redirect()->route('proyectos.show', $proyecto);
    // }

    // public function destroy(ProyectoImagen $imagen)
    // {
    //     $imagen->delete();
    //     return back();
    // }
}
