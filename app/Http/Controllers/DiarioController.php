<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Diario;
use App\Models\DiarioImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Crear un diario provisional y asociarlo al usuario
        $diario = new Diario();
        $diario->usuario_id = $usuario->id; // Relacionar con el usuario autenticado

        // Pasar el diario a la vista para crear destinos
        return view('diarios.create', compact('diario'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'estado' => 'in:borrador,en_progreso,completado',
            'is_public' => 'boolean',
        ]);

        // Crear un nuevo diario utilizando los datos validados
        $diario = new Diario();
        $diario->user_id = Auth::id();
        $diario->titulo = $validated['titulo'];
        $diario->slug = Str::slug($validated['titulo'] . '-' . uniqid());
        $diario->estado = $validated['estado'] ?? 'planificado';  // Asignar 'borrador' si no se envía
        $diario->is_public = $validated['is_public'] ?? false; // Asignar false si no se envía

        // Guardar el diario en la base de datos
        $diario->save();

        // Procesar la imagen principal
        if ($request->hasFile('imagen_principal')) {
            $path = $request->file('imagen_principal')->store('imagenes/diarios', 'public');
        } else {
            // Asegúrate de que esta imagen exista en: storage/app/public/diarios/default.png
            $path = 'imagenes/diarios/default.png';
        }

        DiarioImagen::create([
            'diario_id' => $diario->id,
            'url_imagen' => $path,
            'is_principal' => true
        ]);

        return redirect("/diarios/{$diario->slug}")->with('success', 'Diario creado correctamente.');
    }

    // public function mapa()
    // {
    //     $user = Auth::user();

    //     $diarios = Diario::with('destinos')
    //     ->where('user_id', $user->id)
    //     ->get();

    //     return view('diarios.mapa', compact('diarios'));
    // }

    public function show($slug)
    {
        $diario = Diario::where('slug', $slug)->firstOrFail();
        return view('diarios.show', compact('diario'));
    }

    public function edit($slug)
    {

        $diario = Diario::where('slug', $slug)->firstOrFail();
        $destinos = Destino::all();
        return view('diarios.edit', compact('diario', 'destinos'));
    }

    public function update(Request $request, $slug)
    {
        $diario = Diario::where('slug', $slug)->firstOrFail();

        // dd($request->all());

       // Validar los datos del formulario
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
            'is_public' => 'boolean',
            'impacto_ambiental' => 'nullable|string',
            'impacto_cultural' => 'nullable|string',
            'libros' => 'nullable|string',
            'musica' => 'nullable|string',
            'peliculas' => 'nullable|string',
            'documentales' => 'nullable|string',
            'etiquetas' => 'nullable|array',
            'destinos' => 'nullable|array',
            'destinos.*' => 'exists:destinos,id',
            // 'planificaciones' => 'nullable|array',
            // 'planificaciones.*.fecha' => 'required|date',
            // 'planificaciones.*.descripcion' => 'nullable|string',
        ]);

        // Actualizar los campos básicos del diario
        $diario->titulo = $validated['titulo'];

        // Solo actualizar el slug si el título ha cambiado
        if ($diario->titulo !== $validated['titulo']) {
            $diario->slug = Str::slug($validated['titulo'] . '-' . uniqid()); // Generar nuevo slug
        }

        $diario->contenido = $validated['contenido'];
        $diario->fecha_inicio = $validated['fecha_inicio'];
        $diario->fecha_final = $validated['fecha_final'];
        $diario->is_public = $validated['is_public'] ?? true;
        $diario->impacto_ambiental = $validated['impacto_ambiental'] ?? null;
        $diario->impacto_cultural = $validated['impacto_cultural'] ?? null;
        $diario->libros = $validated['libros'] ?? null;
        $diario->musica = $validated['musica'] ?? null;
        $diario->peliculas = $validated['peliculas'] ?? null;
        $diario->documentales = $validated['documentales'] ?? null;
        $diario->etiquetas = $validated['etiquetas'] ?? [];

        // // Guardar los cambios en el diario
        // $diario->save();

        // dd($request->all());

        // Actualizar destinos
        if ($request->has('destinos') && is_array($request->destinos)) {
            // Eliminar destinos existentes
            $diario->destinos()->delete();

            // Crear nuevos destinos
            foreach ($request->destinos as $destinoId) {
                $diario->destinos()->create(['destino_id' => $destinoId]);
            }
        }

        // Guardar otros campos del diario
        $diario->update($request->except('destinos'));

        // Actualizar planificaciones (si las hay)
        // if ($request->has('planificaciones')) {
        //     // Eliminar planificaciones anteriores
        //     $diario->planificaciones()->delete();

        //     // Añadir nuevas planificaciones
        //     foreach ($validated['planificaciones'] as $planificacionData) {
        //         $diario->planificaciones()->create([
        //             'fecha' => $planificacionData['fecha'],
        //             'descripcion' => $planificacionData['descripcion'] ?? null,
        //         ]);
        //     }
        // }

        return redirect()->route('diarios.show', $diario->slug)
            ->with('success', 'Diario actualizado correctamente.');
        // return redirect()->route('diarios.edit', $diario->slug)->with('success', 'Diario actualizado correctamente');
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
