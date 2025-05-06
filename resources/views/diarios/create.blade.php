
@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Crear Diario</h1>

    <form action="{{ route('diarios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Título --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="titulo" class="block font-medium">Título</label>
                <input type="text" name="titulo" class="w-full border p-2 rounded" value="{{ old('titulo') }}">
                @error('titulo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Imagen principal --}}
        <div>
            <label for="imagen_principal" class="block font-medium">Imagen principal</label>
            <input type="file" name="imagen_principal" class="block w-full text-sm text-gray-500">
            @error('imagen_principal') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Botón --}}
        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                Guardar Diario
            </button>
        </div>
    </form>

    {{-- @if (session('success'))
        <div class="mt-4 text-green-600 font-medium">
            {{ session('success') }}
        </div>
    @endif --}}
</section>
@endsection
