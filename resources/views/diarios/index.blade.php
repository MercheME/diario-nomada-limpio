@extends('layouts.app')

@section('content')
<section class="flex flex-col gap-10 w-full justify-center">
    <h1 class="text-center mt-10 text-gray-700">
        @if(Request::routeIs('diarios.index'))
            <p class="text-gray-800 text-6xl mt-4">
                Tus
                <span class="italic text-violet-400 thin-underline underline-offset-6">Diarios</span> de viaje
            </p>
            <p class="text-gray-800 text-6xl mt-4">
                Haz un recorrido por las <span class="italic text-violet-400 thin-underline underline-offset-6">experiencias</span> que has escrito
            </p>
        @elseif(Request::routeIs('diariosPublicados'))
            <p class="text-gray-800 text-6xl mt-4">
                Todos los
                <span class="italic text-violet-400 thin-underline underline-offset-6">Diarios</span> de viaje </p><p class="text-gray-800 text-6xl mt-4"> publicados por la <span class="italic text-violet-400 thin-underline underline-offset-6">Comunidad</span></p>
            </p>
        @endif
    </h1>

    <main class="lg:col-span-2 mt-8 lg:mt-0">
        @if ($diarios->count() > 0)
            <div class="flex overflow-x-auto mt-12 space-x-4 pb-4 w-full md:w-auto">
                @foreach ($diarios as $diario)
                    <div class="w-[400px] h-[600px] flex-shrink-0 bg-white rounded-sm shadow-lg overflow-hidden">
                        <a href="{{ route('diarios.show', $diario->slug) }}" class="block h-full">
                            @if($diario->imagenPrincipal)
                                <div class="group relative w-full h-full overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">

                                    <div class="absolute top-2 right-2 flex items-center space-x-2 bg-orange-300 bg-opacity-50 text-gray rounded-full px-3 py-1 shadow-md">
                                         <img src="{{ asset('storage/' . $diario->user->profile_image) }}" alt="Foto d{{$diario->user->name }}" class="w-8 h-8 rounded-full border-2 border-white">
                                        <span class="text-sm font-semibold">{{ $diario->user->name }}</span>
                                    </div>

                                    <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}" alt="Imagen Principal" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105 rounded-xl">

                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-4 text-gray-200 space-y-1">
                                        <h2 class="text-md font-semibold uppercase">{{ $diario->titulo }}</h2>

                                        <div class="flex items-center text-gray text-sm space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                            <h1 class="text-sm font-semibold">
                                                {{ $diario->destinos->pluck('nombre_destino')->take(3)->implode(', ') ?: 'Sin destinos' }}
                                            </h1>
                                        </div>

                                        <div class="flex items-center text-sm space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75" />
                                            </svg>
                                            <span>
                                                {{ \Carbon\Carbon::parse($diario->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($diario->fecha_final)->format('d/m/Y') }}
                                            </span>
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
                {{ $diarios->links() }}
            </div>
        @else
            <div class="text-center bg-white rounded-sm shadow-sm p-12">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-16 w-16 text-gray-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-800">Los Diarios están por Escribirse</h3>
                    <p class="text-gray-500 mt-2">Aún no se han escrito aventuras. ¡Vuelve pronto!</p>
            </div>
        @endif
    </main>

    <div class="mt-6">
        {{ $diarios->links() }}
    </div>
</section>
@endsection
