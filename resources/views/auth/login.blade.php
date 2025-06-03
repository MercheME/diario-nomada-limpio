@extends('layouts.app')

@section('content')
<div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">

      <div class="relative w-60 h-40 mx-auto">
        <div id="loginAnim" class="absolute inset-x-0 top-1/3 w-full h-full"></div>
        <h2 class="text-center text-3xl italic tracking-tight text-gray-900">Inicia sesión en <span class="italic text-violet-400 thin-underline underline-offset-6">Diarios Nómadas</span></h2>
      </div>

      <form class="flex-[0.5]" method="POST" action="/login">
        @csrf
        <div class="space-y-12">
          <div class="border-b border-gray-900/10 pb-12">
            <div class="flex flex-col gap-3">

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-blue-100">
                        @error('email')
                            <code class="mt-1 font-cascadia text-xs text-red-400">
                                {{ $message }}
                            </code>
                        @enderror
                    </div>
                </div>

                <div class="mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-2">
                        <input type="password" name="password" id="password" required
                            class="w-full px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500 focus:bg-blue-100">
                        @error('password')
                            <code class="mt-1 font-cascadia text-xs text-red-400">
                                {{ $message }}
                            </code>
                        @enderror
                    </div>
                </div>

            </div>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <p class="text-sm text-gray-500">¿Aún no tienes cuenta? ¡Crea una cuenta y comienza ahora!</p>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-3 py-1 font-bold border border-gray-300 text-gray-700 bg-violet-200 rounded-sm hover:bg-violet-800 hover:text-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-violet-500">Registro </a>

            <input type="submit" value="Log In"  class="inline-flex items-center justify-center px-3 py-1 font-bold border border-gray-300 text-gray-50 bg-violet-500 rounded-sm hover:bg-violet-800 hover:text-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-violet-500"  />
        </div>

      </form>
    </div>
  </div>

  <script src="https://unpkg.com/lottie-web@5.7.4/build/player/lottie.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        lottie.loadAnimation({
        container: document.getElementById('loginAnim'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '{{ asset('recursos/login-animation2.json') }}'
        });
    });
    </script>

@endsection

