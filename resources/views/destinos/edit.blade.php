@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">

@push('styles')
    <style>
        .flatpickr-alt.form-input {
            display: block; width: 100%; padding: 0.5rem 0.75rem;
            font-size: 0.875rem; line-height: 1.25rem; color: #1f2937;
            background-color: #fff; border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
<section class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Editar Destino: {{ $destino->nombre_destino }}</h1>

    <div class="mb-4 text-sm text-gray-600">
        <p>Fechas del Diario (rango permitido para el destino):
            <span class="font-semibold">{{ $diario->fecha_inicio ? $diario->fecha_inicio->format('d/m/Y') : 'N/A' }}</span> -
            <span class="font-semibold">{{ $diario->fecha_final ? $diario->fecha_final->format('d/m/Y') : 'N/A' }}</span>
        </p>
    </div>

    <form action="{{ route('destinos.update', $destino->slug) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Agregar Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <div>
            <label for="nombre_destino" class="block font-medium">Nombre del Destino</label>
            <input type="text" id="nombre_destino" name="nombre_destino" class="w-full border p-2 rounded"
                   value="{{ old('nombre_destino', $destino->nombre_destino) }}" required>
            @error('nombre_destino') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="ubicacion" class="block text-sm font-medium text-gray-700 mb-1">Ubicación del Destino</label>
            <input type="text" id="ubicacion" name="ubicacion" list="suggestions"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                   placeholder="Busca o selecciona en el mapa"
                   value="{{ old('ubicacion', $destino->ubicacion) }}" required>
            <datalist id="suggestions"></datalist>
            @error('ubicacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud', $destino->latitud ?? '') }}">
        <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud', $destino->longitud ?? '') }}">

        <div>
            <label for="mapa" class="block font-medium">Seleccionar ubicación en el mapa</label>
            <div id="mapa" style="height: 300px;"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="fecha_inicio_destino" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio del Destino</label>
                <input type="date" name="fecha_inicio_destino" id="fecha_inicio_destino"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                       value="{{ old('fecha_inicio_destino', $destino->fecha_inicio_destino ? \Carbon\Carbon::parse($destino->fecha_inicio_destino)->format('Y-m-d') : '') }}" required>
                @error('fecha_inicio_destino') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="fecha_final_destino" class="block text-sm font-medium text-gray-700 mb-1">Fecha Final del Destino</label>
                <input type="date" name="fecha_final_destino" id="fecha_final_destino"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                       value="{{ old('fecha_final_destino', $destino->fecha_final_destino ? \Carbon\Carbon::parse($destino->fecha_final_destino)->format('Y-m-d') : '') }}" required>
                @error('fecha_final_destino') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="alojamiento" class="block font-medium">Alojamiento</label>
            <input type="text" name="alojamiento" class="w-full border p-2 rounded" value="{{ old('alojamiento', $destino->alojamiento) }}">
            @error('alojamiento') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="personas_conocidas" class="block font-medium">Personas Conocidas</label>
            <textarea name="personas_conocidas" class="w-full border p-2 rounded" rows="4">{{ old('personas_conocidas', $destino->personas_conocidas) }}</textarea>
            @error('personas_conocidas') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="relato" class="block font-medium">Relato del Destino</label>
            <textarea name="relato" class="w-full border p-2 rounded" rows="4">{{ old('relato', $destino->relato) }}</textarea>
            @error('relato') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-md font-semibold text-white bg-violet-600 hover:bg-violet-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                Actualizar Destino
            </button>
            <a href="{{ route('diarios.show', $diario->slug) }}" class="ml-4 text-gray-600 hover:text-gray-800">Cancelar</a>
        </div>
    </form>
</section>
@endsection

