@extends('layouts.app')

@section('content')

    @if($diario->imagenPrincipal)
        <div>
            <h2>Imagen Principal</h2>
            <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}" alt="Imagen Principal" width="300">
        </div>
        {{-- <pre>
            {{ dd($diario->imagenPrincipal->url_imagen) }}
        </pre> --}}
    @endif


    <h1>{{ $diario->titulo }}</h1>
    <p><strong>Destino:</strong> {{ $diario->destino }}</p>
    <p><strong>Contenido:</strong> {{ $diario->contenido }}</p>
    <p><strong>Fechas:</strong> {{ $diario->fecha_inicio }} - {{ $diario->fecha_final }}</p>

    {{-- Agrega otros campos como impacto_ambiental, libros, etc. si están disponibles --}}

    @if($diario->imagenes->count())
        <div class="mt-4">
            <h2>Galería</h2>
            <div class="grid grid-cols-3 gap-4">
                @foreach($diario->imagenes->where('is_principal', false) as $imagen)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $imagen->url_imagen) }}" alt="Imagen del diario" class="w-full h-auto rounded">

                        <!-- Botón eliminar -->
                        <form action="{{ route('diario-imagenes.destroy', $imagen->id) }}" method="POST"
                              class="absolute top-1 right-1 z-10">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('¿Eliminar esta imagen?');"
                                    class="text-white bg-red-600 rounded-full px-2 py-0.5 hover:bg-red-700 transition">
                                ❌
                            </button>
                        </form>

                        <!-- Formulario para establecer como principal -->
                        <form action="{{ route('diario-imagenes.establecerPrincipal', $imagen->id) }}" method="POST" class="mt-2 text-center">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                📌 Establecer como principal
                            </button>
                        </form>
                    </div>
                @endforeach
        </div>
    @endif


    @auth
        @if(auth()->id() === $diario->user_id)

            <form action="{{ route('diarios.agregarImagen', $diario->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>Agregar más imágenes:</label>
                <input type="file" name="imagenes[]" multiple>
                <button type="submit">Subir</button>
            </form>

            <a href="{{ route('diarios.edit', $diario->slug) }}" class="btn btn-primary">Editar</a>

            <form action="{{ route('diarios.destroy', $diario->slug) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        @endif
    @endauth


@endsection
