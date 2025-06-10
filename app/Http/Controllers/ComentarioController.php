<?php

namespace App\Http\Controllers;

use App\Models\Diario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request, Diario $diario)
    {
        $request->validate([
            'contenido' => 'required|string|min:3|max:2000',
        ]);

        $userId = Auth::id();

        $diario->comentarios()->create([
            'user_id' => $userId,
            'contenido' => $request->input('contenido'),
        ]);

        return back()->with('success', '¡Comentario añadido!');
    }
}
