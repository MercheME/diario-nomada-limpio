<!-- resources/views/solicitudes/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Solicitudes Pendientes</h1>
    <ul>
        @foreach($solicitudesPendientes as $solicitud)
            <li>
                {{ $solicitud->user->name }} ha enviado una solicitud de amistad.
                <form action="{{ route('solicitudes.aceptar', $solicitud) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('POST')
                    <button type="submit">Aceptar</button>
                </form>
                <form action="{{ route('solicitudes.rechazar', $solicitud) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('POST')
                    <button type="submit">Rechazar</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
