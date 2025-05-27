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

        // Obtener todos los usuarios excepto el autenticado
        $usuarios = $user->where('id', '!=', $user->id)->get();

        // Solicitudes de amistad
        $solicitudesPendientes = $user->solicitudesRecibidas;

        //Diarios propios publicados
        $diariosPublicos = Diario::where('is_public', true)->get();
        $ultimosDiarios = Auth::user()->diarios()->latest()->take(6)->get(); // Obtener los últimos 6 diarios

        // IDs de amigos
        $amigosIds = $amigos->pluck('id');

        // Diarios públicos de los amigos
        $diariosAmigos = Diario::with(['imagenPrincipal', 'user'])
            ->where('is_public', true)
            ->whereIn('user_id', $amigosIds)
            ->latest()
            ->take(10)
            ->get();

        // Diarios públicos de cualquier usuario (si aún quieres mostrarlos por separado)
        $diariosPublicosTodos = Diario::where('is_public', true)->latest()->take(10)->get();

        return view('home', compact('usuarios','amigos','solicitudesPendientes','ultimosDiarios', 'diariosPublicos', 'diariosAmigos', 'diariosPublicosTodos'));
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

     public function togglePublicStatus(Request $request, $slug)
    {
        $diario = Diario::where('slug', $slug)->firstOrFail();

        if (Auth::id() !== $diario->user_id) {
            return redirect()->back()->with('error', 'No tienes permiso para modificar este diario.');
        }

        $diario->is_public = !$diario->is_public;
        $diario->save();

        $message = $diario->is_public ? 'Tu diario ahora es público.' : 'Tu diario ahora es privado.';

        return redirect()->back()->with('success', $message);
    }

    public function mapa()
    {
        $user = Auth::user();

        $diarios = Diario::with('destinos')
        ->where('user_id', $user->id)
        ->get();

        return view('diarios.mapa', compact('diarios'));
    }

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
        $diario = Diario::where('slug', $slug)->with('destinos')->firstOrFail();

        if (Auth::id() !== $diario->user_id) {
            return redirect()->route('diarios.index')->with('error', 'No tienes permiso para editar este diario.');
        }

        // Transformar 'etiquetas' de string a array ANTES de la validación
        if ($request->has('etiquetas') && is_string($request->input('etiquetas'))) {
            // Divide el string por comas, quita espacios en blanco de cada etiqueta,
            // y filtra elementos vacíos.
            $etiquetasArray = array_filter(array_map('trim', explode(',', $request->input('etiquetas'))));
            $request->merge(['etiquetas' => $etiquetasArray]);
        } elseif ($request->input('etiquetas') === null && $request->has('etiquetas')) {
            // Si el campo 'etiquetas' se envía explícitamente como null (ej. campo vacío),
            // lo convertimos a un array vacío para que la regla 'nullable|array' pase correctamente.
            $request->merge(['etiquetas' => []]);
        }

        // Validar los datos del formulario
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
            'is_public' => 'required|boolean',
            'estado' => 'required|in:planificado,en_curso,realizado',
            'impacto_ambiental' => 'nullable|string',
            'impacto_cultural' => 'nullable|string',
            'libros' => 'nullable|string',
            'musica' => 'nullable|string',
            'peliculas' => 'nullable|string',
            'documentales' => 'nullable|string',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'sometimes|string|max:50', // Validar cada etiqueta (opcional, 'sometimes' si el array 'etiquetas' es nullable)
            'destinos' => 'nullable|array',
            'destinos.*' => 'exists:destinos,id',
        ]);

        // Preparar los datos para la actualización
        $updateData = [
            'titulo' => $validated['titulo'],
            'contenido' => $validated['contenido'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_final' => $validated['fecha_final'],
            'is_public' => $validated['is_public'],
            'estado' => $validated['estado'],
            'impacto_ambiental' => $validated['impacto_ambiental'] ?? null,
            'impacto_cultural' => $validated['impacto_cultural'] ?? null,
            'libros' => $validated['libros'] ?? null,
            'musica' => $validated['musica'] ?? null,
            'peliculas' => $validated['peliculas'] ?? null,
            'documentales' => $validated['documentales'] ?? null,
            'etiquetas' => $validated['etiquetas'] ?? [],
        ];

        // Solo actualizar el slug si el título ha cambiado
        if ($diario->titulo !== $validated['titulo']) {
            $updateData['slug'] = Str::slug($validated['titulo'] . '-' . uniqid());
        }

        $diario->update($updateData);


        // Actualizar destinos
        if ($request->has('destinos') && is_array($request->destinos)) {
            $currentDestinoIds = $diario->destinos->pluck('destino_id')->toArray();
            $newDestinoIds = $validated['destinos'] ?? [];

            // Destinos a eliminar: los que están en current pero no en new
            $destinosAEliminar = array_diff($currentDestinoIds, $newDestinoIds);
            if (!empty($destinosAEliminar)) {
                $diario->destinos()->whereIn('destino_id', $destinosAEliminar)->delete();
            }

            // Destinos a añadir: los que están en new pero no en current
            $destinosAAnadir = array_diff($newDestinoIds, $currentDestinoIds);
            foreach ($destinosAAnadir as $destinoId) {
                if (!empty($destinoId)) { // Evitar IDs vacíos si el array puede tenerlos
                    $diario->destinos()->create(['destino_id' => $destinoId]); // Ajusta según tu modelo de relación
                }
            }
        } elseif (!$request->has('destinos')) {
            // Si no se envía el campo 'destinos', quizás quieras eliminar todos los asociados.
            // O no hacer nada si 'nullable' significa que no se actualizan.
            // $diario->destinos()->delete(); // Descomenta si este es el comportamiento deseado.
        }


        return redirect()->route('diarios.show', $diario->slug)->with('success', 'Diario actualizado correctamente.');
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
