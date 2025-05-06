@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Crear Destino</h1>

    <form action="{{ route('destinos.store', $diario) }}" method="POST" class="space-y-6">
        @csrf

        <!-- Agregar Leaflet en tu vista -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

         <!-- Nombre del destino (ubicación) -->
         <div>
            <label for="nombre" class="block font-medium">Nombre del Destino</label>
            <input type="text" name="nombre" id="nombre" class="w-full border p-2 rounded" placeholder="Escribe el nombre del destino" value="{{ old('nombre') }}">
            @error('nombre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
        <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">

         <!-- Selección de ubicación en el mapa (opcional, si se quiere permitir click en el mapa para seleccionar) -->
         <div>
            <label for="mapa" class="block font-medium">Seleccionar ubicación en el mapa</label>
            <div id="mapa" style="height: 300px;"></div> <!-- Este div se llenará con un mapa -->
            @error('mapa') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Descripción del destino -->
        <div>
            <label for="descripcion" class="block font-medium">Descripción</label>
            <textarea name="descripcion" class="w-full border p-2 rounded" rows="4">{{ old('descripcion') }}</textarea>
            @error('descripcion') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Fechas -->
        <div class="flex space-x-4">
            <div class="w-1/2">
                <label for="fecha_inicio" class="block font-medium">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" class="w-full border p-2 rounded" value="{{ old('fecha_inicio') }}">
                @error('fecha_inicio') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="w-1/2">
                <label for="fecha_final" class="block font-medium">Fecha Final</label>
                <input type="date" name="fecha_final" class="w-full border p-2 rounded" value="{{ old('fecha_final') }}">
                @error('fecha_final') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Transporte -->
        <div>
            <label for="transporte" class="block font-medium">Transporte</label>
            <input type="text" name="transporte" class="w-full border p-2 rounded" value="{{ old('transporte') }}">
            @error('transporte') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Alojamiento -->
        <div>
            <label for="alojamiento" class="block font-medium">Alojamiento</label>
            <input type="text" name="alojamiento" class="w-full border p-2 rounded" value="{{ old('alojamiento') }}">
            @error('alojamiento') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Personas conocidas -->
        <div>
            <label for="personas_conocidas" class="block font-medium">Personas Conocidas</label>
            <textarea name="personas_conocidas" class="w-full border p-2 rounded" rows="4">{{ old('personas_conocidas') }}</textarea>
            @error('personas_conocidas') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Relato -->
        <div>
            <label for="relato" class="block font-medium">Relato</label>
            <textarea name="relato" class="w-full border p-2 rounded" rows="4">{{ old('relato') }}</textarea>
            @error('relato') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Etiquetas -->
        <div>
            <label for="etiquetas" class="block font-medium">Etiquetas</label>
            <input type="text" name="etiquetas[]" class="w-full border p-2 rounded"
            value="{{ old('etiquetas') ? implode(',', (array) old('etiquetas')) : '' }}"
            placeholder="Agrega etiquetas separadas por coma">
            @error('etiquetas') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Seleccionar en el mapa (opcional, según integración con un servicio como Google Maps o Leaflet) -->
        <div>
            <label for="mapa" class="block font-medium">Seleccionar ubicación en el mapa</label>
            <div id="mapa" style="height: 300px;"></div> <!-- Este div se llenará con un mapa -->
            @error('mapa') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Botón para guardar -->
        <div>
           <!-- Formulario para crear destino -->
        <button type="submit">Guardar Destino</button>
        </div>
    </form>
</section>
<script>
    var map = L.map('mapa').setView([20.0, 0.0], 2); // Centrado por defecto, puedes ajustarlo

    // Cargar OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Detectar el clic del usuario en el mapa
    map.on('click', function(e) {
        let lat = e.latlng.lat;
        let lon = e.latlng.lng;

        // Actualiza los campos ocultos con las coordenadas
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lon;

        // Crear un marcador en la ubicación seleccionada
        let marker = L.marker([lat, lon]).addTo(map);

        // Realizar la búsqueda inversa para obtener la dirección
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                if (data && data.address) {
                    var address = data.address.city || data.address.town || data.address.village || data.address.country;
                    var specificName = data.display_name;

                    if (specificName && !address.includes(specificName)) {
                        address = specificName;
                    }

                    // Autocompletar el campo "nombre" con la dirección
                    document.getElementById('nombre').value = address;
                } else {
                    alert("No se pudo obtener información de este lugar.");
                }
            })
            .catch(error => {
                console.error("Error al obtener los datos:", error);
                alert("Hubo un error al obtener la información del lugar.");
            });
    });
</script>

@endsection
