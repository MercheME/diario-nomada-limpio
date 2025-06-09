<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Diario;
use App\Models\DiarioImagen;
use Carbon\Carbon;
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

        $solicitudesPendientes = $user->solicitudesRecibidas;

        //Diarios propios publicados
        $diariosPublicos = Diario::where('is_public', true)->get();
        $ultimosDiarios = Auth::user()->diarios()->latest()->take(6)->get();

        // IDs de amigos
        $amigosIds = $amigos->pluck('id');

        // Diarios públicos de los amigos
        $diariosAmigos = Diario::with(['imagenPrincipal', 'user'])
            ->where('is_public', true)
            ->whereIn('user_id', $amigosIds)
            ->latest()
            ->take(10)
            ->get();

        // Diarios públicos de cualquier usuario
        $diariosPublicosTodos = Diario::where('is_public', true)->latest()->take(10)->get();

        return view('home', compact('user','usuarios','amigos','solicitudesPendientes','ultimosDiarios', 'diariosPublicos', 'diariosAmigos', 'diariosPublicosTodos'));
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

    // Para la vista de Diairois Publicos en sidebar
    public function publicados(Request $request)
    {
        $query = $request->input('query');

        // Obtener los diarios públicos
        $diariosQuery = Diario::where('is_public', true);

        if ($query) {
            $diariosQuery = $diariosQuery->where('descripcion', 'LIKE', "%{$query}%");
        }

        $diarios = $diariosQuery->latest()->paginate(10);

        return view('diarios.index', compact('diarios'));
    }

    public function create()
    {
        $usuario = Auth::user();

        $diario = new Diario();
        //$diario->usuario_id = $usuario->id; // Relacionar con el usuario autenticado

        return view('diarios.create', compact('diario'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'in:planificado,en_curso,realizado',
            'is_public' => 'boolean',
            'imagen_principal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validación de Solapamiento de Fechas
        $fechaInicioSeleccionada = Carbon::parse($validated['fecha_inicio'])->startOfDay();
        $fechaFinalSeleccionada = Carbon::parse($validated['fecha_final'])->endOfDay(); // endOfDay para incluir el día completo

        $solapamientoQuery = Diario::where('user_id', $userId)
            ->where(function ($query) use ($fechaInicioSeleccionada, $fechaFinalSeleccionada) {
                $query->where('fecha_inicio', '<=', $fechaFinalSeleccionada)
                      ->where('fecha_final', '>=', $fechaInicioSeleccionada);
            });

        if ($solapamientoQuery->exists()) {
            // Si hay solapamiento, redirige atrás con un error específico
            return redirect()->back()
                ->withErrors(['fecha_inicio' => 'El rango de fechas seleccionado se solapa con un diario existente.'])
                ->withInput(); // Para rellenar el formulario con los datos previos
        }

        // Crear un nuevo diario utilizando los datos validados
        $diario = new Diario();
        $diario->user_id = Auth::id();
        $diario->titulo = $validated['titulo'];
        $diario->slug = Str::slug($validated['titulo'] . '-' . uniqid());

        // Asigna las fechas validadas
        $diario->fecha_inicio = $validated['fecha_inicio'];
        $diario->fecha_final = $validated['fecha_final'];

        $diario->estado = $validated['estado'] ?? 'planificado';
        $diario->is_public = $validated['is_public'] ?? false;

        $diario->save();

        // Procesar la imagen principal
        if ($request->hasFile('imagen_principal')) {
            $path = $request->file('imagen_principal')->store('imagenes/diarios', 'public');
        } else {
            // Imagen por defecto
            $path = 'imagenes/diarios/default.png';
        }

        DiarioImagen::create([
            'diario_id' => $diario->id,
            'url_imagen' => $path,
            'is_principal' => true
        ]);

        return redirect()->route('diarios.edit', $diario->slug)->with('success', 'Diario creado. Ahora puedes añadir más detalles y destinos.');
        // return redirect("/diarios/{$diario->slug}")->with('success', 'Diario creado correctamente.');
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

    public function getFechasOcupadas(Request $request)
    {
        $userId = Auth::id();
        $diarioActualId = $request->query('excluir_diario_id');

        $query = Diario::where('user_id', $userId)
                    ->whereNotNull('fecha_inicio')
                    ->whereNotNull('fecha_final');

        if ($diarioActualId) { $query->where('id', '!=', $diarioActualId); }

        $diarios = $query->get(['fecha_inicio', 'fecha_final']);

        $rangosOcupados = $diarios->map(function ($diario) {
            return [
                'from' => \Illuminate\Support\Carbon::parse($diario->fecha_inicio)->format('Y-m-d'),
                'to' => \Illuminate\Support\Carbon::parse($diario->fecha_final)->format('Y-m-d'),
            ];
        });
        return response()->json($rangosOcupados);
    }

    public function showCalendario()
    {
        return view('diarios.calendario');
    }

    public function getEventosCalendario()
    {
        $usuario = Auth::user();

        // Obtener los diarios del usuario autenticado con sus destinos
        $diarios = Diario::with('destinos')->where('user_id', $usuario->id)->get();

        $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

        $eventos = [];

        foreach ($diarios as $diario) {
            $color = '#' . substr(md5($diario->id), 0, 6); // Color consistente por diario

            // Evento principal del diario
            $eventos[] = [
                'title' => 'Diario: ' . $diario->titulo,
                'start' => $diario->fecha_inicio->toDateString(),
                'end' => $diario->fecha_final->copy()->addDay()->toDateString(),
                'description' => 'Diario completo',
                'color' => $color,
            ];

            // Eventos para cada destino
            foreach ($diario->destinos as $destino) {
                $eventos[] = [
                    'title' => 'Destino: ' . $destino->nombre_destino,
                    'start' => $destino->fecha_inicio_destino->toDateString(),
                    'end' => $destino->fecha_final_destino->copy()->addDay()->toDateString(),
                    'description' => 'Diario: ' . $diario->titulo,
                    'color' => $color,
                    'className' => ['evento-destino'],
                ];
            }
        }

        return response()->json($eventos);
    }


    public function mapa()
    {
        $user = Auth::user();

        $diarios = Diario::with('destinos')->where('user_id', $user->id)->get();

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
            // Divide el string por comas, quita espacios en blanco de cada etiqueta,y filtra elementos vacíos
            $etiquetasArray = array_filter(array_map('trim', explode(',', $request->input('etiquetas'))));
            $request->merge(['etiquetas' => $etiquetasArray]);
        } elseif ($request->input('etiquetas') === null && $request->has('etiquetas')) {
            // Si el campo 'etiquetas' se envía como null, lo convertimos a un array vacío para que la regla 'nullable|array' no sea null
            $request->merge(['etiquetas' => []]);
        }

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
            'etiquetas.*' => 'sometimes|string|max:50',
            'destinos' => 'nullable|array',
            'destinos.*' => 'exists:destinos,id',
        ], [
            'contenido.required' => 'El relato de tu viaje no puede quedar vacío',
        ]);

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
            // Si no se envía el campo 'destinos'
            // O no hacer nada si 'nullable' significa que no se actualizan.
            // $diario->destinos()->delete(); // Descomenta si este es el comportamiento deseado.
        }


        return redirect()->route('diarios.show', $diario->slug)->with('success', 'Diario actualizado correctamente.');
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
