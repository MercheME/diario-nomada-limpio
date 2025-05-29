@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-playfair font-bold italic text-gray-800 mb-8 text-center">Mis Diarios Favoritos</h1>

    @if ($diariosFavoritos->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($diariosFavoritos as $diario)
                {{-- Aquí puedes reutilizar el componente de tarjeta de diario que ya tengas
                     o crear uno similar. Ejemplo básico: --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group">
                    <a href="{{ route('diarios.show', $diario->slug) }}" class="block">
                        @if($diario->imagenPrincipal)
                            <div class="w-full h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}"
                                     alt="Imagen de {{ $diario->titulo }}"
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">Sin imagen</span>
                            </div>
                        @endif
                        <div class="p-4">
                            <h2 class="text-xl font-semibold font-playfair text-violet-700 mb-1 truncate group-hover:text-violet-800">{{ $diario->titulo }}</h2>
                            <p class="text-sm text-gray-600 mb-2">Por: {{ $diario->user->name ?? 'Desconocido' }}</p>
                            <p class="text-xs text-gray-500">Añadido a favoritos: {{ $diario->pivot->created_at->isoFormat('DD MMM, YYYY') }}</p>
                            {{-- Puedes añadir más información o el botón de quitar favorito aquí también --}}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $diariosFavoritos->links() }} {{-- Paginación --}}
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
</div>
@endsection
