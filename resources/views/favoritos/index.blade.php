@extends('layouts.app')

@section('content')
<div class="flex-grow p-6">
    <div class="text-center text-gray-700">
        <p class="text-gray-800 text-6xl mt-4">
            Tus
            <span class="italic text-violet-400 thin-underline underline-offset-6">Diarios</span> de viaje
            <span class="italic text-violet-400 thin-underline underline-offset-6">Favoritos</span>
        </p>
    </div>

    <main class="mt-14">
        @if ($diariosFavoritos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach ($diariosFavoritos as $diario)
                    <div class="flex-shrink-0 bg-white rounded-xl shadow-lg overflow-hidden h-[500px] w-full">
                        <a href="{{ route('diarios.show', $diario->slug) }}" class="block h-full">
                            @if($diario->imagenPrincipal)
                                <div class="group relative w-full h-full overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">

                                    <div class="absolute top-2 right-2 flex items-center space-x-2 bg-orange-300 bg-opacity-50 text-gray rounded-full px-3 py-1 shadow-md">
                                         <img src="{{ asset('storage/' . $diario->user->profile_image) }}" alt="Foto d{{$diario->user->name }}" class="w-8 h-8 rounded-full border-2 border-white">
                                        <span class="text-sm font-semibold">{{ $diario->user->name }}</span>
                                    </div>

                                    <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}" alt="Imagen Principal" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105 rounded-xl">

                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-4 text-gray-200 space-y-1">
                                        <h2 class="text-4xl border-b border-gray-400 pb-2">{{ $diario->titulo }}</h2>

                                        <div class="flex items-center text-md space-x-1">
                                            <span class="font-mono">
                                                {{ \Carbon\Carbon::parse($diario->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($diario->fecha_final)->format('d/m/Y') }}
                                            </span>
                                        </div>

                                        <div class="flex items-center text-gray text-md space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>

                                            @php
                                                $ciudadPais = 'Sin destinos';

                                                if ($diario->destinos->isNotEmpty()) {
                                                    $primerDestino = $diario->destinos->first();

                                                    if ($primerDestino && isset($primerDestino->ubicacion)) {
                                                        // Divide la ubicación por comas y quita los espacios
                                                        $partesUbicacion = array_map('trim', explode(',', $primerDestino->ubicacion));

                                                        $pais = end($partesUbicacion);

                                                        //la ciudad es la cuarta parte empezando por el final,o la primera si no hay suficientes partes
                                                        $ciudad = (count($partesUbicacion) >= 4) ? $partesUbicacion[count($partesUbicacion) - 4] : $partesUbicacion[0];

                                                        $ciudadPais = $ciudad . ', ' . $pais;
                                                    }
                                                }
                                            @endphp

                                            {{ $ciudadPais }}

                                        </div>

                                    </div>
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500">
                                    <span>Sin imagen</span>
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-10">
                {{ $diariosFavoritos->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <p class="text-xl text-gray-600">Aún no has añadido ningún diario a tus favoritos.</p>
                <p class="mt-2 text-gray-500">Explora los diarios y pulsa el corazón en los que más te inspiren.</p>
            </div>
        @endif
    </main>
</div>
@endsection
