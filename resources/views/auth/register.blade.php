@extends('layouts.app')
@section('content')
<div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
      <div>
        <h2 class="text-center text-6xl italic tracking-tight text-gray-900">Regístrate en <span class="italic text-violet-400 thin-underline underline-offset-6">Diarios Nómadas</span></h2>
      </div>
      <form method="POST" action="{{ route("store") }}" enctype="multipart/form-data">
        @csrf

        <div class="space-y-12">
          <div class=" pb-4">
            <div class="flex flex-col gap-3">

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <div class="mt-2">
                        <input type="text" name="name" id="name" value="{{ old('name')}}" required
                            class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-violet-100">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" value="{{ old('email')}}" required
                            class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-violet-100">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div class="mt-2">
                        <input type="password" name="password" id="password" required
                            class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-violet-100">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Repite la Contraseña</label>
                    <div class="mt-2">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-violet-100">
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="bio" class="block text-sm font-medium text-gray-700">Biografía</label>
                    <div class="mt-2">
                        <textarea name="bio" id="bio" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-violet-500 focus:bg-violet-100">{{ old('bio') }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="profile_image" class="block text-sm font-medium text-gray-700">Imagen de Perfil</label>
                    <div class="mt-2">
                        <input type="file" name="profile_image" id="profile_image" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-100 file:text-violet-700 hover:file:bg-violet-200 cursor-pointer">
                        @error('profile_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
          <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancelar</a>
          <input type="submit" value="Enviar Registro" class="inline-flex items-center justify-center px-3 py-1 font-bold border border-gray-300 text-gray-700 bg-violet-200 rounded-sm hover:bg-violet-800 hover:text-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-violet-500" />
        </div>
      </form>
    </div>
  </div>
@endsection
