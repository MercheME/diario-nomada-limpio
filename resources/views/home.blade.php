@extends('layouts.app')

@section('content')
<section class="w-full max-w-4xl mx-auto bg-orange-50 p-6 space-y-10">

    <!-- mensaje de bienvenida -->
    <div class="text-center mt-10">
        <p class="text-gray-800 text-6xl mt-4 "><span class="italic text-violet-400 thin-underline underline-offset-6">Registra</span> tus viajes, <span class="italic text-violet-400 thin-underline underline-offset-6">planifica</span> tus aventuras y <span class="italic text-violet-400 thin-underline underline-offset-6">reflexiona</span> sobre cada paso</p>
    </div>

    <div class="text-center mt-6">
        <a href="{{ route('diarios.index') }}" class="inline-flex items-center justify-center text-lg text-white bg-violet-600 hover:bg-violet-700 py-2 px-6 rounded-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <span>Accede a tus Diarios de Viajes</span>
            <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" class="feather feather-arrow-right"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"></path></svg>
        </a>
    </div>

    <div class="max-w-7xl mx-auto p-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Información del usuario (Izquierda) -->
            <div class="flex-1 bg-white border border-gray-300 rounded-sm p-6">
                <div class="flex items-center space-x-6">
                    <!-- Foto del usuario -->
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Foto de perfil" class="w-24 h-24 rounded-sm border-2 border-violet-500">

                    <!-- Información del usuario -->
                    <div class="flex flex-col justify-center">
                        <div class="flex items-center space-x-2"> <!-- Añadimos un flex para la alineación -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-violet-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <h2 class="text-2xl font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email }}</p>

                    </div>
                </div>

                <!-- Bio del usuario -->
                <div class="mt-4 text-gray-700 text-sm">
                    <p>{{ Auth::user()->bio }}</p>
                </div>

                <!-- Botón de edición de perfil -->
                <div class="mt-6 text-center">
                    <a href="" class="inline-flex items-center justify-center px-3 py-1 border border-gray-300 text-gray-700 bg-violet-200 rounded-xl hover:bg-violet-400 hover:text-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-violet-500">
                        Editar Perfil
                    </a>
                </div>
            </div>

            <div class="flex-1 bg-white border border-gray-300 rounded-sm p-6">
                <!-- Título -->
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-violet-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                    </svg>
                    <span>Mis Amigos</span>
                </h2>

                <!-- Sección de Solicitudes Pendientes -->
                @if ($solicitudesPendientes->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Solicitudes de Amistad</h3>
                        <ul class="space-y-3">
                            @foreach ($solicitudesPendientes as $solicitud)
                                <li class="flex items-center justify-between bg-orange-50 p-3 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ asset('storage/' . $solicitud->user->profile_image) }}" alt="Foto de {{ $solicitud->user->name }}" class="w-10 h-10 rounded-full border-2 border-violet-500">
                                        <span class="font-medium">{{ $solicitud->user->name }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <!-- Botón aceptar -->
                                        <form action="{{ route('solicitudes.aceptar', $solicitud) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="relative group p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-green-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                </svg>
                                            </button>
                                        </form>
                                        <!-- Botón rechazar -->
                                        <form action="{{ route('solicitudes.rechazar', $solicitud) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="relative group p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor"
                                                    class="size-6 text-red-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Lista de Amigos -->
                <ul class="space-y-4">
                    @foreach ($amigos as $amigo)
                        <li class="bg-white p-4 rounded-lg flex flex-col md:flex-row justify-between items-center">
                            <!-- Imagen + nombre alineados -->
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $amigo->profile_image) }}" alt="Foto de {{ $amigo->name }}" class="w-12 h-12 rounded-full border-2 border-violet-500">
                                <strong class="text-lg">{{ $amigo->name }}</strong>
                            </div>

                            <!-- Botón eliminar -->
                            <form action="{{ route('amigos.eliminar', $amigo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar a este amigo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="relative group p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-6 text-red-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>




    <div class="mt-10 w-full flex flex-col items-center">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">📝 Últimos Diarios</h2>

        <div class="flex overflow-x-auto space-x-4 pb-4 w-full md:w-auto">
            @forelse ($ultimosDiarios as $diario)
                <div class="w-[300px] h-[400px] flex-shrink-0 bg-white rounded-xl shadow-lg overflow-hidden">
                    <a href="{{ route('diarios.show', $diario->slug) }}" class="block h-full">
                        @if($diario->imagenPrincipal)
                            <div class="group relative w-full h-full overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                                <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}" alt="Imagen Principal" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105 rounded-xl">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-4 text-white">
                                    <h1 class="text-lg font-semibold">{{ $diario->destino }}</h1>
                                    <h2 class="text-lg font-semibold">{{ $diario->titulo }}</h2>
                                    <p class="text-sm">{{ $diario->fecha_inicio }} - {{ $diario->fecha_final }}</p>
                                </div>
                            </div>
                        @endif
                    </a>
                </div>
            @empty
                <p class="text-gray-500">No has publicado diarios recientes.</p>
            @endforelse
        </div>
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

</section>
@endsection
