@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
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
    </div>
@endsection
