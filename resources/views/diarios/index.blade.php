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

                    <!-- Overlay con texto -->
                    <div class="absolute inset-0 bg-opacity-40 flex flex-col justify-end p-4 text-white">
                        <h1 class="text-lg font-semibold">{{ $diario->destino }}</h1>
                        <h2 class="text-base font-semibold">{{ $diario->titulo }}</h2>
                        <p class="text-sm">{{ $diario->fecha_inicio }} - {{ $diario->fecha_final }}</p>
                        <p class="text-xs text-gray-300">Publicado por: {{ $diario->user->name }}</p>
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
