
@extends('layouts.app')

@section('content')
    <h1>Editar Diario</h1>

    <form action="{{ route('diarios.update', $diario->slug) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Título -->
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $diario->titulo) }}" required>
        </div>

        <!-- Contenido -->
        <div class="form-group">
            <label for="contenido">Contenido</label>
            <textarea name="contenido" id="contenido" class="form-control" rows="5" required>{{ old('contenido', $diario->contenido) }}</textarea>
        </div>

        <!-- Fechas -->
        <div class="form-group">
            <label for="fecha_inicio">Fecha de Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $diario->fecha_inicio) }}" required>
        </div>

        <div class="form-group">
            <label for="fecha_final">Fecha Final</label>
            <input type="date" name="fecha_final" id="fecha_final" class="form-control" value="{{ old('fecha_final', $diario->fecha_final) }}" required>
        </div>

        <!-- Estado (Público/Borrador) -->
        <div class="form-group">
            <label for="is_public">¿Es público?</label>
            <select name="is_public" id="is_public" class="form-control">
                <option value="1" {{ $diario->is_public ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ !$diario->is_public ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <!-- Impacto Ambiental -->
        <div class="form-group">
            <label for="impacto_ambiental">Impacto Ambiental</label>
            <textarea name="impacto_ambiental" id="impacto_ambiental" class="form-control">{{ old('impacto_ambiental', $diario->impacto_ambiental) }}</textarea>
        </div>

        <!-- Impacto Cultural -->
        <div class="form-group">
            <label for="impacto_cultural">Impacto Cultural</label>
            <textarea name="impacto_cultural" id="impacto_cultural" class="form-control">{{ old('impacto_cultural', $diario->impacto_cultural) }}</textarea>
        </div>

        <!-- Etiquetas -->
        @php
        $etiquetasArray = is_array($diario->etiquetas)
            ? $diario->etiquetas
            : ( $diario->etiquetas ? json_decode($diario->etiquetas, true) : []);
        @endphp

        <input type="text" name="etiquetas" id="etiquetas" class="form-control" value="{{ old('etiquetas', implode(',', $diario->etiquetas ?? [])) }}">

        <!-- Destinos -->
        <div class="form-group">
            <div class="form-group">
                <label for="destinos">Destinos Asociados</label>
                <ul>
                    @foreach($diario->destinos as $destino)
                        <li>{{ $destino->nombre_destino }}</li>

                    @endforeach
                </ul>
            </div>

            <!-- Botón para añadir un nuevo destino -->
            <a href="{{ route('destinos.create', ['diario' => $diario->slug, 'return_to' => route('diarios.edit', $diario->slug)]) }}" class="btn btn-secondary mt-2">Añadir nuevo destino</a>

        </div>

        <!-- Planificaciones (Opcional) -->
        {{-- <div class="form-group">
            <label for="planificaciones">Planificaciones</label>
            <div id="planificaciones-container">
                @foreach ($diario->planificaciones as $planificacion)
                    <div class="form-group">
                        <input type="date" name="planificaciones[{{ $loop->index }}][fecha]" class="form-control" value="{{ $planificacion->fecha }}" required>
                        <textarea name="planificaciones[{{ $loop->index }}][descripcion]" class="form-control">{{ $planificacion->descripcion }}</textarea>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-planificacion" class="btn btn-secondary">Añadir Planificación</button>
        </div> --}}

        <!-- Botones -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Actualizar Diario</button>
            <a href="{{ route('diarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
