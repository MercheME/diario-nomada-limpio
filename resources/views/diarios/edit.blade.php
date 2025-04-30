
@extends('layouts.app')

@section('content')
    <h1>Editar Diario</h1>

    <form action="{{ route('diarios.update', $diario->slug) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="titulo" value="{{ old('titulo', $diario->titulo) }}">
        {{-- Más campos con valores precargados --}}

        <button type="submit">Actualizar</button>
    </form>
@endsection
