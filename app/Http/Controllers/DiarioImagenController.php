<?php

namespace App\Http\Controllers;

use App\Models\Diario;
use App\Models\DiarioImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DiarioImagenController extends Controller
{
    public function store(Request $request, Diario $diario)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif',
            'descripcion' => 'nullable|string|max:2000'
        ]);

        $path = $request->file('imagen')->store('imagenes/diarios', 'public');

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
        if (!$imagen->diario || $imagen->diario->user_id !== Auth::id()) {
            abort(403, 'Acción no autorizada.');
        }

        if ($imagen->is_principal) {
            return back()->withErrors('No puedes eliminar la imagen principal.');
        }

        Storage::disk('public')->delete($imagen->url_imagen);

        $imagen->delete();

        return back()->with('success', 'Imagen eliminada correctamente.');
    }

    public function establecerPrincipal(DiarioImagen $imagen)
    {
         if ($imagen->diario->user_id !== Auth::id()) {
            abort(403, 'Acción no autorizada.');
        }

        $diario = $imagen->diario;

        $diario->imagenes()->update(['is_principal' => false]);

        $imagen->is_principal = true;
        $imagen->save();

        return redirect()->route('diarios.show', $diario->slug)->with('success', 'Imagen principal actualizada.');
    }
}
