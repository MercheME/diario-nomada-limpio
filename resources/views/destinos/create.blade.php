@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Crear Destino</h1>

    <form action="{{ route('destinos.store', $diario) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf

        <!-- Agregar Leaflet en tu vista -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <!-- Nombre del destino -->
        <div>
            <label for="nombre_destino" class="block font-medium">Nombre del Destino</label>
            <input type="text" id="nombre_destino" name="nombre_destino" class="w-full border p-2 rounded" placeholder="Buscar destino o selecciona en el mapa" autocomplete="off" list="suggestions">
        </div>

        <!-- Ubicación seleccionada -->
        <div>
            <label for="ubicacion" class="block font-medium">Ubicación (Seleccionada desde el mapa o autocompletado)</label>
            <input type="text" id="ubicacion" name="ubicacion" class="w-full border p-2 rounded" placeholder="Ubicación seleccionada" autocomplete="off" readonly value="{{ old('ubicacion') }}">
            @error('ubicacion') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
        <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">

         <!-- Selección de ubicación en el mapa -->
         <div>
            <label for="mapa" class="block font-medium">Seleccionar ubicación en el mapa</label>
            <div id="mapa" style="height: 300px;"></div>
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
                <label for="fecha_inicio_destino" class="block font-medium">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio_destino" class="w-full border p-2 rounded" value="{{ old('fecha_inicio_destino') }}">
                @error('fecha_inicio_destino') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="w-1/2">
                <label for="fecha_final_destino" class="block font-medium">Fecha Final</label>
                <input type="date" name="fecha_final_destino" class="w-full border p-2 rounded" value="{{ old('fecha_final_destino') }}">
                @error('fecha_final_destino') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
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

        <div class="form-group">
            <label for="imagenes">Imágenes</label>
            <input type="file" name="imagenes[]" id="imagenes" class="form-control" multiple>
        </div>

        <!-- Botón para guardar -->
        <div>
           <!-- Formulario para crear destino -->
        <button type="submit">Guardar Destino</button>
        </div>
    </form>
</section>
<script>
    var map = L.map('mapa').setView([20.0, 0.0], 2);
    var marker;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // ✅ Manejar clic en mapa
    map.on('click', function (e) {
        let lat = e.latlng.lat;
        let lon = e.latlng.lng;

        // Eliminar marcador anterior
        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lon]).addTo(map);

        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lon;

        // Buscar nombre del lugar
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) {
                    document.getElementById('ubicacion').value = data.display_name;
                }
            });
    });

    // ✅ Autocompletado desde input
    document.getElementById('ubicacion').addEventListener('input', function () {
        const query = this.value;

        if (query.length < 3) return;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&addressdetails=1&limit=5`)
            .then(response => response.json())
            .then(data => {
                const datalist = document.getElementById('suggestions');
                datalist.innerHTML = '';

                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.display_name;
                    option.setAttribute('data-lat', item.lat);
                    option.setAttribute('data-lon', item.lon);
                    datalist.appendChild(option);
                });
            });
    });

    // ✅ Si el usuario selecciona una opción del datalist
    document.getElementById('ubicacion').addEventListener('change', function () {
        const val = this.value;
        const options = document.getElementById('suggestions').children;

        for (let i = 0; i < options.length; i++) {
            if (options[i].value === val) {
                const lat = options[i].getAttribute('data-lat');
                const lon = options[i].getAttribute('data-lon');

                // Actualizar marcador en mapa
                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lon]).addTo(map);
                map.setView([lat, lon], 10);

                document.getElementById('latitud').value = lat;
                document.getElementById('longitud').value = lon;
                break;
            }
        }
    });
</script>


@endsection
