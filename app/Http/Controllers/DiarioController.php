<?php

namespace App\Http\Controllers;

use App\Models\Diario;
use App\Models\DiarioImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class DiarioController extends Controller
{

    public function home()
    {
        $user = Auth::user();
        $amigos = $user->amigos;
        $usuarios = $user->where('id', '!=', $user->id)->get(); // Obtener todos los usuarios excepto el autenticado
        $solicitudesPendientes = $user->solicitudesRecibidas;
        $diariosPublicos = Diario::where('is_public', true)->get();

        $ultimosDiarios = Auth::user()->diarios()->latest()->take(3)->get(); // Obtener los últimos 3 diarios

        return view('home', compact('usuarios','amigos','solicitudesPendientes','ultimosDiarios', 'diariosPublicos'));
    }

    public function index( Request $request)
    {
        $query = $request->input('query');

        // Obtener los diarios del usuario autenticado
        $diariosQuery = Auth::user()->diarios();

        // Si hay una consulta de búsqueda, aplicarla sobre la descripción del diario
        if ($query) {
            $diariosQuery = $diariosQuery->where('descripcion', 'LIKE', "%{$query}%");
        }

        // Obtener los diarios con la búsqueda aplicada (si la hay), paginados
        $diarios = $diariosQuery->latest()->paginate(10);

        return view('diarios.index', compact('diarios'));
    }

    public function publicados(Request $request)
    {
        $query = $request->input('query');

        // Obtener los diarios públicos
        $diariosQuery = Diario::where('is_public', true); // Asumiendo que tienes un campo `es_publico`

        // Si hay una consulta de búsqueda, aplicarla sobre la descripción del diario
        if ($query) {
            $diariosQuery = $diariosQuery->where('descripcion', 'LIKE', "%{$query}%");
        }

        // Obtener los diarios públicos con la búsqueda aplicada (si la hay), paginados
        $diarios = $diariosQuery->latest()->paginate(10);

        return view('diarios.index', compact('diarios'));
    }

    public function create()
    {
        return view('diarios.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'is_public' => 'boolean',
            'impacto_ambiental' => 'nullable|string',
            'impacto_cultural' => 'nullable|string',
            'aprendizajes' => 'nullable|string',
            'compromisos' => 'nullable|string',
            'calificacion_sostenibilidad' => 'nullable|integer|min:1|max:5',
            'libros' => 'nullable|string',
            'musica' => 'nullable|string',
            'peliculas' => 'nullable|string',
            'documentales' => 'nullable|string',
            'imagen_principal' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Crear un nuevo diario utilizando los datos validados
        $diario = new Diario();
        $diario->user_id = Auth::id();
        $diario->titulo = $validated['titulo'];
        $diario->slug = Str::slug($validated['titulo'] . '-' . uniqid());
        $diario->destino = $validated['destino'];
        $diario->contenido = $validated['contenido'];
        $diario->fecha_inicio = $validated['fecha_inicio'];
        $diario->fecha_final = $validated['fecha_final'];
        $diario->latitud = $validated['latitud'] ?? null;
        $diario->longitud = $validated['longitud'] ?? null;
        $diario->is_public = $validated['is_public'] ?? true;
        $diario->impacto_ambiental = $validated['impacto_ambiental'] ?? null;
        $diario->impacto_cultural = $validated['impacto_cultural'] ?? null;
        $diario->aprendizajes = $validated['aprendizajes'] ?? null;
        $diario->compromisos = $validated['compromisos'] ?? null;
        $diario->calificacion_sostenibilidad = $validated['calificacion_sostenibilidad'] ?? null;
        $diario->libros = $validated['libros'] ?? null;
        $diario->musica = $validated['musica'] ?? null;
        $diario->peliculas = $validated['peliculas'] ?? null;
        $diario->documentales = $validated['documentales'] ?? null;


        // Guardar el diario en la base de datos
        $diario->save();

        if ($request->hasFile('imagen_principal')) {
            $path = $request->file('imagen_principal')->store('imagenes/diarios', 'public');
            DiarioImagen::create([
                'diario_id' => $diario->id,
                'url_imagen' => $path,
                'is_principal' => true
            ]);
        }

        return redirect("/diarios/{$diario->slug}")->with('success', 'Diario creado correctamente.');
    }

    public function show($slug)
    {
        $diario = Diario::where('slug', $slug)->firstOrFail();
        return view('diarios.show', compact('diario'));
    }

    public function edit($slug)
    {
        if (auth()->id() !== $diario->user_id) {
            abort(403); // No autorizado
        }

        $diario = Diario::where('slug', $slug)->firstOrFail();
        return view('diarios.edit', compact('diario'));
    }

    public function update(Request $request, $slug)
    {
        $diario = Diario::where('slug', $slug)->firstOrFail();

        // Validar los datos de entrada
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Actualizar con los datos validados
        $diario->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title'] . '-' . uniqid()),
            'destination' => $validated['destination'],
            'content' => $validated['content'],
            'date' => $validated['date'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return redirect("/diarios/{$diario->slug}");
    }

    public function destroy($slug)
    {
        $diario = Diario::where('slug', $slug)->firstOrFail();
        $diario->delete();

        return redirect('/diarios');
    }

    public function agregarImagen(Request $request, $slug)
    {
        $diario = Diario::where('slug', $slug)->firstOrFail();

        $request->validate([
            'imagenes' => 'required|array|max:12',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagenesActuales = $diario->imagenes()->count();
        $nuevasImagenes = count($request->file('imagenes'));

        if (($imagenesActuales + $nuevasImagenes) > 13) {
            return redirect()->back()->withErrors('No puedes subir más de 12 imágenes en total para este diario.');
        }

        foreach ($request->file('imagenes') as $imagen) {
            $path = $imagen->store('imagenes/diarios', 'public');
            DiarioImagen::create([
                'diario_id' => $diario->id,
                'url_imagen' => $path,
                'is_principal' => false
            ]);
        }

        return redirect()->back()->with('success', 'Imágenes agregadas correctamente.');

    }
}
