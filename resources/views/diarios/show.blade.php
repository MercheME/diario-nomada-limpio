@extends('layouts.app')

@section('content')

{{-- Contenedor principal de la sección superior --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col lg:flex-row items-start gap-x-8 gap-y-6">

        {{-- Imagen Principal y Botones para editar, eliminar, cambiar de público a privado --}}
        <div class="w-full lg:w-2/5 space-y-6">
            @if($diario->imagenPrincipal)
                <div class="group relative overflow-hidden rounded-xl shadow-lg">
                    <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}"
                         alt="Imagen Principal de {{ $diario->titulo }}"
                         class="object-cover w-full h-auto max-h-[500px] rounded-xl transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute top-2 left-2 bg-black bg-opacity-60 text-white px-3 py-1 text-xs rounded-md">Imagen Principal</div>
                </div>
            @else
                <div class="w-full aspect-video bg-gray-200 rounded-xl flex items-center justify-center">
                    <p class="text-gray-500">Sin imagen principal</p>
                </div>
            @endif

            {{-- BOTONES PARA EL DUEÑO DEL DIARIO --}}
            @auth
                @if(auth()->id() === $diario->user_id)
                    <div class="pt-4 space-y-3">
                        <a href="{{ route('diarios.edit', $diario->slug) }}"
                           class="w-full inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium rounded-md shadow-sm
                                  text-white bg-slate-600 hover:bg-slate-700
                                  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500
                                  transition-colors duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar Diario
                        </a>

                        {{-- Botón para cambiar público/privado --}}
                        <form action="{{ route('diarios.togglePublic', $diario->slug) }}" method="POST" class="block w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    @class([
                                        'w-full inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium rounded-md shadow-sm text-white transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2',
                                        'bg-pink-600 hover:bg-pink-700 focus:ring-pink-500' => $diario->is_public,
                                        'bg-teal-600 hover:bg-teal-700 focus:ring-teal-500' => !$diario->is_public,
                                    ])>
                                @if($diario->is_public)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                    Convertir a Privado
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    Convertir a Público
                                @endif
                            </button>
                        </form>

                        {{-- Formulario para eliminar diario --}}
                        <form action="{{ route('diarios.destroy', $diario->slug) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este diario? Esta acción no se puede deshacer.');" class="block w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium rounded-md shadow-sm
                                           text-white bg-rose-600 hover:bg-rose-700
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-600
                                           transition-colors duration-150 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                Eliminar Diario
                            </button>
                        </form>
                    </div>

                    {{-- Subir imágen a la Galería del diario --}}
                    <div class="mt-6 border-t border-gray-300 pt-6">
                        <form action="{{ route('diarios.imagenStore', $diario->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div>
                                <div class="mb-4 p-3 bg-violet-50 border-l-4 border-violet-500 rounded-r-md">
                                    <h3 class="text-md font-semibold text-violet-700 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Añade imágenes a tu Galería de Recuerdos
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600 pl-7">
                                        Selecciona y añade aquí esas <strong class="font-medium text-gray-800">imágenes especiales</strong>: las que capturan la esencia de tu diario y los momentos que deseas atesorar y destacar.
                                    </p>
                                </div>
                                <label for="imagen-upload-input"
                                    class="block text-sm font-medium text-gray-600 mb-6 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-5 mr-2 text-gray-500 shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                    </svg>
                                    <span>En la galería puedes mostrar 12 imágenes como máximo</span>
                                </label>

                                {{-- Input de archivo oculto --}}
                                <input type="file"
                                    name="imagen"
                                    id="imagen-upload-input"
                                    class="hidden"
                                    onchange="displaySingleFileName(this, 'file-chosen-text-display')">

                                {{-- Botón/Label personalizado para seleccionar archivos --}}
                                <label for="imagen-upload-input"
                                    class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-violet-100 hover:bg-violet-200 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span>Elige un archivo</span>
                                </label>

                                {{-- Span para mostrar el nombre del archivo seleccionado --}}
                                <span id="file-chosen-text-display" class="ml-3 text-sm text-gray-600 align-middle">Ningún archivo seleccionado.</span>
                            </div>

                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-md font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Subir Imágen
                            </button>

                        </form>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Información del Diario --}}
        <div class="w-full lg:w-3/5 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="text-center mb-6">
                    <p class="text-gray-700 text-lg leading-relaxed">
                        “Cada diario es un testimonio de <span class="italic text-violet-600">experiencias</span> vividas,
                        <span class="italic text-violet-600">encuentros</span> inesperados y
                        <span class="italic text-violet-600">momentos</span> que dejan huella.
                        <span class="italic text-violet-600">Guarda tus recuerdos, comparte tus experiencias</span>
                        y deja que cada página refleje tu travesía. Porque viajar no es solo moverse, es transformar la manera en que vemos el mundo.”
                    </p>
                </div>
                <h1 class="text-3xl md:text-4xl font-playfair font-bold italic text-gray-900 mb-4">{{ $diario->titulo }}</h1>
                <div class="prose prose-lg max-w-none font-raleway text-gray-700 mb-6">
                    {!! nl2br(e($diario->contenido)) !!} {{-- nl2br(e()) para convertir saltos de línea y escapar HTML --}}
                </div>
                <div class="font-cascadia block bg-gray-100 p-3 rounded-md text-sm text-gray-600 mb-4">
                    <strong>Fechas del viaje:</strong><code> {{ \Carbon\Carbon::parse($diario->fecha_inicio)->isoFormat('DD MMM, YYYY') }} / {{ \Carbon\Carbon::parse($diario->fecha_final)->isoFormat('DD MMM, YYYY') }}</code>
                </div>
                <div class="font-cascadia block bg-gray-100 p-3 rounded-md text-sm text-gray-600">
                    <strong>Visibilidad del diario:</strong>
                    @if($diario->is_public)
                        <span class="ml-2 px-2 py-0.5 text-xs font-semibold text-green-800 bg-green-200 rounded-full">Público</span>
                    @else
                        <span class="ml-2 px-2 py-0.5 text-xs font-semibold text-red-800 bg-red-200 rounded-full">Privado</span>
                    @endif
                </div>
                {{-- Estado del Diario --}}
                @if($diario->estado)
                    <div class="font-cascadia block bg-gray-100 p-3 mt-4 rounded-md text-sm text-gray-600 mb-4">
                        <strong>Estado del viaje:</strong>
                        @if($diario->estado === 'planificado')
                            <span class="ml-2 px-2 py-0.5 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">Planificado</span>
                        @elseif($diario->estado === 'en_curso')
                            <span class="ml-2 px-2 py-0.5 text-xs font-semibold text-orange-800 bg-orange-200 rounded-full">En Curso</span>
                        @elseif($diario->estado === 'realizado')
                            <span class="ml-2 px-2 py-0.5 text-xs font-semibold text-emerald-800 bg-emerald-200 rounded-full">Realizado</span>
                        @else
                            <span class="ml-2 text-gray-700">{{ ucfirst($diario->estado) }}</span>
                        @endif
                    </div>
                @endif

                @if(!empty($diario->etiquetas) && is_array($diario->etiquetas))
                    <div class="font-cascadia block bg-gray-100 p-3 rounded-md text-sm text-gray-600 mb-4">
                        <strong>Etiquetas:</strong>
                        <div class="mt-1 flex flex-wrap gap-2">
                            @foreach($diario->etiquetas as $etiqueta)
                                <span class="px-2 py-0.5 text-xs font-medium text-violet-800 bg-violet-200 rounded-full">{{ $etiqueta }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Sección: Medios Inspiradores --}}
                @if($diario->libros || $diario->musica || $diario->peliculas || $diario->documentales)
                    <div class="bg-white p-6 rounded-xl shadow-sm mt-6">
                        <h2 class="text-2xl font-playfair font-semibold text-gray-800 mb-4 border-b pb-2">Inspiración para el Viaje</h2>
                        <div class="space-y-4 text-sm text-gray-700 font-raleway">
                            @if($diario->libros)
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Libros que inspiraron o acompañaron:</h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->libros)) !!}</p>
                                </div>
                            @endif
                            @if($diario->musica)
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Banda sonora del viaje:</h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->musica)) !!}</p>
                                </div>
                            @endif
                            @if($diario->peliculas)
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Películas o series relacionadas:</h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->peliculas)) !!}</p>
                                </div>
                            @endif
                            @if($diario->documentales)
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Documentales que abrieron la mente:</h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->documentales)) !!}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Sección: Reflexiones del Viaje --}}
                @if($diario->impacto_ambiental || $diario->impacto_cultural)
                    <div class="bg-white p-6 rounded-xl mt-6">
                        <h2 class="text-2xl font-playfair font-semibold text-gray-800 mb-4 border-b pb-2">Reflexiones del Viaje</h2>
                        <div class="space-y-4 text-sm text-gray-700 font-raleway">
                            @if($diario->impacto_ambiental)
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Impacto Ambiental y Sostenibilidad:</h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->impacto_ambiental)) !!}</p>
                                </div>
                            @endif
                            @if($diario->impacto_cultural)
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Impacto y Aprendizaje Cultural:</h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->impacto_cultural)) !!}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- SECCIÓN DE GALERÍA --}}
    @if($diario->imagenes->where('is_principal', false)->count() > 0)
        <div class="mt-12">
            <h2 class="text-3xl font-semibold mb-6 text-gray-800 text-center">Galería de Recuerdos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 xl:gap-8">
                @foreach($diario->imagenes->where('is_principal', false) as $imagen)
                    {{-- Foto Instantánea --}}
                    <div class="bg-white p-3 pt-3 pb-12 md:p-4 md:pt-4 md:pb-16 rounded-md shadow-xl hover:shadow-2xl transform group hover:-rotate-2 hover:scale-[1.03] transition-all duration-300 ease-in-out relative">
                        <div class="w-full aspect-square bg-gray-200 overflow-hidden rounded-sm">
                            <img src="{{ asset('storage/' . $imagen->url_imagen) }}" alt="Recuerdo de {{ $diario->titulo }}" class="w-full h-full object-cover"/>
                        </div>
                        <div class="mt-3 px-1">
                            <p class="text-sm text-gray-700 font-mono truncate" title="{{ $imagen->caption ?? $diario->titulo }}">
                                {{ $imagen->caption ?? Str::limit($diario->titulo, 30) }}
                            </p>
                            <p class="text-xs text-gray-500 font-mono pt-1">
                                <code class="text-xsm"> {{ \Carbon\Carbon::parse($diario->fecha_inicio)->isoFormat('DD MMM, YYYY') }} / {{ \Carbon\Carbon::parse($diario->fecha_final)->isoFormat('DD MMM, YYYY') }}</code>
                            </p>
                        </div>
                        @if(auth()->id() === $diario->user_id)
                            <div class="absolute top-1.5 right-1.5 z-10 flex flex-col space-y-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <form action="{{ route('diario-imagenes.destroy', $imagen->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta imagen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-red-500 text-white rounded-full shadow hover:bg-red-600 transition-colors focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </form>
                                <form action="{{ route('diario-imagenes.establecerPrincipal', $imagen->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-1.5 bg-blue-500 text-white rounded-full shadow hover:bg-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- SECCIÓN DE DESTINOS --}}
    @if($diario->destinos->count())
        <div class="mt-12">
            <h2 class="text-3xl font-semibold mb-6 text-gray-800 text-center">Destinos Explorados en este Viaje</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($diario->destinos as $destinoItem) {{-- $destinoItem para evitar conflicto con variable $destino en algunos contextos --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden group transform hover:scale-105 transition-transform duration-300">
                        <div class="relative h-56 bg-gray-200">
                            <img src="{{ asset('storage/' . ($destinoItem->imagenes->first() ? $destinoItem->imagenes->first()->url_imagen : 'imagenes/diarios/default.png')) }}"
                                 alt="Imagen de {{ $destinoItem->nombre_destino }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold font-playfair text-violet-700 mb-2">{{ $destinoItem->nombre_destino }}</h3>
                            <p class="text-sm text-gray-600 font-raleway mb-3">{{ Str::limit($destinoItem->descripcion, 120) }}</p>
                            <div class="flex justify-between items-center">
                                <a href="{{ route('destinos.show', $destinoItem->slug) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold">
                                    Ver Detalles &rarr;
                                </a>
                                @auth
                                    @if(auth()->id() === $diario->user_id)
                                        <form action="{{ route('destinos.destroy', $destinoItem->slug) }}" method="POST" onsubmit="return confirm('¿Eliminar este destino del diario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:text-red-700">Eliminar</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
    function displaySingleFileName(inputElement, textDisplayElementId) {
        const textContainer = document.getElementById(textDisplayElementId);
        if (textContainer) {
            // Asegurarse de que hay archivos y al menos uno seleccionado
            if (inputElement.files && inputElement.files.length > 0) {
                // Mostrar el nombre del primer (y único) archivo
                textContainer.textContent = inputElement.files[0].name;
            } else {
                textContainer.textContent = 'Ningún archivo seleccionado.';
            }
        }
    }
</script>

@endsection
