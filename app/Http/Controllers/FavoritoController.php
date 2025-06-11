<?php

namespace App\Http\Controllers;

use App\Models\Diario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{

    public function index()
    {
        $usuario = Auth::user();

        $diariosFavoritos = $usuario->diariosFavoritos()
            ->with(['imagenPrincipal', 'user'])
            ->latest('favoritos_diarios.created_at')
            ->paginate(10);

        return view('favoritos.index', compact('diariosFavoritos'));
    }


    public function agregarFavorito(Request $request, Diario $diario)
    {
        $usuario = Auth::user();

        // syncWithoutDetaching para que no se añadan duplicados
        $usuario->diariosFavoritos()->syncWithoutDetaching([$diario->id]);

        return redirect()->back()->with('success', '¡"' . $diario->titulo . '" añadido a tus favoritos!');
    }

    public function quitarFavorito(Request $request, Diario $diario)
    {
        $usuario = Auth::user();
        $usuario->diariosFavoritos()->detach($diario->id);

        return redirect()->back()->with('success', '"' . $diario->titulo . '" eliminado de tus favoritos.');
    }
}
