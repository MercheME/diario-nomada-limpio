@extends('layouts.app')

@section('content')

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
                                        Selecciona y añade aquí las imágenes especiales que capturan la esencia de tu diario y los momentos que deseas destacar
                                    </p>
                                </div>
                                <label for="imagen-upload-input"
                                    class="block text-sm font-medium text-gray-600 mb-6 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-5 mr-2 text-orange-500 shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                    </svg>
                                    <pre class="text-xs text-orange-600 ">En la galería puedes mostrar 12 imágenes como máximo</pre>
                                </label>

                                <div>
                                    <label for="imagen-upload-input"
                                    class="block text-sm font-medium text-gray-700 mb-3">
                                        <span>Elige una imagen</span>
                                    </label>

                                    <input type="file" name="imagen" id="imagen-upload-input" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-100 file:text-violet-700 hover:file:bg-violet-200 cursor-pointer" required>
                                    @error('imagen') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mt-4">
                                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción para el pie de foto de la imagen</label>
                                    <textarea name="descripcion" id="descripcion" rows="2" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                                Subir Imágen
                            </button>

                        </form>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Información del Diario --}}
        <div class="w-full lg:w-3/5 space-y-6">
            <div class="bg-white p-6 rounded-md shadow-sm">
                <div class="text-center mb-6">
                    <p class="text-gray-700 text-4xl leading-relaxed">
                        “Cada diario guarda una <span class="italic thin-underline underline-offset-6 text-violet-600">historia</span>.
                        Escribe lo que <span class="italic text-violet-600">viviste</span>, <span class="italic text-violet-600">sentiste</span>
                        y <span class="italic text-violet-600">conociste</span>.
                        <span class="italic text-violet-600 thin-underline underline-offset-6">Recordar</span> también es volver a <span class="italic text-violet-600 thin-underline underline-offset-6">viajar</span>”
                    </p>
                </div>

                <h1 class="text-3xl md:text-4xl font-playfair font-bold italic text-gray-900 mb-4">{{ $diario->titulo }}</h1>

                <div class="prose prose-lg max-w-none font-raleway text-gray-700 mb-6">
                    {!! nl2br(e($diario->contenido)) !!} {{-- nl2br(e()) para convertir saltos de línea y escapar HTML --}}
                </div>

                <!-- favorito -->
                <div class="font-cascadia flex items-center gap-2 bg-gray-100 p-2 rounded-md text-sm text-gray-600 mb-4">
                    <strong>Favorito: </strong>
                    @if (Auth::user()->diariosFavoritos->contains($diario->id))
                        <form action="{{ route('diarios.favorito.quitar', $diario) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('diarios.favorito.agregar', $diario) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            </button>
                        </form>
                    @endif

                </div>

                <div class="font-cascadia block bg-gray-100 p-3 rounded-md text-sm text-gray-600 mb-4">
                    <strong>Fechas del viaje:</strong><code> {{ \Carbon\Carbon::parse($diario->fecha_inicio)->isoFormat('DD MMM, YYYY') }} / {{ \Carbon\Carbon::parse($diario->fecha_final)->isoFormat('DD MMM, YYYY') }}</code>
                </div>

                <div class="font-cascadia block bg-gray-100 p-3 rounded-md text-sm text-gray-600 mb-4">
                    <strong>Autor del diario:</strong>
                    <span class="ml-2">{{ $diario->user->name }}</span>
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

                {{-- Etiquetas --}}
                @if(!empty($diario->etiquetas) && is_array($diario->etiquetas))
                    <div class="font-cascadia block bg-gray-100 p-3 rounded-md text-sm text-gray-600 mb-4">
                        <strong>Categorías:</strong>
                        <div class="mt-1 flex flex-wrap gap-2">
                            @foreach($diario->etiquetas as $etiqueta)
                                <span class="px-2 py-0.5 text-xs font-medium text-pink-700 bg-pink-200 rounded-full">{{ $etiqueta }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Sección: Reflexiones  --}}
                @if($diario->impacto_ambiental || $diario->impacto_cultural)
                    <div class="bg-gray-100 p-6 rounded-md mt-6">
                        <h2 class="text-lg font-semibold text-violet-700 mb-3 italic">Reflexiones</h2>
                        <div class="space-y-4 text-sm text-gray-700 font-raleway">
                            @if($diario->impacto_ambiental)
                                <div>
                                    <h3 class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 0 1-1.161.886l-.143.048a1.107 1.107 0 0 0-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 0 1-1.652.928l-.679-.906a1.125 1.125 0 0 0-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 0 0-8.862 12.872M12.75 3.031a9 9 0 0 1 6.69 14.036m0 0-.177-.529A2.25 2.25 0 0 0 17.128 15H16.5l-.324-.324a1.453 1.453 0 0 0-2.328.377l-.036.073a1.586 1.586 0 0 1-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 0 1-5.276 3.67m0 0a9 9 0 0 1-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                                        </svg>
                                        <span>Impacto Ambiental y Sostenibilidad:</span>
                                    </h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->impacto_ambiental)) !!}</p>
                                </div>
                            @endif
                            @if($diario->impacto_cultural)
                                <div>
                                    <h3 class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                        </svg>
                                        <span>Impacto y Aprendizaje Cultural:</span>
                                    </h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->impacto_cultural)) !!}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Sección Inspiracion --}}
                @if($diario->libros || $diario->musica || $diario->peliculas || $diario->documentales)
                    <div class="bg-gray-100 p-6 rounded-md mt-6">
                        <h2 class="text-lg font-semibold text-violet-700 mb-3 italic">Inspiración</h2>
                        <div class="space-y-4 text-sm text-gray-700 font-raleway">
                            @if($diario->libros)
                                <div>
                                    <h3 class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                        </svg>
                                        <span>Libros que inspiraron o acompañaron:</span>
                                    </h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->libros)) !!}</p>
                                </div>
                            @endif
                            @if($diario->musica)
                                <div>
                                    <h3 class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 9 10.5-3m0 6.553v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 1 1-.99-3.467l2.31-.66a2.25 2.25 0 0 0 1.632-2.163Zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 0 1-.99-3.467l2.31-.66A2.25 2.25 0 0 0 9 15.553Z" />
                                        </svg>
                                        <span>Banda sonora del viaje:</span>
                                    </h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->musica)) !!}</p>
                                </div>
                            @endif
                            @if($diario->peliculas)
                                <div>
                                    <h3 class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0 1 18 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0 1 18 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 0 1 6 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5" />
                                        </svg>
                                        <span>Películas o series relacionadas:</span>
                                    </h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->peliculas)) !!}</p>
                                </div>
                            @endif
                            @if($diario->documentales)
                                <div>
                                    <h3 class="block text-sm font-medium text-gray-700 mt-4 mb-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-violet-400 mr-2 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                        </svg>
                                        <span>Documentales interesantes:</span>
                                    </h3>
                                    <p class="pl-4 prose max-w-none">{!! nl2br(e($diario->documentales)) !!}</p>
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
            <h2 class="text-3xl font-semibold mb-6 text-gray-700 text-center italic"><span class="italic thin-underline underline-offset-6 text-violet-600">Galería</span> de Recuerdos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 xl:gap-8">
                @foreach($diario->imagenes->where('is_principal', false) as $imagen)
                    {{-- Foto Instantánea --}}
                    <div class="bg-white p-3 pt-3 pb-12 md:p-4 md:pt-4 md:pb-16 rounded-md shadow-xl hover:shadow-2xl transform group hover:-rotate-2 hover:scale-[1.03] transition-all duration-300 ease-in-out relative">
                        <div class="w-full aspect-square bg-gray-200 overflow-hidden rounded-sm">
                            <img src="{{ asset('storage/' . $imagen->url_imagen) }}" alt=" {{ $diario->titulo }}" class="w-full h-full object-cover"/>
                        </div>
                        <div class="mt-3 px-1">
                            <p class="text-sm text-gray-700 font-mono truncate" title="{{ $imagen->descripcion ?? $diario->titulo }}">
                                {{ Str::limit($imagen->descripcion, 30) ?? Str::limit($diario->titulo, 30) }}
                            </p>
                            <p class="text-xs text-gray-500 font-mono pt-1">
                                <span class="text-xsm mono"> {{ \Carbon\Carbon::parse($diario->fecha_inicio)->isoFormat('DD MMM, YYYY') }} / {{ \Carbon\Carbon::parse($diario->fecha_final)->isoFormat('DD MMM, YYYY') }}</span>
                            </p>
                        </div>
                        @if(auth()->id() === $diario->user_id)
                            <div class="absolute top-1.5 right-1.5 z-10 flex flex-col space-y-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <form action="{{ route('diario-imagenes.destroy', $imagen->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta imagen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-red-400 text-white rounded-full shadow hover:bg-red-400 transition-colors focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </form>
                                <form action="{{ route('diario-imagenes.establecerPrincipal', $imagen->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-1.5 bg-violet-500 text-white rounded-full shadow hover:bg-violet-600 transition-colors focus:outline-none focus:ring-2 focus:ring-violet-400 focus:ring-opacity-50">
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
            <h2 class="text-3xl font-semibold mb-6 text-gray-700 text-center italic"><span class="italic thin-underline underline-offset-6 text-violet-600">Destinos Explorados</span> en este Viaje</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($diario->destinos as $destinoItem)
                    <div class="bg-white rounded-md shadow-sm overflow-hidden group transform hover:scale-105 transition-transform duration-300">
                        <div class="relative h-56 bg-gray-200">
                            <img src="{{ asset('storage/' . ($destinoItem->imagenPrincipal ? $destinoItem->imagenPrincipal->url_imagen : ($destinoItem->imagenes->first() ? $destinoItem->imagenes->first()->url_imagen : 'imagenes/diarios/default.png'))) }}"
                                alt="Imagen de {{ $destinoItem->nombre_destino }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-semibold font-playfair text-gray-700 mb-2">{{ $destinoItem->nombre_destino }}</h3>
                            @php
                                $partesUbicacion = array_map('trim', explode(',', $destinoItem->ubicacion));
                                $pais = end($partesUbicacion);
                                $ciudad = (count($partesUbicacion) >= 4) ? $partesUbicacion[count($partesUbicacion) - 4] : $partesUbicacion[0];
                            @endphp
                            <p class="text-xs text-gray-600 font-raleway mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-3 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <span>{{ $ciudad }}, {{ $pais }}</span>
                            </p>
                            <p class="text-xs text-gray-600 font-raleway mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-3 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                </svg>
                                <span>{{ $destinoItem->fecha_inicio_destino->format('d-m-Y') }} / {{ $destinoItem->fecha_final_destino->format('d-m-Y') }}</span>
                            </p>
                            <div class="flex justify-between items-center">
                                <a href="{{ route('destinos.show', $destinoItem->slug) }}" class="text-sm text-violet-500 hover:text-violet-800 font-semibold">
                                    Ver Destino &rarr;
                                </a>
                                @auth
                                    @if(auth()->id() === $diario->user_id)
                                        <a href="{{ route('destinos.edit', $destinoItem->slug) }}"
                                        class="text-orange-500 hover:text-orange-700 p-1 rounded-full flex items-center focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50"
                                        title="Editar destino">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span class="text-sm">Editar</span>
                                        </a>
                                        <form action="{{ route('destinos.destroy', $destinoItem->slug) }}" method="POST" onsubmit="return confirm('¿Eliminar este destino del diario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 p-1 rounded-full flex items-center focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-3 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span class="text-sm">Eliminar</span>
                                        </button>
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

@endsection
