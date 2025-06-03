<aside class="w-64 bg-white shadow-md p-4">
    <h2 class="text-xl font-bold mb-4">Menú</h2>
    <ul class="space-y-2">

        <!-- Sección Diarios -->
        <li class="font-semibold text-gray-600">Diarios de viaje</li>
        <ul class="ml-4 space-y-1">
            <li>
                <a href="{{ route('diarios.create') }}"
                   class="block py-1 hover:text-pink-500 {{ Request::routeIs('diarios.create') ? 'text-violet-700 font-bold underline' : 'text-violet-500' }}">
                    Crear Diario
                </a>
            </li>
            <li>
                <a href="{{ route('diarios.index') }}"
                   class="block py-1 hover:text-pink-500 {{ Request::routeIs('diarios.index')? 'text-violet-700 font-bold underline' : 'text-violet-500' }}">
                    Mis Diarios
                </a>
            </li>
            <li>
                <a href="{{ route('diariosPublicados') }}"
                   class="block py-1 hover:text-pink-500 {{ Request::routeIs('diariosPublicados') ? 'text-violet-700 font-bold underline' : 'text-violet-500' }}">
                    Diarios Publicados
                </a>
            </li>
            <li>
                <a href="{{ route('diarios.favoritos.index') }}"
                    class="block py-1 hover:text-pink-500 {{ Request::routeIs('diarios.favoritos.index') ? 'text-violet-700 font-bold underline' : 'text-violet-500' }}">
                    Mis Favoritos
                </a>
            </li>

            {{-- <li>
                <a href="{{ route('diarios.index') }}"
                   class="{{ Request::is('diarios*') && !Request::routeIs('diarios.create') ? 'text-blue-700 font-bold underline' : 'text-blue-500' }}">
                    Calendario
                </a>
            </li> --}}
        </ul>

        <!-- Sección Proyectos Locales (Comunidades) -->
        <li class="font-semibold text-gray-600 mt-4">Proyectos Locales</li>
        <ul class="ml-4 space-y-1">
            <li>
                {{-- <a href="{{ route('proyectos.mapa') }}"
                   class="{{ Request::routeIs('proyectos.mapa') ? 'text-blue-700 font-bold underline' : 'text-blue-500' }}">
                    Mapa
                </a> --}}
            </li>
            <li>
                <a href="{{ route('proyectos.index') }}"
                   class="{{ Request::routeIs('proyectos.index') ? 'text-blue-700 font-bold underline' : 'text-blue-500' }}">
                    Proyectos Locales
                </a>
            </li>
        </ul>
        <li class="font-semibold text-gray-600 mt-4">Opciones</li>
        <ul class="ml-4 space-y-1">
            <li>
                <a href="{{ route('proyectos.index') }}"
                   class="block py-1 hover:text-pink-500 {{ Request::routeIs('proyectos.mapa') ? 'text-violet-700 font-bold underline' : 'text-violet-500'}}">
                    Calendario
                </a>
            </li>
            <li>
                <a href="{{ route('diarios.mapa') }}"
                   class="block py-1 hover:text-pink-500 {{ Request::routeIs('diarios.mapa') ? 'text-violet-700 font-bold underline' : 'text-violet-500' }}">
                    Mapas
                </a>
            </li>
        </ul>
    </ul>
</aside>
