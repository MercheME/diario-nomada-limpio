<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Diario Nómada</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Bubbles&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-gray-400 text-white">
        <nav class="flex items-center justify-between p-4">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-900">☠️ Instagram</a>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Cerrar sesión -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 font-bold text-white bg-gray-900 rounded-xl focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-pink-500">
                        Cerrar sesión
                    </button>
                </form>

                <!-- Buscador -->
                <form method="GET" action="{{ route('diarios.index') }}" class="flex items-center space-x-2">
                    <input type="text" name="query" placeholder="Buscar diario..." class="px-3 py-2 rounded-md text-black">
                    <div class="relative inline-flex group">
                        <div class="absolute transition-all duration-1000 opacity-70 -inset-px bg-gradient-to-r from-[#44BCFF] via-[#FF44EC] to-[#FF675E] rounded-xl blur-lg group-hover:opacity-100 group-hover:-inset-1 group-hover:duration-200 animate-tilt"></div>
                        <button type="submit" class="relative inline-flex items-center justify-center px-4 py-2 font-bold text-white transition-all duration-200 bg-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">🔎 Buscar</button>
                    </div>
                </form>
            </div>
        </nav>
    </header>

    <!-- CONTENIDO CON/SIN SIDEBAR -->
    <div class="flex flex-1">

        {{-- Mostrar sidebar solo en diarios o proyectos (comunidades) --}}
        @if (Request::is('diarios*') || Request::is('proyectos*'))
            @include('partials.sidebar')
        @endif

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</body>
</html>
