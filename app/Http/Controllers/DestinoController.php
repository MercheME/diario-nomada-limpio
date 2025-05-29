<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\DestinoImagen;
use App\Models\Diario;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
     * Busca direcciones usando Nominatim para el autocompletado.
     */
    public function buscarDireccion(Request $request)
    {
        $request->validate(['q' => 'required|string|min:3']);

        $query = $request->q;

        // Petición a la API de Nominatim
        $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($query) . "&format=json&addressdetails=1&limit=5";

        $respuesta = Http::withHeaders([
            'User-Agent' => 'TuApp/1.0 (tu-dominio.com)',
        ])->get($url);

        if ($respuesta->successful()) {
            // Devuelve la respuesta JSON al frontend
            return response()->json($respuesta->json());
        }

        return response()->json(['error' => 'No se pudo buscar la dirección'], 500);
    }

    public function obtenerDireccion(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $lat = $request->lat;
        $lon = $request->lon;

        // Petición a Nominatim
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lon}&zoom=18&addressdetails=1";

        $respuesta = Http::withHeaders([
            'User-Agent' => 'DiarioNomadaApp/1.0 (diario-nomada.test)',
        ])->get($url);

        if ($respuesta->successful()) {
            return response()->json($respuesta->json());
        } else {
            return response()->json([
                'error' => 'No se pudo obtener la dirección',
                'codigo' => $respuesta->status(),
            ], 500);
        }
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

    public function store(Request $request, $slug)
    {
        $diario = Diario::where('slug', $slug)->firstOrFail();

        if ($diario->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'No tienes permiso para añadir destinos a este diario.');
        }

        $reglas = [
            'nombre_destino' => 'required|string|max:255',
            'ubicacion' => 'required|string',
            'fecha_inicio_destino' => ['required', 'date'],
            'fecha_final_destino' => ['required', 'date', 'after_or_equal:fecha_inicio_destino'],
            'alojamiento' => 'nullable|string',
            'personas_conocidas' => 'nullable|string',
            'relato' => 'nullable|string',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($diario->fecha_inicio) {
            $reglas['fecha_inicio_destino'][] = 'after_or_equal:' . $diario->fecha_inicio->format('Y-m-d');
        }
        if ($diario->fecha_final) {
            $reglas['fecha_final_destino'][] = 'before_or_equal:' . $diario->fecha_final->format('Y-m-d');
        }

        $validatedData = $request->validate($reglas);

        $destino = new Destino();
        $destino->nombre_destino = $validatedData['nombre_destino'];
        $destino->ubicacion = $validatedData['ubicacion'];
        $destino->fecha_inicio_destino = $validatedData['fecha_inicio_destino'];
        $destino->fecha_final_destino = $validatedData['fecha_final_destino'];
        $destino->alojamiento = $validatedData['alojamiento'] ?? null;
        $destino->personas_conocidas = $validatedData['personas_conocidas'] ?? null;
        $destino->relato = $validatedData['relato'] ?? null;
        $destino->diario_id = $diario->id;

        // Generar slug
        $slugBase = Str::slug($validatedData['nombre_destino']);
        $slugUnico = $slugBase;
        $counter = 1;
        while (Destino::where('slug', $slugUnico)->exists()) {
            $slugUnico = $slugBase . '-' . $counter++;
        }
        $destino->slug = $slugUnico;

        $destino->save();

        // Guardar imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $image) {
                $imagePath = $image->store('destino_imagenes', 'public');
                DestinoImagen::create([
                    'destino_id' => $destino->id,
                    'url_imagen' => $imagePath,
                ]);
            }
        }

        return redirect()->route('diarios.edit', ['slug' => $diario->slug])->with('success', 'Destino creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Buscar el destino por su slug
        $destino = Destino::where('slug', $slug)->firstOrFail();

        // Retornar la vista con el destino
        return view('destinos.show', compact('destino'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $slug)
    {

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
    public function destroy($slug)
    {
        $destino = Destino::where('slug', $slug)->firstOrFail();

        // Eliminar el destino
        $destino->delete();

        return redirect()->back()->with('success', 'Destino eliminado correctamente');
    }

     public function getDestinoFechasOcupadas(Diario $diario, Request $request)
    {
        // Verificar que el usuario autenticado sea el propietario del diario
        if ($diario->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $destinoActualId = $request->query('excluir_destino_id', null); // Para el formulario de edición de un destino

        $query = Destino::where('diario_id', $diario->id)
                        ->whereNotNull('fecha_inicio_destino')
                        ->whereNotNull('fecha_final_destino');

        if ($destinoActualId) {
            $query->where('id', '!=', $destinoActualId);
        }

        $destinosHermanos = $query->get(['fecha_inicio_destino', 'fecha_final_destino']);

        $rangosOcupados = $destinosHermanos->map(function ($destino) {
            return [
                'from' => Carbon::parse($destino->fecha_inicio_destino)->format('Y-m-d'),
                'to'   => Carbon::parse($destino->fecha_final_destino)->format('Y-m-d'),
            ];
        });

        return response()->json($rangosOcupados);
    }

}
