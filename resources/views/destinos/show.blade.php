@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-md overflow-hidden mb-3">
            <div class="p-6">

                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-playfair font-bold italic text-gray-900 mb-3">{{ $destino->nombre_destino }}</h1>

                        <div class="font-cascadia block bg-gray-100 p-3 rounded-md text-sm text-gray-600 mb-4">
                            <strong>Fechas del destino:</strong>
                            <code>
                                {{ $destino->fecha_inicio_destino ? \Carbon\Carbon::parse($destino->fecha_inicio_destino)->isoFormat('DD MMM, YYYY') : 'N/A' }} /
                                {{ $destino->fecha_final_destino ? \Carbon\Carbon::parse($destino->fecha_final_destino)->isoFormat('DD MMM, YYYY') : 'N/A' }}
                            </code>
                        </div>

                        <p class="text-md text-gray-700 font-raleway mb-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-2 text-violet-600 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <span>{{ $destino->ubicacion }}</span>
                        </p>

                    </div>
                    <div class="flex-shrink-0 mt-4 md:mt-0">
                        @auth
                            @if(Auth::id() === $destino->diario->user_id)
                            <a href="{{ route('destinos.edit', $destino->slug) }}"
                            class="inline-flex items-center gap-x-1 p-2 border border-transparent shadow-sm text-sm rounded-md text-white bg-slate-600 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar Destino
                            </a>
                            @endif
                        @endauth
                    </div>

                </div>

                @if($destino->relato)
                    <div class="prose prose-lg max-w-none font-raleway text-gray-700 mb-6 mt-4 pt-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-2 text-violet-600 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            Relato del Destino
                        </h3>
                        {!! nl2br(e($destino->relato)) !!}
                    </div>
                @endif

                @if(!empty($destino->alojamiento))
                    <div class="mt-4 pt-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-2 text-violet-600 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Alojamiento
                        </h3>
                        <div class="prose max-w-none font-raleway text-sm text-gray-700">
                            {!! nl2br(e($destino->alojamiento)) !!}
                        </div>
                    </div>
                @endif

                @if(!empty($destino->personas_conocidas))
                    <div class="mt-4 pt-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-2 text-violet-600 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            Personas Conocidas en este Destino
                        </h3>
                        <div class="prose max-w-none font-raleway text-sm text-gray-700">
                            {!! nl2br(e($destino->personas_conocidas)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>


        <div class="mt-3 pt-8">
            @auth
                @if(Auth::id() === $destino->diario->user_id)
                <div class="mb-8 p-6 bg-white rounded-sm">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Añadir Nueva Imagen a la galería de Imágenes</h3>
                    <form action="{{ route('destinos.imagenes.store', $destino->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="imagen-destino-upload" class="block text-sm font-medium text-gray-700 mb-1">
                            </label>
                            <input type="file" name="imagen" id="imagen-destino-upload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-100 file:text-violet-700 hover:file:bg-violet-200 cursor-pointer" required>
                            @error('imagen') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="descripcion-destino" class="block text-sm font-medium text-gray-700 mb-1">Descripción para el pie de foto</label>
                            <textarea name="descripcion" id="descripcion-destino" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-violet-500 focus:border-violet-500"></textarea>
                        </div>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                            Añadir a la Galería
                        </button>
                    </form>
                </div>
                @endif
            @endauth

            <h2 class="text-3xl font-semibold mb-6 text-gray-700 text-center italic">Galería de Imágenes del Destino</h2>
            @if($destino->imagenes->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($destino->imagenes as $imagen)
                        <div class="bg-white p-3 pt-3 pb-12 md:p-4 md:pt-4 md:pb-16 rounded-md shadow-xl hover:shadow-2xl transform group hover:-rotate-2 hover:scale-[1.03] transition-all duration-300 ease-in-out relative">
                            <img src="{{ asset('storage/' . $imagen->url_imagen) }}" alt="{{ $imagen->descripcion ?? 'Imagen del destino ' . $destino->nombre_destino }}" class="w-full h-56 object-cover rounded-sm mb-2">

                            @if($imagen->descripcion)
                                <p class="text-xs text-gray-600 truncate" title="{{$imagen->descripcion}}">{{ $imagen->descripcion }}</p>
                            @endif

                            @auth
                                @if(Auth::id() === $destino->diario->user_id)
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col space-y-1 z-10">

                                        @if(!$imagen->is_principal)
                                            <form action="{{ route('destino_imagenes.destroy', $imagen->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta imagen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-red-500 text-white rounded-full shadow hover:bg-red-600" title="Eliminar imagen">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="p-1.5 bg-gray-300 text-gray-500 rounded-full shadow cursor-not-allowed" title="No se puede eliminar la imagen principal" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        @endif

                                        @if(!$imagen->is_principal)
                                            <form action="{{ route('destino_imagenes.establecerPrincipal', $imagen->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-1.5 bg-violet-500 text-white rounded-full shadow hover:bg-violet-600" title="Establecer como principal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            @endauth

                            @if($imagen->is_principal)
                                <div class="absolute top-2 left-2 bg-black bg-opacity-50 text-white px-2 py-0.5 text-xs rounded">Principal</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center">Este destino aún no tiene imágenes en su galería.</p>
            @endif
        </div>

        <div class="mt-8 pt-6 flex items-center space-x-4">
            <a href="{{ route('diarios.show', $destino->diario->slug) }}"
                class="inline-flex items-center justify-center px-4 py-2 rounded-md font-semibold text-sm text-gray-700 bg-violet-200 hover:bg-violet-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-400 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al Diario
            </a>
        </div>
    </div>
@endsection
