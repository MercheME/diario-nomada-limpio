<?php

namespace App\Http\Controllers;

use App\Models\Diario;
use App\Models\DiarioImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // Proteger imagen principal
        if ($imagen->is_principal) {
            return back()->withErrors('No puedes eliminar la imagen principal.');
        }

        // Eliminar el archivo físico
        Storage::disk('public')->delete($imagen->url_imagen);

        // Eliminar de la base de datos
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada correctamente.');
    }

    public function establecerPrincipal(DiarioImagen $imagen)
    {
        $diario = $imagen->diario;

        // Desactivar la actual imagen principal
        $diario->imagenes()->update(['is_principal' => false]);

        // Activar la nueva
        $imagen->is_principal = true;
        $imagen->save();

        return redirect()->route('diarios.show', $diario->slug)->with('success', 'Imagen principal actualizada.');
    }
}
