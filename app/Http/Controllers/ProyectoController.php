<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    // public function index()
    // {
    //     $proyectos = Proyecto::all();
    //     return view('proyectos.index', compact('proyectos'));
    // }

    // public function create()
    // {
    //     return view('proyectos.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nombre' => 'required|string|max:255',
    //         'descripcion' => 'required|string',
    //         'latitud' => 'required|numeric',
    //         'longitud' => 'required|numeric',
    //     ]);

    //     Proyecto::create([
    //         'nombre' => $request->nombre,
    //         'descripcion' => $request->descripcion,
    //         'user_id' => auth()->id(),
    //         'latitud' => $request->latitud,
    //         'longitud' => $request->longitud,
    //     ]);

    //     return redirect()->route('proyectos.index');
    // }

    // public function show(Proyecto $proyecto)
    // {
    //     return view('proyectos.show', compact('proyecto'));
    // }

    // public function edit(Proyecto $proyecto)
    // {
    //     return view('proyectos.edit', compact('proyecto'));
    // }

    // public function update(Request $request, Proyecto $proyecto)
    // {
    //     $request->validate([
    //         'nombre' => 'required|string|max:255',
    //         'descripcion' => 'required|string',
    //     ]);

    //     $proyecto->update([
    //         'nombre' => $request->nombre,
    //         'descripcion' => $request->descripcion,
    //     ]);

    //     return redirect()->route('proyectos.index');
    // }

    // public function destroy(Proyecto $proyecto)
    // {
    //     $proyecto->delete();
    //     return redirect()->route('proyectos.index');
    // }
}
