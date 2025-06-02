@extends('layouts.app')

@section('content')
    {{-- <div class="container mx-auto">
        <h2 class="text-3xl font-semibold">{{ $destino->nombre_destino }}</h2>

        <div class="mt-6">
            <p><strong>Descripción:</strong> {{ $destino->descripcion }}</p>
            <p><strong>Ubicación:</strong> {{ $destino->ubicacion }}</p>
            <p><strong>Fecha de inicio:</strong> {{ $destino->fecha_inicio_destino }}</p>
            <p><strong>Fecha de finalización:</strong> {{ $destino->fecha_final_destino }}</p>
            <p><strong>Transporte:</strong> {{ $destino->transporte }}</p>
            <p><strong>Alojamiento:</strong> {{ $destino->alojamiento }}</p>
            <p><strong>Relato:</strong> {{ $destino->relato }}</p>

            <div class="mt-6">
                <h3 class="text-xl font-semibold">Imágenes del Destino</h3>
                @foreach($destino->imagenes as $imagen)
                    <img src="{{ asset('storage/' . $imagen->url_imagen) }}" alt="Imagen de {{ $destino->nombre_destino }}" class="w-full h-64 object-cover mt-4">
                @endforeach
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('diarios.show', $destino->diario->slug) }}"
            class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                ← Volver al Diario
            </a>
        </div>
    </div> --}}

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Sección de Información del Destino --}}
    <div class="bg-white shadow-xl rounded-lg overflow-hidden mb-8">
        <div class="p-6">
            <h1 class="text-3xl md:text-4xl font-playfair font-bold italic text-gray-900 mb-3">{{ $destino->nombre_destino }}</h1>

            {{-- Ubicación con Icono --}}
            <p class="text-md text-gray-700 font-raleway mb-1 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-2 text-violet-600 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                <span>{{ $destino->ubicacion }}</span>
            </p>

            {{-- Fechas del Destino --}}
            <div class="font-cascadia block bg-gray-100 p-3 rounded-md text-sm text-gray-600 mb-4">
                <strong>Fechas del destino:</strong>
                <code>
                    {{ $destino->fecha_inicio_destino ? \Carbon\Carbon::parse($destino->fecha_inicio_destino)->isoFormat('DD MMM, YYYY') : 'N/A' }} /
                    {{ $destino->fecha_final_destino ? \Carbon\Carbon::parse($destino->fecha_final_destino)->isoFormat('DD MMM, YYYY') : 'N/A' }}
                </code>
            </div>

            {{-- Relato del Destino --}}
            @if($destino->relato)
                <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">Relato del Destino:</h2>
                <div class="prose prose-lg max-w-none font-raleway text-gray-700 mb-6">
                    {!! nl2br(e($destino->relato)) !!}
                </div>
            @endif

            {{-- Alojamiento y Personas Conocidas (si existen) --}}
            {{-- ... puedes añadir más detalles del destino aquí ... --}}

            @auth
                @if(Auth::id() === $destino->diario->user_id)
                    <div class="mt-6">
                        <a href="{{ route('destinos.edit', $destino->slug) }}" class="text-indigo-600 hover:text-indigo-800">Editar Destino</a>
                    </div>
                @endif
            @endauth
        </div>
    </div>


    {{-- SECCIÓN DE GALERÍA DE IMÁGENES DEL DESTINO --}}
    @auth {{-- Solo mostrar opciones de gestión si está autenticado --}}
        @if(Auth::id() === $destino->diario->user_id) {{-- Y es el dueño del diario padre --}}
            <div class="mt-8 border-t border-gray-300 pt-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Galería de Imágenes del Destino</h2>

                {{-- Formulario para subir nuevas imágenes al Destino --}}
                <div class="mb-8 p-4 bg-white shadow rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Añadir Nueva Imagen al Destino</h3>
                    <form action="{{ route('destinos.imagenes.store', $destino->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label for="imagen-destino-upload" class="block text-sm font-medium text-gray-700">Seleccionar Imagen</label>
                            <input type="file" name="imagen" id="imagen-destino-upload" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" required>
                            @error('imagen') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="descripcion-destino" class="block text-sm font-medium text-gray-700">Descripción (Opcional)</label>
                            <textarea name="descripcion" id="descripcion-destino" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        {{-- Considera si necesitas 'is_principal' para imágenes de destino --}}
                        {{-- <div class="flex items-center">
                            <input type="checkbox" name="is_principal" id="is_principal_destino" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            <label for="is_principal_destino" class="ml-2 block text-sm text-gray-900">Marcar como imagen principal del destino</label>
                        </div> --}}
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-violet-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-violet-700">Subir Imagen</button>
                    </form>
                </div>

                {{-- Mostrar imágenes existentes --}}
                @if($destino->imagenes->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($destino->imagenes as $imagen)
                            <div class="group relative bg-white p-3 rounded-md shadow-lg">
                                <img src="{{ asset('storage/' . $imagen->url_imagen) }}" alt="{{ $imagen->descripcion ?? 'Imagen del destino ' . $destino->nombre_destino }}" class="w-full h-48 object-cover rounded-md mb-2">
                                @if($imagen->descripcion)
                                    <p class="text-xs text-gray-600 truncate" title="{{$imagen->descripcion}}">{{ $imagen->descripcion }}</p>
                                @endif

                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col space-y-1 z-10">
                                    {{-- Botón Eliminar Imagen --}}
                                    <form action="{{ route('destino_imagenes.destroy', $imagen->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta imagen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-500 text-white rounded-full shadow hover:bg-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </form>
                                    {{-- Botón Establecer Principal (si aplica) --}}
                                    @if(!$imagen->is_principal)
                                    <form action="{{ route('destino_imagenes.establecerPrincipal', $imagen->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="p-1.5 bg-blue-500 text-white rounded-full shadow hover:bg-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @if($imagen->is_principal)
                                    <div class="absolute top-2 left-2 bg-black bg-opacity-50 text-white px-2 py-0.5 text-xs rounded">Principal</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">Este destino aún no tiene imágenes en su galería.</p>
                @endif
            </div>
        @endif
    @endauth

</div>
@endsection
