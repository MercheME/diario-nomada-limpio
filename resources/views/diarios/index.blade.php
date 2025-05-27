@extends('layouts.app')

@section('content')
<section class="flex flex-col gap-10 w-full justify-center">
    <h1 class="text-4xl text-center mt-10 uppercase font-bold text-gray-700">
        @if(Request::routeIs('diarios.index'))
            Mis Diarios
        @elseif(Request::routeIs('diariosPublicados'))
            Diarios Publicados
        @endif
    </h1>

    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @forelse ($diarios as $diario)
            <a href="{{ route('diarios.show', $diario->slug) }}" class="relative rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 group">
                <div class="relative w-full h-150">
                    @if($diario->imagenPrincipal)
                        <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}"
                            alt="Imagen Principal"
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @endif

                    <!-- Información del autor-->
                    <div class="absolute top-2 right-2 flex items-center space-x-2 bg-orange-300 bg-opacity-50 text-gray rounded-full px-3 py-1 shadow-md">
                        <img src="{{ asset('storage/' . $diario->user->profile_image) }}" alt="Foto d{{$diario->user->name }}" class="w-8 h-8 rounded-full border-2 border-white">
                        <span class="text-sm font-semibold">{{ $diario->user->name }}</span>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-4 text-gray-200 space-y-1">
                        <h2 class="text-md font-semibold uppercase">{{ $diario->titulo }}</h2>

                        <div class="flex items-center text-gray text-sm space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <h1 class="text-lg font-semibold">{{ $diario->destinos->pluck('nombre_destino')->implode(', ')}}</h1>
                        </div>

                        <div class="flex items-center text-gray text-sm space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                            <p class="text-sm">{{ $diario->fecha_inicio }} / {{ $diario->fecha_final }}</p>
                        </div>

                    </div>
                </div>
            </a>
        @empty
            <p>No hay diarios disponibles.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $diarios->links() }}
    </div>
</section>
@endsection
