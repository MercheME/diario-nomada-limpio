<?php

namespace App\Http\Controllers;

use App\Models\Diario;
use App\Models\DiarioImagen;
use Illuminate\Http\Request;

class DiarioImagenController extends Controller
{
    public function store(Request $request, Diario $diario)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $path = $request->file('imagen')->store('imagenes/diarios');

        DiarioImagen::create([
            'diario_id' => $diario->id,
            'url_imagen' => $path,
            'descripcion' => $request->descripcion,
            'is_principal' => $request->has('is_principal'),
        ]);

        return redirect()->route('diarios.show', $diario);
    }

    public function destroy(DiarioImagen $imagen)
    {
        $imagen->delete();
        return back();
    }
}
