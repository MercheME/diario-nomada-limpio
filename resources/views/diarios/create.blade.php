
@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Crear Diario</h1>

    <form action="{{ route('diarios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Título y destino --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="titulo" class="block font-medium">Título</label>
                <input type="text" name="titulo" class="w-full border p-2 rounded" value="{{ old('titulo') }}">
                @error('titulo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- <div>
                <label for="destino" class="block font-medium">Destino</label>
                <input type="text" name="destino" class="w-full border p-2 rounded" value="{{ old('destino') }}">
                @error('destino') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div> --}}

            <!-- Incluir el CSS de Leaflet -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
            <!-- Incluir el JS de Leaflet -->
            <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

            {{-- <div>
                <label for="destino" class="block font-medium">Destino</label>
                <input type="text" id="destino" name="destino" class="w-full border p-2 rounded" value="{{ old('destino') }}">
            </div> --}}

            <div>
                <label for="destinos" class="block font-medium">Destinos</label>
                <div id="destinos" class="space-y-2">
                    <!-- Los destinos se agregarán aquí como párrafos -->
                </div>
            </div>

            <div id="map" style="height: 400px; margin-top: 20px;"></div> <!-- Aquí se mostrará el mapa -->

        </div>

        {{-- Contenido --}}
        <div>
            <label for="contenido" class="block font-medium">Contenido</label>
            <textarea name="contenido" rows="5" class="w-full border p-2 rounded">{{ old('contenido') }}</textarea>
            @error('contenido') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Fechas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="fecha_inicio" class="block font-medium">Fecha de inicio</label>
                <input type="date" name="fecha_inicio" class="w-full border p-2 rounded" value="{{ old('fecha_inicio') }}">
                @error('fecha_inicio') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="fecha_final" class="block font-medium">Fecha final</label>
                <input type="date" name="fecha_final" class="w-full border p-2 rounded" value="{{ old('fecha_final') }}">
                @error('fecha_final') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Imagen principal --}}
        <div>
            <label for="imagen_principal" class="block font-medium">Imagen principal</label>
            <input type="file" name="imagen_principal" class="block w-full text-sm text-gray-500">
            @error('imagen_principal') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Impactos y reflexiones --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="impacto_ambiental" class="block font-medium">Impacto Ambiental</label>
                <textarea name="impacto_ambiental" class="w-full border p-2 rounded" rows="3">{{ old('impacto_ambiental') }}</textarea>
            </div>

            <div>
                <label for="impacto_cultural" class="block font-medium">Impacto Cultural</label>
                <textarea name="impacto_cultural" class="w-full border p-2 rounded" rows="3">{{ old('impacto_cultural') }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="aprendizajes" class="block font-medium">Aprendizajes</label>
                <textarea name="aprendizajes" class="w-full border p-2 rounded" rows="3">{{ old('aprendizajes') }}</textarea>
            </div>

            <div>
                <label for="compromisos" class="block font-medium">Compromisos</label>
                <textarea name="compromisos" class="w-full border p-2 rounded" rows="3">{{ old('compromisos') }}</textarea>
            </div>
        </div>

        {{-- Cultura (opcional) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="libros" class="block font-medium">Libros relacionados</label>
                <textarea name="libros" class="w-full border p-2 rounded" rows="2">{{ old('libros') }}</textarea>
            </div>

            <div>
                <label for="musica" class="block font-medium">Música</label>
                <textarea name="musica" class="w-full border p-2 rounded" rows="2">{{ old('musica') }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="peliculas" class="block font-medium">Películas</label>
                <textarea name="peliculas" class="w-full border p-2 rounded" rows="2">{{ old('peliculas') }}</textarea>
            </div>

            <div>
                <label for="documentales" class="block font-medium">Documentales</label>
                <textarea name="documentales" class="w-full border p-2 rounded" rows="2">{{ old('documentales') }}</textarea>
            </div>
        </div>

        {{-- Calificación y etiquetas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="calificacion_sostenibilidad" class="block font-medium">Calificación de Sostenibilidad (1-10)</label>
                <input type="number" name="calificacion_sostenibilidad" min="1" max="10" class="w-full border p-2 rounded" value="{{ old('calificacion_sostenibilidad') }}">
            </div>

            <div>
                <label for="etiquetas" class="block font-medium">Etiquetas (separadas por coma)</label>
                <input type="text" name="etiquetas" class="w-full border p-2 rounded" value="{{ old('etiquetas') }}">
            </div>
        </div>

        {{-- Público y favorito --}}
        <div class="flex items-center gap-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_public" value="1" class="mr-2" {{ old('is_public') ? 'checked' : '' }}>
                <span>¿Hacer público el diario?</span>
            </label>

            {{-- <label class="flex items-center">
                <input type="checkbox" name="favorito" value="1" class="mr-2" {{ old('favorito') ? 'checked' : '' }}>
                <span>Marcar como favorito</span>
            </label> --}}
        </div>

        {{-- Botón --}}
        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                Guardar Diario
            </button>
        </div>
    </form>

    @if (session('success'))
        <div class="mt-4 text-green-600 font-medium">
            {{ session('success') }}
        </div>
    @endif
</section>

<script>
 var map = L.map('map').setView([20.0, 0.0], 2); // Centrado por defecto, puedes ajustarlo

// Cargar OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Array para almacenar los destinos y los marcadores
var destinos = [];
var markers = [];

// Detectar el clic del usuario en el mapa
map.on('click', function(e) {
    var lat = e.latlng.lat;
    var lon = e.latlng.lng;

    // Crear un marcador en la ubicación seleccionada
    var marker = L.marker([lat, lon]).addTo(map);

    // Realizar la búsqueda inversa para obtener la dirección
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`)
        .then(response => response.json())
        .then(data => {
            if (data && data.address) {
                // Intentar obtener el nombre más específico del lugar
                var address = data.address.city || data.address.town || data.address.village || data.address.country;

                // Si hay un nombre más específico, como una sierra o paraje natural, lo preferimos
                var specificName = data.display_name;

                // Si el nombre específico de la ubicación (como una sierra) está disponible, usamos ese
                if (specificName && !address.includes(specificName)) {
                    address = specificName;
                }

                // Agregar el destino a la lista de destinos
                destinos.push(address);
                markers.push(marker); // Almacenar marcador

                // Mostrar los destinos como párrafos debajo del mapa
                var destinosContainer = document.getElementById('destinos');
                var destinoP = document.createElement('p');
                destinoP.classList.add('text-sm', 'text-gray-700', 'cursor-pointer');
                destinoP.textContent = address;

                // Añadir evento para eliminar el destino
                destinoP.addEventListener('click', function() {
                    // Eliminar marcador del mapa
                    map.removeLayer(marker);

                    // Eliminar el destino de la lista de destinos
                    destinos = destinos.filter(function(d) {
                        return d !== address;
                    });

                    // Eliminar el párrafo del DOM
                    destinoP.remove();
                });

                destinosContainer.appendChild(destinoP);
            } else {
                // Si no se encontró la dirección de manera adecuada
                alert("No se pudo obtener información de este lugar.");
            }
        })
        .catch(error => {
            console.error("Error al obtener los datos:", error);
            alert("Hubo un error al obtener la información del lugar.");
        });
});
//  var map = L.map('map').setView([20.0, 0.0], 2); // Centrado por defecto, puedes ajustarlo

//     // Cargar OpenStreetMap
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
//     }).addTo(map);

//     // Array para almacenar los destinos y los marcadores
//     var destinos = [];
//     var markers = [];

//     // Detectar el clic del usuario en el mapa
//     map.on('click', function(e) {
//         var lat = e.latlng.lat;
//         var lon = e.latlng.lng;

//         // Crear un marcador en la ubicación seleccionada
//         var marker = L.marker([lat, lon]).addTo(map);

//         // Realizar la búsqueda inversa para obtener la dirección
//         fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`)
//             .then(response => response.json())
//             .then(data => {
//                 if (data && data.address) {
//                     var address = data.address.city || data.address.country || 'Dirección desconocida';

//                     // Agregar el destino a la lista de destinos
//                     destinos.push(address);
//                     markers.push(marker); // Almacenar marcador

//                     // Mostrar los destinos como párrafos debajo del mapa
//                     var destinosContainer = document.getElementById('destinos');
//                     var destinoP = document.createElement('p');
//                     destinoP.classList.add('text-sm', 'text-gray-700', 'cursor-pointer');
//                     destinoP.textContent = address;

//                     // Añadir evento para eliminar el destino
//                     destinoP.addEventListener('click', function() {
//                         // Eliminar marcador del mapa
//                         map.removeLayer(marker);

//                         // Eliminar el destino de la lista de destinos
//                         destinos = destinos.filter(function(d) {
//                             return d !== address;
//                         });

//                         // Eliminar el párrafo del DOM
//                         destinoP.remove();
//                     });

//                     destinosContainer.appendChild(destinoP);
//                 }
//             });
//     });
    </script>
@endsection
