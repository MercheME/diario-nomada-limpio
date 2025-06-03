@extends('layouts.app')

@section('content')
<div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div>
            <h2 class="text-center text-3xl italic tracking-tight text-gray-900">Editar Perfil</h2>
        </div>

        {{-- Bloque para mostrar el mensaje de éxito después de actualizar --}}
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        {{-- El formulario apunta a la ruta de actualización y usa el método PUT --}}
        <form method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                <div class="">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <div class="mt-2">
                        {{-- El valor es el dato del usuario, con fallback a old() por si falla la validación --}}
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-violet-100">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-violet-100">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="">
                    <label for="bio" class="block text-sm font-medium text-gray-700">Biografía</label>
                    <div class="mt-2">
                        <textarea name="bio" id="bio" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-violet-100">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="">
                    <label for="profile_image" class="block text-sm font-medium text-gray-700">Imagen de Perfil</label>
                    <div class="mt-2 flex items-center space-x-4">
                        {{-- Mostramos la imagen actual --}}
                        <img src="{{ $user->profile_image }}" alt="Imagen actual" class="h-16 w-16 rounded-full object-cover">
                        {{-- Botón para subir una nueva --}}
                        <input type="file" name="profile_image" id="profile_image" accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-100 file:text-violet-700 hover:file:bg-violet-200 cursor-pointer">
                    </div>
                     @error('profile_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sección opcional para cambiar la contraseña --}}
                <div class="border-t border-gray-200 pt-6">
                    <p class="text-sm text-gray-600 mb-4">Rellena los siguientes campos solo si deseas cambiar tu contraseña.</p>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                        <div class="mt-2">
                            <input type="password" name="password" id="password"
                                   class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-violet-100">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Repite la Nueva Contraseña</label>
                        <div class="mt-2">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-violet-100">
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 flex items-center justify-end gap-x-6">
                <a href="{{ route('home', auth()->user()) }}" class="text-sm font-semibold leading-6 text-gray-900">Cancelar</a>
                <input type="submit" value="Guardar Cambios" class="cursor-pointer inline-flex items-center justify-center px-4 py-2 font-bold border border-transparent text-white bg-violet-600 rounded-xl hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500" />
            </div>
        </form>
    </div>
</div>
@endsection
