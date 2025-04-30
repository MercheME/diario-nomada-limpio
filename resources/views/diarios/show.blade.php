@extends('layouts.app')

@section('content')
    <h1>{{ $diario->titulo }}</h1>
    <p><strong>Destino:</strong> {{ $diario->destino }}</p>
    <p><strong>Contenido:</strong> {{ $diario->contenido }}</p>
    <p><strong>Fechas:</strong> {{ $diario->fecha_inicio }} - {{ $diario->fecha_final }}</p>

    {{-- Agrega otros campos como impacto_ambiental, libros, etc. si están disponibles --}}

    <a href="{{ route('diarios.edit', $diario->slug) }}">Editar</a>

    <form action="{{ route('diarios.destroy', $diario->slug) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
    </form>
@endsection
