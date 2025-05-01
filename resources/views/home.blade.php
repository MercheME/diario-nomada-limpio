@extends('layouts.app')

@section('content')
<section class="w-full max-w-4xl mx-auto p-6 space-y-10">

    <!-- Bienvenida con el nombre del usuario -->
    <div class="text-center mt-10">
        <h1 class="text-4xl font-bold text-gray-700 uppercase">Hola, {{ Auth::user()->name }} 👋</h1>
        <p class="text-gray-600 mt-2">Bienvenido a tu Diario de Viajes. Explora, crea y comparte tus experiencias.</p>
        <p class="text-gray-500">Descubre proyectos locales que impulsan tu comunidad.</p>
    </div>

    <!-- Últimos diarios -->
    <div>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">📝 Últimos diarios</h2>
        <ul class="space-y-2">
            @forelse ($ultimosDiarios as $diario)
                <li>
                    <a href="{{ route('diarios.show', $diario->slug) }}" class="text-blue-600 hover:underline">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                            @if($diario->imagenPrincipal)
                                <div class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                                    <div class="aspect-w-4 aspect-h-3 rounded-xl overflow-hidden">
                                        <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}"
                                        alt="Imagen Principal"
                                        class="object-contain w-full h-full transition-transform duration-500 group-hover:scale-105">
                                        <!-- Overlay de texto -->
                                        <div class="absolute inset-0 bg-opacity-40 flex flex-col justify-end p-4 text-white">
                                            <h1 class="text-lg font-semibold">{{ $diario->destino }}</h1>
                                            <h2 class="text-lg font-semibold">{{ $diario->titulo }}</h2>
                                            <p class="text-sm">{{ $diario->fecha_inicio }} - {{ $diario->fecha_final }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </a>

                </li>
            @empty
                <p class="text-gray-500">No has publicado diarios recientes.</p>
            @endforelse
        </ul>
    </div>

    <!-- Mis amigos -->
    <div>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">👥 Mis Amigos</h2>
        <ul class="space-y-4">
            @foreach ($amigos as $amigo)
                <li class="bg-white p-4 rounded-lg shadow flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <strong class="text-lg">{{ $amigo->name }}</strong><br>
                        <span class="text-gray-500">Email: {{ $amigo->email }}</span>
                    </div>
                    <form action="{{ route('amigos.eliminar', $amigo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar a este amigo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="mt-3 md:mt-0 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Eliminar Amigo</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Todos los usuarios -->
    <div>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">🌍 Todos los Usuarios</h2>
        <ul class="space-y-4">
            @foreach ($usuarios as $usuario)
                <li class="bg-gray-100 p-4 rounded-md flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <strong class="text-lg">{{ $usuario->name }}</strong><br>
                        <span class="text-gray-600">Email: {{ $usuario->email }}</span>
                    </div>
                    @if ($amigos->contains($usuario))
                        <span class="text-green-600 font-semibold mt-2 md:mt-0">Ya son amigos</span>
                    @elseif (Auth::user()->tieneSolicitudPendienteCon($usuario))
                        <span class="text-yellow-600 font-semibold mt-2 md:mt-0">Solicitud enviada</span>
                    @else
                        <form action="{{ route('solicitudes.enviar', $usuario) }}" method="POST" class="mt-2 md:mt-0">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Enviar solicitud</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Solicitudes de amistad -->
    <div>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">📨 Solicitudes de Amistad Pendientes</h2>
        <ul class="space-y-4">
            @forelse ($solicitudesPendientes as $solicitud)
                <li class="bg-yellow-100 p-4 rounded-md flex flex-col md:flex-row justify-between items-center">
                    <span class="text-gray-700"><strong>{{ $solicitud->user->name }}</strong> te ha enviado una solicitud.</span>
                    <div class="mt-2 md:mt-0 space-x-2">
                        <form action="{{ route('solicitudes.aceptar', $solicitud) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Aceptar</button>
                        </form>
                        <form action="{{ route('solicitudes.rechazar', $solicitud) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Rechazar</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="text-gray-500">No tienes solicitudes de amistad pendientes.</li>
            @endforelse
        </ul>
    </div>

    <!-- Enlace a todos los diarios -->
    <div class="text-center">
        <a href="{{ route('diarios.index') }}" class="text-blue-600 hover:underline text-lg">Ver todos los diarios</a>
    </div>
</section>
@endsection
