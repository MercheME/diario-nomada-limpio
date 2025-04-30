@extends('layouts.app')

@section('content')

<section class="flex flex-col gap-10 w-full justify-center">
    <h1 class="text-4xl text-center mt-10 uppercase font-bold text-gray-700">Bienvenido a tu Diario de Viajes</h1>

    <p class="text-center text-gray-600">Explora, crea y comparte tus experiencias. Descubre proyectos locales que impulsan tu comunidad.</p>

    <h2 class="text-2xl mt-6 font-semibold text-gray-600">Últimos diarios</h2>
    <ul class="space-y-2">
        @forelse ($ultimosDiarios as $diario)
            <li>
                <a href="{{ route('diarios.show', $diario->slug) }}" class="text-blue-500">{{ $diario->titulo }}</a>
            </li>
        @empty
            <p>No hay diarios recientes.</p>
        @endforelse
    </ul>

    <h2>Diarios Publicados</h2>
    {{-- <ul>
        @forelse ($diariosPublicados as $diario)
            <li>
                <a href="{{ route('diarios.show', $diario->slug) }}">
                    {{ $diario->titulo }}
                </a>
            </li>
        @empty
            <li>No hay diarios publicados.</li>
        @endforelse
    </ul> --}}

    <h2>Mis Amigos</h2>
    <ul>
        @foreach ($amigos as $amigo)
            <li>
                <strong>{{ $amigo->name }}</strong><br>
                Email: {{ $amigo->email }}<br>
                {{-- Fecha de amistad: {{ $amigo->pivot->created_at->format('d/m/Y') }}<br> --}}
                <!-- Aquí puedes agregar más información si lo deseas -->
            </li>
        @endforeach
    </ul>

    <h2>Todos los Usuarios</h2>
    <ul>
        @foreach ($usuarios as $usuario)
            <li>
                <strong>{{ $usuario->name }}</strong><br>
                Email: {{ $usuario->email }}<br>
                @if ($amigos->contains($usuario))
                    <span>Ya son amigos</span>
                @else
                    <form action="{{ route('solicitudes.enviar', $usuario) }}" method="POST">
                        @csrf
                        <button type="submit">Enviar solicitud de amistad</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>

    <h2>Solicitudes de Amistad Pendientes</h2>
    <ul>
        @forelse ($solicitudesPendientes as $solicitud)
            <li>
                <strong>{{ $solicitud->user->name }}</strong> te ha enviado una solicitud de amistad.
                <form action="{{ route('solicitudes.aceptar', $solicitud) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Aceptar</button>
                </form>
                <form action="{{ route('solicitudes.rechazar', $solicitud) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Rechazar</button>
                </form>
            </li>
        @empty
            <li>No tienes solicitudes de amistad pendientes.</li>
        @endforelse
    </ul>

    <a href="{{ route('diarios.index') }}" class="text-blue-500 mt-4">Ver todos los diarios</a>
</section>

@endsection
