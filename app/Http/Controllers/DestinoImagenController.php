<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\DestinoImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DestinoImagenController extends Controller
{
    public function store(Request $request, Destino $destino) // Cambiado de Diario a Destino
    {
        // Autorización: Solo el dueño del diario al que pertenece el destino puede añadir imágenes
        if ($destino->diario->user_id !== Auth::id()) {
            abort(403, 'Acción no autorizada.');
        }

        $validatedData = $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'descripcion' => 'nullable|string|max:2000',
        ]);

        $path = $request->file('imagen')->store('imagenes/destinos', 'public'); // Carpeta diferente

        DestinoImagen::create([
            'destino_id' => $destino->id, // Cambiado de diario_id
            'url_imagen' => $path,
            'descripcion' => $validatedData['descripcion'] ?? null,
            'is_principal' => $request->has('is_principal'), // Considera si esto tiene sentido para imágenes de destino
        ]);

        // Redirigir a la vista show del destino
        return redirect()->route('destinos.show', $destino->slug)->with('success', 'Imagen añadida al destino.');
    }

    public function destroy(DestinoImagen $imagen) // Recibe DestinoImagen
    {
        // Autorización
        if ($imagen->destino->diario->user_id !== Auth::id()) {
             abort(403, 'Acción no autorizada.');
        }

        if ($imagen->is_principal) { // Si tienes lógica de imagen principal para destinos
            return back()->withErrors('No puedes eliminar la imagen principal del destino.');
        }

        Storage::disk('public')->delete($imagen->url_imagen);
        $imagen->delete();

        return back()->with('success', 'Imagen del destino eliminada correctamente.');
    }

    public function establecerPrincipal(DestinoImagen $imagen) // Recibe DestinoImagen
    {
        // Autorización
        if ($imagen->destino->diario->user_id !== Auth::id()) {
            abort(403, 'Acción no autorizada.');
        }

        $destino = $imagen->destino;

        $destino->imagenes()->update(['is_principal' => false]);

        $imagen->is_principal = true;
        $imagen->save();

        return redirect()->route('destinos.show', $destino->slug)->with('success', 'Imagen principal del destino actualizada.');
    }
}
