@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4">

    <div class="max-w-2xl mx-auto mb-12">
       <p class="text-gray-800 text-6xl mt-4">
            <span class="italic text-violet-400 thin-underline underline-offset-6">Buscador</span> de Diarios
        </p>
    </div>

    <form action="{{ route('diarios.search') }}" method="GET" class="relative">
        <label for="search-page" class="sr-only">Buscar</label>
        <input type="text" name="q" id="search-page"
            class="block w-full pl-5 pr-12 py-3 border border-gray-300 rounded-sm shadow-md focus:ring-2 focus:ring-violet-500 focus:border-violet-500 text-lg"
            placeholder="Ej: Patagonia, Japón, comida callejera..."
            value="{{ request('query', '') }}"
            required minlength="3">
        <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-4" aria-label="Buscar">
            <svg class="h-6 w-6 text-violet-600 hover:text-violet-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
    </form>

    @isset($diarios)
        <div class="border-t border-gray-200 pt-8">
            @if ($diarios->count() > 0)
                <p class="text-sm text-gray-500 mb-6">Se encontraron <strong class="font-medium">{{ $diarios->total() }}</strong> {{ Str::plural('resultado', $diarios->total()) }} para tu búsqueda "<strong class="font-medium">{{ $query }}</strong>".</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($diarios as $diario)

                        <div class="flex-shrink-0 bg-white rounded-xl shadow-lg overflow-hidden h-[500px] w-full">
                        <a href="{{ route('diarios.show', $diario->slug) }}" class="block h-full">
                            @if($diario->imagenPrincipal)
                                <div class="group relative w-full h-full overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">

                                    @if (Request::routeIs('diariosPublicados'))
                                        <div class="absolute top-2 right-2 flex items-center space-x-2 bg-orange-300 bg-opacity-50 text-gray rounded-full px-3 py-1 shadow-md">
                                            <img src="{{ asset('storage/' . $diario->user->profile_image) }}" alt="Foto d{{$diario->user->name }}" class="w-8 h-8 rounded-full border-2 border-white">
                                            <span class="text-sm font-semibold">{{ $diario->user->name }}</span>
                                        </div>
                                    @endif

                                    <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}" alt="Imagen Principal" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105 rounded-xl">

                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-4 text-gray-200 space-y-1">
                                        <h2 class="text-4xl border-b border-gray-400 pb-2">{{ $diario->titulo }}</h2>

                                        <div class="flex items-center text-md space-x-1">
                                            <span class="font-mono">
                                                {{ \Carbon\Carbon::parse($diario->fecha_inicio)->isoFormat('D [de] MMMM, YYYY') }} / {{ \Carbon\Carbon::parse($diario->fecha_final)->isoFormat('D [de] MMMM, YYYY') }}
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
                                                        $partesUbicacion = array_map('trim', explode(',', $primerDestino->ubicacion));
                                                        $pais = end($partesUbicacion);
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


                    <div class="mt-10">
                        {{-- para que los parametros de busqueda se mantengan al cambiar de página --}}
                        {{ $diarios->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-16 px-6 bg-white rounded-lg shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No se encontraron diarios</h3>
                    <p class="mt-1 text-sm text-gray-500">No hemos encontrado ningún diario que coincida con tu búsqueda de "<strong class="font-medium">{{ $query }}</strong>". Inténtalo con otras palabras.</p>
                </div>
            @endif
        </div>
        @endisset

@endsection
