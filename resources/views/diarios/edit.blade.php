
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 sm:p-8 rounded-xl shadow-lg">

        <h1 class="text-3xl sm:text-4xl font-playfair font-bold italic text-gray-700 mb-8 text-center">
           <span class="text-violet-400 underline font-medium">Editando</span> tu Diario de Viaje
        </h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-700">Se encontraron {{ $errors->count() }} {{ Str::plural('error', $errors->count()) }}:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul role="list" class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('diarios.update', $diario->slug) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Título --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Información básica </h2>
                <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título del Diario</label>
                <input type="text" name="titulo" id="titulo"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                    value="{{ old('titulo', $diario->titulo) }}" required>
            </div>

            {{-- Fechas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                        value="{{ old('fecha_inicio', $diario->fecha_inicio ? \Carbon\Carbon::parse($diario->fecha_inicio)->format('Y-m-d') : '') }}" required>
                </div>
                <div>
                    <label for="fecha_final" class="block text-sm font-medium text-gray-700 mb-1">Fecha Final</label>
                    <input type="date" name="fecha_final" id="fecha_final"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                        value="{{ old('fecha_final', $diario->fecha_final ? \Carbon\Carbon::parse($diario->fecha_final)->format('Y-m-d') : '') }}" required>
                </div>
            </div>

            {{-- Estado del Viaje --}}
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado del Viaje</label>
                <select name="estado" id="estado"
                        class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                    <option value="planificado" {{ old('estado', $diario->estado) == 'planificado' ? 'selected' : '' }}>Planificado</option>
                    <option value="en_curso" {{ old('estado', $diario->estado) == 'en_curso' ? 'selected' : '' }}>En Curso</option>
                    <option value="realizado" {{ old('estado', $diario->estado) == 'realizado' ? 'selected' : '' }}>Realizado</option>
                </select>
            </div>

            {{-- Estado (Público/Privado) --}}
            <div>
                <label for="is_public" class="block text-sm font-medium text-gray-700 mb-1">Visibilidad del Diario</label>
                <select name="is_public" id="is_public"
                        class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                    <option value="1" {{ old('is_public', $diario->is_public) == 1 ? 'selected' : '' }}>Público</option>
                    <option value="0" {{ old('is_public', $diario->is_public) == 0 ? 'selected' : '' }}>Privado </option>
                </select>
            </div>

            {{-- Etiquetas --}}
            <div>
                <label for="etiquetas" class="block text-sm font-medium text-gray-700 mb-1">Categorías</label>
                @php
                    $etiquetasString = '';
                    if (old('etiquetas')) {
                        $etiquetasString = old('etiquetas');
                    } elseif (is_array($diario->etiquetas)) {
                        $etiquetasString = implode(',', $diario->etiquetas);
                    } elseif (is_string($diario->etiquetas)) {
                        $decoded = json_decode($diario->etiquetas, true);
                        // Si es un string JSON, intenta decodificarlo, sino, lo usa como está
                        $etiquetasString = is_array($decoded) ? implode(',', $decoded) : $diario->etiquetas;
                    }
                @endphp
                <input type="text" name="etiquetas" id="etiquetas"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                    value="{{ $etiquetasString }}"
                    placeholder="Ej: aventura, europa, gastronomía, senderismo">
                <p class="mt-1 text-xs text-gray-500">Añade palabras clave que describan tu viaje, por ejemplo: "gastronomía,cultura"</p>
            </div>

            {{-- Destinos Asociados --}}
            <div class="pt-4 mt-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Destinos de este Diario</h2>
                <p class="text-sm font-medium text-gray-700">Desglosa tu viaje en sus diferentes paradas o destinos que quieres visitar</p>
                <div class="block text-sm font-medium text-gray-600 mb-6 bg-violet-100 p-4 mt-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="size-5 mr-2 text-gray-500 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <p class="mt-1 text-xs text-gray-500">Cada <span class="font-extrabold">'destino' representa un lugar específico que exploraste o un momento destacado de tu aventura.</span> No dudes en añadir múltiples destinos para reflejar cada etapa de tu recorrido</p>
                </div>

                @if($diario->destinos->count() > 0)
                    <ul class="space-y-2 mb-4">
                        @foreach($diario->destinos as $destino)
                            <li class="p-2 bg-gray-50 rounded-md border border-gray-200 text-sm text-gray-700">
                                {{ $destino->nombre_destino }}
                                {{-- Botón para eliminar el destino --}}
                                {{-- <form action="{{ route('destinos.destroy', $destino->slug) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este destino? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" title="Eliminar destino">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form> --}}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 mb-4">Aún no has añadido destinos a este diario.</p>
                @endif

                <a href="{{ route('destinos.create', ['diario' => $diario->slug, 'return_to' => route('diarios.edit', $diario->slug)]) }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-violet-500 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Añadir un Destino
                </a>
            </div>

            {{-- Contenido --}}
            <div class="pt-4 mt-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Relato del Diario</h2>
                <label for="contenido" class="block text-sm font-medium text-gray-700 mt-3 mb-1">Escribe aquí la historia de tu viaje, tus anécdotas y reflexiones</label>
                <textarea name="contenido" id="contenido" rows="10"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                    required>{{ old('contenido', $diario->contenido) }}
                </textarea>
            </div>

            {{-- SECCIÓN: REFLEXIONES --}}
            <div class="pt-4 mt-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-baseline">Reflexiones del Viaje <pre class="ml-2 px-2 py-0.5 bg-gray-200 text-gray-600 text-xs font-medium rounded-md">OPCIONAL</pre></h2>
                <p class="text-sm font-medium text-gray-700">Tras el viaje, llega la reflexión. Este espacio es para   tus ideas sobre el impacto de nuevos entornos y culturas
                </p>
                <div class="space-y-6">
                    <div>
                        <label for="impacto_ambiental" class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 0 1-1.161.886l-.143.048a1.107 1.107 0 0 0-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 0 1-1.652.928l-.679-.906a1.125 1.125 0 0 0-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 0 0-8.862 12.872M12.75 3.031a9 9 0 0 1 6.69 14.036m0 0-.177-.529A2.25 2.25 0 0 0 17.128 15H16.5l-.324-.324a1.453 1.453 0 0 0-2.328.377l-.036.073a1.586 1.586 0 0 1-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 0 1-5.276 3.67m0 0a9 9 0 0 1-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                            </svg>
                            <span>Impacto Ambiental y Sostenibilidad</span>
                        </label>

                        <textarea name="impacto_ambiental" id="impacto_ambiental" rows="3"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('impacto_ambiental', $diario->impacto_ambiental) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">¿Observaciones sobre el entorno, prácticas sostenibles, o cómo el viaje afectó tu perspectiva ambiental?</p>
                    </div>
                    <div>
                        <label for="impacto_cultural" class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>

                            <span>Impacto y Aprendizaje Cultural</span>
                        </label>
                        <textarea name="impacto_cultural" id="impacto_cultural" rows="3"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('impacto_cultural', $diario->impacto_cultural) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">¿Interacciones significativas, nuevas perspectivas culturales, o cómo te impactó la cultura local?</p>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN: INSPIRACION --}}
            <div class="pt-4 mt-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-baseline">Inspiración del Viaje <pre class="ml-2 px-2 py-0.5 bg-gray-200 text-gray-600 text-xs font-medium rounded-md">OPCIONAL</pre></h2>
                <div class="space-y-6">
                    <div>
                        <label for="libros" class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            <span>Libros que te inspiraron o acompañaron</span>
                        </label>

                        <textarea name="libros" id="libros" rows="2" placeholder="Ej: 'Cien años de soledad', 'Hacia rutas salvajes'"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('libros', $diario->libros) }}
                        </textarea>
                    </div>
                    <div>
                        <label for="musica" class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 9 10.5-3m0 6.553v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 1 1-.99-3.467l2.31-.66a2.25 2.25 0 0 0 1.632-2.163Zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 0 1-.99-3.467l2.31-.66A2.25 2.25 0 0 0 9 15.553Z" />
                            </svg>
                            <span>Banda sonora de tu viaje</span>
                        </label>

                        <textarea name="musica" id="musica" rows="2" placeholder="Ej: Artistas, álbumes o canciones específicas"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('musica', $diario->musica) }}
                        </textarea>
                    </div>
                    <div>
                        <label for="peliculas" class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0 1 18 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0 1 18 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 0 1 6 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5" />
                            </svg>
                            <span>Películas o series relacionadas</span>
                        </label>
                        
                        <textarea name="peliculas" id="peliculas" rows="2" placeholder="Ej: 'Diarios de motocicleta', 'Lost in Translation'"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('peliculas', $diario->peliculas) }}</textarea>
                    </div>
                    <div>
                        <label for="documentales" class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>

                            <span>Documentales interesantes</span>

                        </label>
                        <textarea name="documentales" id="documentales" rows="2" placeholder="Ej: 'Baraka', 'Human Planet'"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('documentales', $diario->documentales) }}
                        </textarea>
                    </div>
                </div>
            </div>

            {{-- Botones del formulario --}}
            <div class="pt-8 mt-8 border-t border-gray-300 flex items-center justify-end space-x-3">
                <a href="{{ route('diarios.show', $diario->slug) }}"
                   class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-slate-700 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
                    Actualizar Diario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
