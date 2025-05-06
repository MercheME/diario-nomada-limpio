@extends('layouts.app')

@section('content')

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @if($diario->imagenPrincipal)
            <div class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-w-4 aspect-h-3 rounded-xl overflow-hidden">
                    <h2 class="absolute top-2 left-2 bg-black bg-opacity-50 text-white px-2 py-1 text-sm rounded">Imagen Principal</h2>
                    <img src="{{ asset('storage/' . $diario->imagenPrincipal->url_imagen) }}"
                    alt="Imagen Principal"
                    class="object-contain w-full h-full transition-transform duration-500 group-hover:scale-105">
                    <!-- Overlay de texto -->
                    <div class="absolute inset-0 bg-opacity-40 flex flex-col justify-end p-4 text-white">
                        <h2 class="text-lg font-semibold">{{ $diario->titulo }}</h2>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <h1 class="font-playfair italic text-4xl">Este es un título con Playfair</h1>

    <p class="font-raleway italic text-lg">
        Este es un párrafo con Raleway.
    </p>

    <code class="font-cascadia">
        Código usando Cascadia Code.
    </code>

    <div class="min-h-screen bg-tierra-claro p-8 font-sans text-tierra-oscuro">
        <h1 class="text-4xl font-serif mb-4">Mi Diario de Viaje</h1>

        <p class="mb-6 text-lg">
            Bienvenido a tu espacio personal para planificar y recordar tus aventuras.
        </p>

        <div class="bg-orange-100 p-6 rounded-lg shadow-lg text-white mb-8">
            <h2 class="text-2xl font-serif mb-2">Próximo Destino: Kyoto</h2>
            <p>Del 12 de junio al 20 de junio. Prepárate para disfrutar de los templos y jardines.</p>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-serif mb-2">Notas personales</h3>
            <p class="mb-2">Llevar cámara y cuaderno. Revisar transporte interno.</p>
            <pre class="bg-tierra-oscuro text-white p-4 rounded-lg font-mono text-sm">
    Checklist:
    - Pasaporte
    - Billetes de avión
    - Reserva de hotel
            </pre>
        </div>

        <button class="bg-tierra-oscuro text-white px-4 py-2 rounded-lg hover:bg-tierra-medio transition">
            Añadir nuevo destino
        </button>
    </div>

    <h1>{{ $diario->titulo }}</h1>
    <p><strong>Contenido:</strong> {{ $diario->contenido }}</p>
    <p><strong>Fechas:</strong> {{ $diario->fecha_inicio }} - {{ $diario->fecha_final }}</p>


     {{-- Mostrar los destinos como tarjetas --}}
    @if($diario->destinos->count())
        <div class="mt-10">
            <h2 class="text-2xl font-semibold mb-4">Destinos del Diario</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @foreach($diario->destinos as $destino)
                    <div class="relative rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 group">
                        <div class="relative w-full h-120">
                            <!-- Card de destino -->
                            <div class="absolute inset-0 w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $destino->imagen_url) }}')"></div>
                        </div>

                        <div class="absolute inset-0 flex flex-col justify-end p-4 text-white bg-black bg-opacity-50">
                            <h3 class="text-lg font-semibold">{{ $destino->nombre }}</h3>
                            <p class="text-sm">{{ Str::limit($destino->descripcion, 100) }}</p>
                            <a href="{{ route('destinos.show', $destino->slug) }}" class="mt-2 text-blue-500 hover:underline">Ver Destino</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Agrega otros campos como impacto_ambiental, libros, etc. si están disponibles --}}

    @if($diario->imagenes->count())
        <div class="mt-10">
            <h2 class="text-2xl font-semibold mb-4">Galería</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @foreach($diario->imagenes->where('is_principal', false) as $imagen)
                    <div class="relative rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 group">
                        <div class="relative w-full h-120">
                            <img
                                src="{{ asset('storage/' . $imagen->url_imagen) }}"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                alt="Imagen del diario"
                            />

                            @if(auth()->id() === $diario->user_id)
                                <!-- Botón eliminar -->
                                <form action="{{ route('diario-imagenes.destroy', $imagen->id) }}" method="POST" class="absolute top-2 right-2 z-10">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('¿Eliminar esta imagen?');"
                                            class="text-white bg-red-600 rounded-full px-2 py-1 hover:bg-red-700 transition text-sm">
                                        ❌
                                    </button>
                                </form>

                                <!-- Establecer como principal -->
                                <form action="{{ route('diario-imagenes.establecerPrincipal', $imagen->id) }}" method="POST" class="absolute bottom-2 left-2 z-10">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700">
                                        📌 Principal
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @auth
        @if(auth()->id() === $diario->user_id)

            <form action="{{ route('diarios.agregarImagen', $diario->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>Agregar más imágenes:</label>
                <input type="file" name="imagenes[]" multiple>
                <button type="submit">Subir</button>
            </form>

            <p>
                <!-- Enlace para editar el diario -->
                <a href="{{ route('diarios.edit', $diario->slug) }}" class="btn btn-warning">Editar Diario</a>
            </p>

            <form action="{{ route('diarios.destroy', $diario->slug) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        @endif
    @endauth

@endsection
