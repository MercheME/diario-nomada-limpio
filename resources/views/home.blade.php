@extends('layouts.app')

@section('content')
<section class="w-full max-w-4xl mx-auto bg-gray-50 p-6 space-y-10">

    <div class="text-center mt-4">
        <p class="text-gray-800 text-6xl mt-4 "><span class="italic text-violet-400 thin-underline underline-offset-6">Registra</span> tus viajes, <span class="italic text-violet-400 thin-underline underline-offset-6">planifica</span> tus aventuras y <span class="italic text-violet-400 thin-underline underline-offset-6">reflexiona</span> sobre cada paso</p>
    </div>

    <div class="my-8 p-6 bg-violet-50 rounded-md border border-violet-200 text-gray-700">
        <h1 class="text-2xl md:text-3xl font-bold text-violet-700 mb-3 text-center">
            ¡Qué bueno verte viajero/a, {{ Auth::user()->name ?? 'Viajero/a' }}!
        </h1>
        <p class="text-base md:text-lg mb-2 text-center md:text-left">
            Este es tu espacio personal en Diarios Nómadas. Revisa la actividad de tus amigos, actualiza tu perfil y descubre otros viajeros.
        </p>
        <p class="text-base md:text-lg mt-3 font-medium text-gray-600 text-center md:text-left">
            Cuando quieras sumergirte en tus propias historias, planificar tu próxima aventura, crear, ver o editar tus diarios el botón <strong class="text-violet-700">"Accede a tus Diarios de Viajes"</strong> te llevará allí.
        </p>
    </div>

    <div class="text-center mt-6">
        <a href="{{ route('diarios.index') }}" class="inline-flex items-center justify-center text-lg text-white bg-violet-600 hover:bg-violet-700 py-2 px-6 rounded-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <span>Accede a tus Diarios de Viajes</span>
            <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" class="feather feather-arrow-right"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"></path></svg>
        </a>
    </div>


    <div class="text-center">
        <p class="text-gray-800 text-6xl"><span class="italic text-violet-400 thin-underline underline-offset-6">Descubre</span> los últimos <span class="italic text-violet-400 thin-underline underline-offset-6">diarios</span> publicados por <span class="italic text-violet-400 thin-underline underline-offset-6">la comunidad</span></p>
    </div>
    <div class="flex overflow-x-auto mt-12 space-x-4 pb-4 w-full md:w-auto">
        @forelse ($diariosPublicosTodos as $diario)
            <div class="w-[300px] h-[400px] flex-shrink-0 bg-white rounded-sm shadow-lg overflow-hidden">
                <a href="{{ route('diarios.show', $diario->slug) }}" class="block h-full">
                    @if($diario->imagenPrincipal)
                        <div class="group relative w-full h-full overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                            <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}" alt="Imagen Principal" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105 rounded-xl">

                            <!-- Información del autor-->
                            <div class="absolute top-2 right-2 flex items-center space-x-2 bg-orange-200 bg-opacity-50 text-gray rounded-full px-3 py-1 shadow-md">
                                <img src="{{ $diario->user->profile_image_url }}" alt="Foto de {{$diario->user->name }}" class="w-8 h-8 rounded-full border-2 border-purple-600">
                                <span class="text-sm font-semibold">{{ $diario->user->name }}</span>
                            </div>

                            <!-- Información superpuesta -->
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-4 text-gray-200 space-y-1">
                                <h2 class="text-md font-semibold uppercase">{{ $diario->titulo }}</h2>

                                <div class="flex items-center text-gray text-sm space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <h1 class="text-lg font-semibold">{{ $diario->destinos->pluck('nombre_destino')->implode(', ') }}</h1>
                                </div>

                                <div class="flex items-center text-gray text-sm space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                    <p class="text-sm">{{ $diario->fecha_inicio }} / {{ $diario->fecha_final }}</p>
                                </div>

                            </div>
                        </div>
                    @endif
                </a>
            </div>
        @empty
            <p class="text-gray-500">No hay diarios recientes publicados</p>
        @endforelse
    </div>

    <div class="max-w-7xl mx-auto p-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Información del usuario -->
            <div class="flex-1 bg-white border border-gray-300 rounded-sm p-6">
                <div class="flex items-center space-x-6">
                    <!-- Foto del usuario: Al pedir $user->profile_image_url, Laravel ejecuta el método getProfileImageUrlAttribute() y pone la URL resultante (ya sea la de storage o la de por defecto) en el atributo src. -->
                    <img src="{{ Auth::user()->profile_image_url }}" alt="Foto de perfil" class="w-24 h-24 rounded-sm border-2 border-violet-500">

                    <div class="flex flex-col justify-center">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-violet-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <h2 class="text-2xl font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                </div>

                <!-- Bio del usuario -->
                <div class="mt-4 text-gray-700 text-sm">
                    <p>{{ Auth::user()->bio }}</p>
                </div>

                <!-- Botones -->
                <div class="mt-6 text-center">

                    <a href="{{ route('perfil.show', auth()->user()) }}" class="inline-flex items-center justify-center px-3 py-1 font-bold border border-gray-300 text-gray-700 bg-pink-200 rounded-sm hover:bg-pink-800 hover:text-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-pink-500">
                        Ver mi Perfil
                    </a>
                    <a href="{{ route('perfil.edit') }}" class="inline-flex items-center justify-center px-3 py-1 font-bold border border-gray-300 text-gray-700 bg-violet-200 rounded-sm hover:bg-violet-800 hover:text-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-violet-500">
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
                                <li class="flex items-center justify-between bg-violet-50 p-3 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $solicitud->user->profile_image_url }}" alt="Foto de {{ $solicitud->user->name }}" class="w-10 h-10 rounded-full border-2 border-violet-500">
                                        <span class="font-medium">{{ $solicitud->user->name }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <!-- Botón aceptar -->
                                        <form action="{{ route('solicitudes.aceptar', $solicitud) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="relative group p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-green-400 transition-opacity duration-200">
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
                                                    class="size-6 text-red-400 transition-opacity duration-200">
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
                            <!-- Imagen y nombre -->
                             <a href="{{ route('perfil.show', $amigo) }}" class="flex items-center space-x-4 group">
                                <img src="{{ $amigo->profile_image_url }}" alt="Foto de {{ $amigo->name }}" class="w-12 h-12 rounded-full border-2 border-violet-500">
                                <strong class="text-lg text-gray-800 group-hover:text-violet-600 group-hover:underline">
                                    {{ $amigo->name }}
                                </strong>
                            </a>

                            <!-- Botón eliminar -->
                            <form action="{{ route('amigos.eliminar', $amigo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar a este amigo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="relative group p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-6 text-red-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="my-9">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-violet-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>

                <span>Lista de Usuarios</span>
            </h2>
            <ul class="space-y-4">
                @foreach ($usuarios as $usuario)
                    <li class="bg-white p-4 rounded-lg border border-gray-300 rounded-sm flex flex-col md:flex-row justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $usuario->profile_image_url }}" alt="Foto de {{ $usuario->name }}" class="w-12 h-12 rounded-full border-2 border-violet-500">
                            <div>
                                <strong class="text-lg">{{ $usuario->name }}</strong><br>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="mt-3 md:mt-0">
                            @if ($amigos->contains($usuario))
                                <div class="flex items-center text-green-600 text-sm space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                    </svg>
                                    <pre>Ya sois amigos</pre>
                                </div>
                            @elseif (Auth::user()->tieneSolicitudPendienteCon($usuario))
                                <pre class="text-yellow-600 text-sm">Solicitud Enviada</pre>
                            @else
                                <form action="{{ route('solicitudes.enviar', $usuario) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center px-3 py-1 border border-gray-300 text-gray-700 bg-violet-200 rounded-full hover:bg-violet-400 hover:text-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-violet-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mx-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>
                                        Enviar Solicitud
                                    </button>
                                </form>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

    <div class="w-full flex flex-col items-center">
        <div class="text-center">
            <p class="text-gray-800 text-6xl"><span class="italic text-violet-400 thin-underline underline-offset-6">Descubre</span> los últimos <span class="italic text-violet-400 thin-underline underline-offset-6">diarios</span> publicados por tus  <span class="italic text-violet-400 thin-underline underline-offset-6">amigos</span></p>
        </div>

        <div class="flex overflow-x-auto mt-9 space-x-4 pb-4 w-full md:w-auto">
            @forelse ($diariosAmigos as $diario)
                <div class="w-[300px] h-[400px] flex-shrink-0 bg-white rounded-xl shadow-lg overflow-hidden">
                    <a href="{{ route('diarios.show', $diario->slug) }}" class="block h-full">
                        @if($diario->imagenPrincipal)
                            <div class="group relative w-full h-full overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                                <img src="{{ $diario->user->profile_image_url }}" alt="Imagen Principal" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105 rounded-xl">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-4 text-white">
                                    <h1 class="text-lg font-semibold">{{ $diario->destino }}</h1>
                                    <h2 class="text-lg font-semibold">{{ $diario->titulo }}</h2>
                                    <p class="text-sm">{{ $diario->fecha_inicio->format('Y-m-d') }} / {{ $diario->fecha_final->format('Y-m-d') }}</p>
                                    <div class="flex items-center space-x-2 mt-2">
                                        <img src="{{ asset('storage/' . $diario->user->profile_image) }}" alt="Foto de {{ $diario->user->name }}" class="w-8 h-8 rounded-full border-2 border-white">
                                        <span class="text-sm">{{ $diario->user->name }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </a>
                </div>
            @empty
                <p class="text-gray-500">No se han publicado diarios recientes.</p>
            @endforelse
        </div>
    </div>

</section>
@endsection
