<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Diario;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Muestra todos los destinos (puedes personalizar esto)
        $destinos = Destino::all();
        // return view('destinos.index', compact('destinos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($diario_slug)
    {
       // Aquí puedes buscar el diario usando el slug
    $diario = Diario::where('slug', $diario_slug)->firstOrFail();

        return view('destinos.create', compact('diario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,  $slug)
    {
        $diario = Diario::where('slug', $slug)->firstOrFail();

         // Validar los datos del formulario
        $validated = $request->validate([
            'nombre_destino' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'ubicacion' => 'required|string',
            'fecha_inicio_destino' => 'required|date',
            'fecha_final_destino' => 'required|date',
            'transporte' => 'nullable|string',
            'alojamiento' => 'nullable|string',
            'personas_conocidas' => 'nullable|string',
            'relato' => 'nullable|string',
            'etiquetas' => 'nullable|array',
        ]);

        // Crear el destino
        $destino = new Destino($validated);
        $destino->diario_id = $diario->id;

        // Generar un slug único
        $slugBase = Str::slug($request->nombre_destino);
        $slug = $slugBase;
        $counter = 1;
        // Mientras exista un destino con este slug, añade un número al final
        while (Destino::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $counter;
            $counter++;
        }

        $destino->slug = $slug;
        // Guardar el destino
        $destino->save();

        return redirect(route('diarios.edit', ['slug' => $diario->slug]))->with('success', 'Destino creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diario $diario)
    {
        // $destino = $diario->destinos()->where('slug', $slug)->firstOrFail();

        // // Pasar el destino y el diario a la vista
        // return view('destinos.show', compact('diario', 'destino'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
