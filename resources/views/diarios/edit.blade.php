
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 sm:p-8 rounded-xl shadow-lg">

        <h1 class="text-3xl sm:text-4xl font-playfair font-bold italic text-gray-800 mb-8 text-center">
            Editando tu Diario de Viaje
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
                <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título del Diario</label>
                <input type="text" name="titulo" id="titulo"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                       value="{{ old('titulo', $diario->titulo) }}" required>
            </div>

            {{-- Contenido --}}
            <div>
                <label for="contenido" class="block text-sm font-medium text-gray-700 mb-1">Contenido Principal (Tu relato)</label>
                <textarea name="contenido" id="contenido" rows="10"
                          class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                          required>{{ old('contenido', $diario->contenido) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Escribe aquí la historia de tu viaje, tus anécdotas y reflexiones.</p>
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

            {{-- Estado (Público/Privado) --}}
            <div>
                <label for="is_public" class="block text-sm font-medium text-gray-700 mb-1">Visibilidad del Diario</label>
                <select name="is_public" id="is_public"
                        class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                    <option value="1" {{ old('is_public', $diario->is_public) == 1 ? 'selected' : '' }}>Público (Visible para todos)</option>
                    <option value="0" {{ old('is_public', $diario->is_public) == 0 ? 'selected' : '' }}>Privado (Solo para ti)</option>
                </select>
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

            {{-- SECCIÓN: REFLEXIONES --}}
            <div class="pt-4 mt-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Reflexiones del Viaje (Opcional)</h2>
                <div class="space-y-6">
                    <div>
                        <label for="impacto_ambiental" class="block text-sm font-medium text-gray-700 mb-1">Impacto Ambiental y Sostenibilidad</label>
                        <textarea name="impacto_ambiental" id="impacto_ambiental" rows="3"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('impacto_ambiental', $diario->impacto_ambiental) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">¿Observaciones sobre el entorno, prácticas sostenibles, o cómo el viaje afectó tu perspectiva ambiental?</p>
                    </div>
                    <div>
                        <label for="impacto_cultural" class="block text-sm font-medium text-gray-700 mb-1">Impacto y Aprendizaje Cultural</label>
                        <textarea name="impacto_cultural" id="impacto_cultural" rows="3"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('impacto_cultural', $diario->impacto_cultural) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">¿Interacciones significativas, nuevas perspectivas culturales, o cómo te impactó la cultura local?</p>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN: MEDIOS INSPIRADORES --}}
            <div class="pt-4 mt-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Medios Inspiradores (Opcional)</h2>
                <div class="space-y-6">
                    <div>
                        <label for="libros" class="block text-sm font-medium text-gray-700 mb-1">Libros que te inspiraron o acompañaron</label>
                        <textarea name="libros" id="libros" rows="2" placeholder="Ej: 'Cien años de soledad', 'Hacia rutas salvajes'"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('libros', $diario->libros) }}</textarea>
                    </div>
                    <div>
                        <label for="musica" class="block text-sm font-medium text-gray-700 mb-1">Banda sonora de tu viaje</label>
                        <textarea name="musica" id="musica" rows="2" placeholder="Ej: Artistas, álbumes o canciones específicas"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('musica', $diario->musica) }}</textarea>
                    </div>
                    <div>
                        <label for="peliculas" class="block text-sm font-medium text-gray-700 mb-1">Películas o series relacionadas</label>
                        <textarea name="peliculas" id="peliculas" rows="2" placeholder="Ej: 'Diarios de motocicleta', 'Lost in Translation'"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('peliculas', $diario->peliculas) }}</textarea>
                    </div>
                    <div>
                        <label for="documentales" class="block text-sm font-medium text-gray-700 mb-1">Documentales que te abrieron la mente</label>
                        <textarea name="documentales" id="documentales" rows="2" placeholder="Ej: 'Baraka', 'Human Planet'"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">{{ old('documentales', $diario->documentales) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Etiquetas --}}
            {{-- Para un mejor manejo de etiquetas, considera usar un componente JS tipo "tag input".
                 Por ahora, mantenemos el input de texto que espera comas. --}}
            <div class="pt-4 mt-6 border-t border-gray-200">
                <label for="etiquetas" class="block text-sm font-medium text-gray-700 mb-1">Etiquetas (separadas por comas)</label>
                @php
                    $etiquetasString = '';
                    if (old('etiquetas')) {
                        $etiquetasString = old('etiquetas');
                    } elseif (is_array($diario->etiquetas)) {
                        $etiquetasString = implode(',', $diario->etiquetas);
                    } elseif (is_string($diario->etiquetas)) {
                         // Si es un string JSON, intenta decodificarlo. Si no, úsalo como está.
                        $decoded = json_decode($diario->etiquetas, true);
                        $etiquetasString = is_array($decoded) ? implode(',', $decoded) : $diario->etiquetas;
                    }
                @endphp
                <input type="text" name="etiquetas" id="etiquetas"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                       value="{{ $etiquetasString }}"
                       placeholder="Ej: aventura, europa, gastronomía, senderismo">
                <p class="mt-1 text-xs text-gray-500">Añade palabras clave que describan tu viaje.</p>
            </div>

            {{-- Destinos Asociados --}}
            <div class="pt-4 mt-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Destinos de este Diario</h2>
                @if($diario->destinos->count() > 0)
                    <ul class="space-y-2 mb-4">
                        @foreach($diario->destinos as $destino)
                            <li class="p-2 bg-gray-50 rounded-md border border-gray-200 text-sm text-gray-700">
                                {{ $destino->nombre_destino }}
                                {{-- Aquí podrías añadir un pequeño botón para desvincular el destino si lo necesitas --}}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 mb-4">Aún no has añadido destinos a este diario.</p>
                @endif
                <a href="{{ route('destinos.create', ['diario' => $diario->slug, 'return_to' => route('diarios.edit', $diario->slug)]) }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Añadir o Gestionar Destinos
                </a>
                 <p class="mt-1 text-xs text-gray-500">Crea y asocia los lugares que visitaste en este viaje.</p>
            </div>

            {{-- Planificaciones (Mantenido comentado como en tu original) --}}
            {{-- <div class="form-group"> ... </div> --}}

            {{-- Botones de Acción del Formulario --}}
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
