@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
    <h1 class="text-2xl font-bold mb-6">{{ $destino->nombre }}</h1>

    <!-- Información del destino -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Descripción</h2>
        <p>{{ $destino->descripcion }}</p>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold">Fechas</h2>
        <p><strong>Inicio:</strong> {{ $destino->fecha_inicio }}</p>
        <p><strong>Final:</strong> {{ $destino->fecha_final }}</p>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold">Relato</h2>
        <p>{{ $destino->relato }}</p>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold">Transporte</h2>
        <p>{{ $destino->transporte }}</p>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold">Alojamiento</h2>
        <p>{{ $destino->alojamiento }}</p>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold">Personas Conocidas</h2>
        <p>{{ $destino->personas_conocidas }}</p>
    </div>

    <!-- Mapa de la ubicación -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Ubicación</h2>
        <div id="mapa" style="height: 300px;"></div>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold">Etiquetas</h2>
        <p>
            @foreach($destino->etiquetas as $etiqueta)
                <span class="bg-gray-200 text-sm px-2 py-1 rounded-full">{{ $etiqueta }}</span>
            @endforeach
        </p>
    </div>

    <!-- Opciones de edición y eliminación si el usuario es el propietario del destino -->
    @auth
        @if(auth()->id() === $destino->user_id)
            <div class="mt-6">
                <a href="{{ route('destinos.edit', $destino->id) }}" class="btn btn-warning">Editar Destino</a>
            </div>

            <form action="{{ route('destinos.destroy', $destino->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');" class="inline-block mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar Destino</button>
            </form>
        @endif
    @endauth
</section>

<script>
    var map = L.map('mapa').setView([{{ $destino->latitud }}, {{ $destino->longitud }}], 13); // Centrado en las coordenadas del destino

    // Cargar OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Crear un marcador en la ubicación del destino
    L.marker([{{ $destino->latitud }}, {{ $destino->longitud }}]).addTo(map)
        .bindPopup("<b>{{ $destino->nombre }}</b><br>{{ $destino->descripcion }}")
        .openPopup();
</script>
@endsection
