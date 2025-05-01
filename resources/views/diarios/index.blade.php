@extends('layouts.app')

@section('content')

    <section class=" flex flex-col gap-10 w-full justify-center">
        <h1 class="text-4xl text-center mt-10 uppercase font-bold text-gray-700">
            @if(Request::routeIs('diarios.index'))
                Mis Diarios
            @elseif(Request::routeIs('diariosPublicados'))
                Diarios Publicados
            @endif
        </h1>


        <ul>
            @forelse ($diarios as $diario)
                <li>
                    <a href="{{ route('diarios.show', $diario->slug) }}" class="text-blue-600 hover:underline">
                        {{ $diario->titulo }}
                    </a>
                    <span class="text-sm text-gray-500">Publicado por: {{ $diario->user->name }}</span>
                </li>
            @empty
                <p>No hay diarios disponibles.</p>
            @endforelse
        </ul>

        <div class="mt-6">
            {{ $diarios->links() }}  <!-- Esto generará los links para la paginación -->
        </div>

    </section>

@endsection