@push('scripts')
{{-- JS de Leaflet (CDN) --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
{{-- JS de Flatpickr y su localización en español --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const initialLat = parseFloat(document.getElementById('latitud').value) || 40.41;
    const initialLon = parseFloat(document.getElementById('longitud').value) || -3.70;
    const initialZoom = (document.getElementById('latitud').value && document.getElementById('longitud').value) ? 13 : 5;


    const mapa = L.map('mapa').setView([initialLat, initialLon], initialZoom);
    let marker;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(mapa);

    // Si hay coordenadas iniciales, colocar el marcador
    if (document.getElementById('latitud').value && document.getElementById('longitud').value) {
        marker = L.marker([initialLat, initialLon]).addTo(mapa);
    }

    const inputUbicacion = document.getElementById('ubicacion');
    const inputLatitud = document.getElementById('latitud');
    const inputLongitud = document.getElementById('longitud');
    const suggestionsDatalist = document.getElementById('suggestions');

    function actualizarMarcador(lat, lon, zoom = 13) {
        if (marker) mapa.removeLayer(marker);
        marker = L.marker([lat, lon]).addTo(mapa);
        mapa.setView([lat, lon], zoom);
        inputLatitud.value = lat;
        inputLongitud.value = lon;
    }

    inputUbicacion.addEventListener('input', function () {
        if (this.value.length < 3) {
            suggestionsDatalist.innerHTML = '';
            return;
        }
        fetch(`{{ route('destinos.buscar') }}?q=${encodeURIComponent(this.value)}`) // Asume que tienes esta ruta
            .then(response => response.json())
            .then(data => {
                suggestionsDatalist.innerHTML = '';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.display_name;
                    option.setAttribute('data-lat', item.lat);
                    option.setAttribute('data-lon', item.lon);
                    suggestionsDatalist.appendChild(option);
                });
            });
    });

    inputUbicacion.addEventListener('change', function () {
        const valor = this.value;
        for (let option of suggestionsDatalist.options) {
            if (option.value === valor) {
                const lat = option.getAttribute('data-lat');
                const lon = option.getAttribute('data-lon');
                if (lat && lon) actualizarMarcador(parseFloat(lat), parseFloat(lon));
                break;
            }
        }
    });

    mapa.on('click', function (e) {
        const lat = e.latlng.lat.toFixed(6);
        const lon = e.latlng.lng.toFixed(6);
        actualizarMarcador(parseFloat(lat), parseFloat(lon));
        fetch(`/destinos/obtener-direccion?lat=${lat}&lon=${lon}`) 
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) inputUbicacion.value = data.display_name;
            });
    });


    // --- FLATPCIKR PARA FECHAS DEL DESTINO ---
    const diarioFechaInicio = "{{ $diario->fecha_inicio ? $diario->fecha_inicio->format('Y-m-d') : '' }}";
    const diarioFechaFinal = "{{ $diario->fecha_final ? $diario->fecha_final->format('Y-m-d') : '' }}";
    const fechaInicioDestinoElem = document.getElementById('fecha_inicio_destino');
    const fechaFinalDestinoElem = document.getElementById('fecha_final_destino');

    if (fechaInicioDestinoElem && fechaFinalDestinoElem) {
        if (flatpickr.l10ns && flatpickr.l10ns.es) {
            flatpickr.localize(flatpickr.l10ns.es);
        }

        const configFlatpickrComun = {
            altInput: true,
            altFormat: "j F, Y",
            dateFormat: "Y-m-d",
            allowInput: false,
            minDate: diarioFechaInicio || undefined,
            maxDate: diarioFechaFinal || undefined,
        };

        const fpFinalDestino = flatpickr(fechaFinalDestinoElem, {
            ...configFlatpickrComun,
        });

        const fpInicioDestino = flatpickr(fechaInicioDestinoElem, {
            ...configFlatpickrComun,
            onChange: function(selectedDates, dateStr) {
                fpFinalDestino.set('minDate', dateStr);
                if (fpFinalDestino.selectedDates.length > 0 && new Date(fpFinalDestino.selectedDates[0]) < new Date(dateStr)) {
                    fpFinalDestino.clear();
                }
            }
        });
        if (fechaInicioDestinoElem.value) {
            fpFinalDestino.set('minDate', fechaInicioDestinoElem.value);
        }
    }
});
</script>
@endpush
