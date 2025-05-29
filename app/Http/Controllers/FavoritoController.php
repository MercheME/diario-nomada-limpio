<?php

namespace App\Http\Controllers;

use App\Models\Diario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    /**
     * Muestra lista de diarios favoritos del usuario autenticado
     */
    public function index()
    {
        $usuario = Auth::user();

        $diariosFavoritos = $usuario->diariosFavoritos()
                                    ->with(['imagenPrincipal', 'user'])
                                    ->latest('favoritos_diarios.created_at')
                                    ->paginate(10);

        return view('favoritos.index', compact('diariosFavoritos')); // Necesitarás crear esta vista
    }

    /**
     * Añade un diario a la lista de favoritos del usuario autenticado
     */
    public function agregarFavorito(Request $request, Diario $diario)
    {
        $usuario = Auth::user();

        // syncWithoutDetaching asegura que no se añadan duplicados
        $usuario->diariosFavoritos()->syncWithoutDetaching([$diario->id]);

        return redirect()->back()->with('success', '¡"' . $diario->titulo . '" añadido a tus favoritos!');
    }

    /**
     * Quita un diario de la lista de favoritos del usuario autenticado
     */
    public function quitarFavorito(Request $request, Diario $diario)
    {
        $usuario = Auth::user();
        $usuario->diariosFavoritos()->detach($diario->id);

        return redirect()->back()->with('success', '"' . $diario->titulo . '" eliminado de tus favoritos.');
    }
}
