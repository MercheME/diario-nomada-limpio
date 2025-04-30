@extends('layouts.app')

@section('content')

    <section class=" flex flex-col gap-10 w-full justify-center">
        <h1 class='text-4xl text-center mt-10 uppercase font-bold  text-gray-700'>Diarios </h1>

        <a href="{{ route('diarios.create') }}">Crear nuevo diario</a>


        <ul>
            @forelse ($diarios as $diario)
                <li>
                    <a href="{{ route('diarios.show', $diario->slug) }}">{{ $diario->titulo }}</a>
                </li>
            @empty
                <p>No hay diarios disponibles.</p>
            @endforelse
        </ul>

    </section>

@endsection
