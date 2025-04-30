
@extends('layouts.app')

@section('content')
    <h1>Crear Diario</h1>

    <form action="{{ route('diarios.store') }}" method="POST">
        @csrf

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="{{ old('titulo') }}">
        @error('titulo') <div>{{ $message }}</div> @enderror

        <label for="destino">Destino:</label>
        <input type="text" name="destino" value="{{ old('destino') }}">
        @error('destino') <div>{{ $message }}</div> @enderror

        <label for="contenido">Contenido:</label>
        <textarea name="contenido">{{ old('contenido') }}</textarea>
        @error('contenido') <div>{{ $message }}</div> @enderror

        <label for="fecha_inicio">Fecha de inicio:</label>
        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}">
        @error('fecha_inicio') <div>{{ $message }}</div> @enderror

        <label for="fecha_final">Fecha final:</label>
        <input type="date" name="fecha_final" value="{{ old('fecha_final') }}">
        @error('fecha_final') <div>{{ $message }}</div> @enderror

        {{-- Otros campos como latitud, longitud, impactos, libros, etc. --}}

        <button type="submit">Guardar</button>
    </form>
@endsection
