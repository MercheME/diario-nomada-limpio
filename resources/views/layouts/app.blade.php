<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Diario Nómada</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cascadia+Code:ital,wght@0,200..700;1,200..700&family=Playfair:ital,opsz,wght@0,5..1200,300..900;1,5..1200,300..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="min-h-screen bg-orange-50 flex flex-col">

    <!-- HEADER -->
    <header class="bg-stone-100 text-white">
        <nav class="flex items-center bg-gray-200 justify-between p-4 border-b border-gray-300">

            <div class="flex items-center">
                <a href="{{ route('home') }}"
                class="flex items-center text-2xl mx-4 font-playfair font-semibold italic
                        text-transparent bg-clip-text
                        bg-gradient-to-r from-amber-400 via-pink-400 to-violet-600
                        hover:from-amber-500 hover:via-pink-500 hover:to-violet-700
                        transition-all duration-300 ease-in-out
                        group
                        ">
                    <svg class="w-8 h-10 mr-2
                                fill-current text-fuchsia-600 group-hover:text-amber-500 transition-colors duration-300 ease-in-out"
                        version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 337.602 337.602" xml:space="preserve">
                        <g>
                            <path style="fill:#808285;" d="M125.57,185.381c0-23.88,19.36-43.23,43.23-43.23s43.23,19.35,43.23,43.23
                                        c0,23.87-19.36,43.23-43.23,43.23S125.57,209.251,125.57,185.381z"/>
                            <path style="fill:#808285;" d="M332.6,136.711v138.17c0,5.52-4.48,10-10,10H15c-5.52,0-10-4.48-10-10v-138.17h106.27
                                        c-11.12,13.13-17.83,30.12-17.83,48.67c0,41.62,33.74,75.36,75.36,75.36s75.36-33.74,75.36-75.36c0-18.55-6.71-35.54-17.83-48.67
                                        L332.6,136.711L332.6,136.711z"/>
                            <path style="fill:#A7A9AC;" d="M332.6,99.281v37.43H226.33c-30.124-35.595-84.949-35.579-115.06,0H5v-37.43c0-5.52,4.48-10,10-10
                                        h78.42c4.51,0,8.46-3.01,9.65-7.36l5.97-21.84c1.19-4.35,5.14-7.36,9.65-7.36h100.22c4.51,0,8.46-3.01,9.65,7.36l5.97,21.84
                                        c1.19,4.35,5.14-7.36,9.65,7.36h78.42C328.12,89.281,332.6,93.761,332.6,99.281z"/>
                            <path style="fill:#808285;" d="M168.8,110.021c-23.07,0-43.71,10.36-57.53,26.69c-11.12,13.13-17.83,30.12-17.83,48.67
                                        c0,41.62,33.74,75.36,75.36,75.36s75.36-33.74,75.36-75.36C244.16,143.852,210.498,110.021,168.8,110.021z M168.8,228.611
                                        c-23.87,0-43.23-19.36-43.23-43.23c0-23.88,19.36-43.23,43.23-43.23s43.23,19.35,43.23,43.23
                                        C212.03,209.251,192.67,228.611,168.8,228.611z"/>
                            <path style="fill:#808285;" d="M212.03,185.381c0,23.87-19.36,43.23-43.23,43.23s-43.23-19.36-43.23-43.23
                                        c0-23.88,19.36-43.23,43.23-43.23S212.03,161.501,212.03,185.381z"/>
                            <path style="fill:#A7A9AC;" d="M212.03,185.381c0,23.87-19.36,43.23-43.23,43.23s-43.23-19.36-43.23-43.23
                                        c0-23.88,19.36-43.23,43.23-43.23S212.03,161.501,212.03,185.381z"/>
                            <path style="fill:#A7A9AC;" d="M279.073,284.878h43.528c5.523,0,10-4.477,10-10V231.35h-33.528c-11.046,0-20,8.954-20,20V284.878z"
                                />
                            <g>
                                <rect x="32.466" y="69.283" style="fill:#808285;" width="43.333" height="20"/>
                                <g>
                                    <path style="fill:#393654;" d="M168.8,233.611c26.595,0,48.23-21.636,48.23-48.23s-21.636-48.23-48.23-48.23
                                                s-48.231,21.636-48.231,48.23S142.205,233.611,168.8,233.611z M168.8,147.151c21.08,0,38.23,17.15,38.23,38.23
                                                s-17.15,38.23-38.23,38.23s-38.23-17.15-38.23-38.23S147.72,147.151,168.8,147.151z"/>
                                    <path style="fill:#393654;" d="M337.6,99.281c0-8.271-6.729-15-15-15h-78.42c-2.249,0-4.234-1.513-4.826-3.679l-5.971-21.84
                                                c-1.777-6.501-7.729-11.041-14.473-11.041H118.689c-6.743,0-12.695,4.54-14.473,11.041l-5.971,21.839
                                                c-0.592,2.167-2.577,3.679-4.826,3.679H80.8V69.283c0-2.761-2.238-5-5-5H32.467c-2.762,0-5,2.239-5,5v14.998H15
                                                c-8.271,0-15,6.729-15,15c0,4.62,0,171.05,0,175.6c0,8.271,6.728,15,15,15h307.6c8.273,0,15.002-6.733,15.002-15.002
                                                C337.602,268.731,337.6,107.719,337.6,99.281z M327.6,274.881c0,2.759-2.244,4.998-4.998,4.998h-38.528V251.35
                                                c0-8.271,6.729-15,15-15H327.6V274.881z M37.467,74.283H70.8v9.998H37.467V74.283z M10,99.281c0-2.757,2.243-5,5-5h17.443
                                                c0.008,0,0.016,0.002,0.024,0.002H75.8c0.008,0,0.016-0.002,0.024-0.002H93.42c6.743,0,12.694-4.54,14.473-11.042l5.971-21.839
                                                c0.592-2.166,2.576-3.679,4.826-3.679h100.22c2.25,0,4.234,1.513,4.826,3.678l5.971,21.84
                                                c1.778,6.501,7.729,11.041,14.473,11.041h78.42c2.757,0,5,2.243,5,5v32.43h-98.995c-31.989-35.656-87.77-35.492-119.609,0H10
                                                V99.281z M168.8,115.021c39.056,0,70.36,31.712,70.36,70.36c0,38.797-31.564,70.36-70.36,70.36s-70.36-31.563-70.36-70.36
                                                C98.439,146.645,129.835,115.021,168.8,115.021z M10,274.881v-133.17h91.344c-8.499,13.149-12.904,28.468-12.904,43.67
                                                c0,44.311,36.05,80.36,80.36,80.36s80.36-36.049,80.36-80.36c0-14.821-4.184-30.178-12.904-43.67H327.6v84.64h-28.526
                                                c-13.785,0-25,11.215-25,25v28.53H15C12.243,279.881,10,277.637,10,274.881z"/>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <span>Diarios Nómadas</span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6  text-violet-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span class="text-gray-700 font-medium">
                        {{ Auth::user()->name }}
                    </span>
                @endauth
            </div>

                <!-- Cerrar sesión -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center px-3 py-1 font-bold border border-gray-300 text-gray-700 bg-violet-200 rounded-xl hover:bg-violet-800 hover:text-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-violet-500">
                        Cerrar sesión
                    </button>
                </form>

                <!-- Buscador -->
                {{-- <form method="GET" action="{{ route('diarios.index') }}" class="flex items-center space-x-2">
                    <input type="text" name="query" placeholder="Buscar diario..." class="px-3 py-2 rounded-md text-black">
                    <div class="relative inline-flex group">
                        <div class="absolute transition-all duration-1000 opacity-70 -inset-px bg-gradient-to-r from-[#44BCFF] via-[#FF44EC] to-[#FF675E] rounded-xl blur-lg group-hover:opacity-100 group-hover:-inset-1 group-hover:duration-200 animate-tilt"></div>
                        <button type="submit" class="relative inline-flex items-center justify-center px-4 py-2 font-bold text-white transition-all duration-200 bg-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">🔎 Buscar</button>
                    </div>
                </form> --}}
            </div>
        </nav>
    </header>

    <!-- CONTENIDO CON/SIN SIDEBAR -->
    <div class="flex flex-1 bg-gray-50">

        @if (Request::is('diarios*') || Request::is('mapa*') || Request::is('destinos*') || Request::is('mis-favoritos*') || Request::is('calendario*'))
            @include('partials.sidebar')
        @endif

        <!-- MAIN -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

    {{-- O tus scripts principales --}}
    @stack('scripts') {{-- Aquí se insertará el script de Flatpickr --}}
</body>
</html>
