@extends('layouts.app')
{{-- CSS de Flatpickr --}}
<link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">

@push('styles')
    <style>
        /* Estilo personalizado para el input de Flatpickr */
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
    <h1 class="text-3xl sm:text-4xl font-playfair font-bold italic text-gray-700 mb-8 text-center">
        <span class="italic text-violet-400 thin-underline underline-offset-6">Crea</span> tu <span class="italic text-violet-400 thin-underline underline-offset-6">Destino</span> de Viaje
    </h1>

    {{-- <div class="mb-4 text-sm text-gray-600">
        <p>Fechas del Diario (rango permitido para el destino):
            <span class="font-semibold">{{ $diario->fecha_inicio ? $diario->fecha_inicio->format('d/m/Y') : 'N/A' }}</span> -
            <span class="font-semibold">{{ $diario->fecha_final ? $diario->fecha_final->format('d/m/Y') : 'N/A' }}</span>
        </p>
    </div> --}}

    <form action="{{ route('destinos.store', $diario) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf

        <!-- Agregar Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <div>
            <label for="nombre_destino" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Destino</label>
            <input type="text" id="nombre_destino" name="nombre_destino" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm" value="{{ old('titulo') }}" placeholder="Buscar destino o selecciona en el mapa">
        </div>

        <!-- Ubicación -->
        <div>
            <label for="ubicacion" class="block text-sm font-medium text-gray-700 mb-1">Introduce o selecciona en el mapa la Ubicación del Destino</label>
            <input type="text"
                id="ubicacion"
                name="ubicacion"
                list="suggestions"
                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                placeholder="Se autocompletará al buscar"
                value="{{ old('ubicacion') }}"
                required>
            <datalist id="suggestions"></datalist>
            @error('ubicacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
        <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">

         <!-- Selección de ubicación en el mapa -->
         <div>
            <label for="mapa" class="block font-medium"></label>
            <div id="mapa" style="height: 300px;"></div>
            @error('mapa') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="fecha_inicio_destino" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio del Destino</label>
                <input type="date" name="fecha_inicio_destino" id="fecha_inicio_destino"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                       value="{{ old('fecha_inicio_destino') }}" placeholder="Selecciona fecha" required>
                @error('fecha_inicio_destino') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="fecha_final_destino" class="block text-sm font-medium text-gray-700 mb-1">Fecha Final del Destino</label>
                <input type="date" name="fecha_final_destino" id="fecha_final_destino"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                       value="{{ old('fecha_final_destino') }}" placeholder="Selecciona fecha" required>
                @error('fecha_final_destino') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="alojamiento" class="block text-sm font-medium text-gray-700 mb-1">Alojamiento</label>
            <input type="text" name="alojamiento" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm" value="{{ old('alojamiento') }}">
            @error('alojamiento') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="personas_conocidas" class="block text-sm font-medium text-gray-700 mb-1">Personas Conocidas</label>
            <textarea name="personas_conocidas" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm" rows="4">{{ old('personas_conocidas') }}</textarea>
            @error('personas_conocidas') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="relato" class="block text-sm font-medium text-gray-700 mb-1">Relato sobre tu experiencia</label>
            <textarea name="relato" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm" rows="4">{{ old('relato') }}</textarea>
            @error('relato') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="imagenes" class="block text-sm font-medium text-gray-700 mb-1">Añadir Imagen Principal</label>
            <input type="file" name="imagenes[]" id="imagenes" class="form-control block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-100 file:text-violet-700 hover:file:bg-violet-200 cursor-pointer">
        </div>

        <div>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                Guardar Destino
            </button>
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

    let map = L.map('mapa').setView([20.0, 0.0], 2);
    let marker;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // hacer clic en el mapa
    map.on('click', function (e) {
        let lat = e.latlng.lat;
        let lon = e.latlng.lng;

        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lon]).addTo(map);

        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lon;

        fetch(`/destinos/obtener-direccion?lat=${lat}&lon=${lon}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) {
                    document.getElementById('ubicacion').value = data.display_name;
                }
            });
    });

    // Buscar sugerencias al escribir
    document.getElementById('ubicacion').addEventListener('input', function () {
        const query = this.value;

        if (query.length < 3) {
            document.getElementById('suggestions').innerHTML = '';
            return;
        }

        fetch(`/destinos/buscar-direccion?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                const suggestions = document.getElementById('suggestions');
                suggestions.innerHTML = '';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.display_name;
                    option.setAttribute('data-lat', item.lat);
                    option.setAttribute('data-lon', item.lon);
                    suggestions.appendChild(option);
                });
            });
    });

    // Actualizar mapa al elegir sugerencia
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
                map.setView([lat, lon], 13); // Centramos el mapa en el marcador con más zoom

                // Actualizar campos ocultos
                document.getElementById('latitud').value = lat;
                document.getElementById('longitud').value = lon;
                break;
            }
        }
    });
</script>

{{-- Flatpickr para las fechas del destino --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const diarioFechaInicio = "{{ $diario->fecha_inicio ? $diario->fecha_inicio->format('Y-m-d') : '' }}";
    const diarioFechaFinal = "{{ $diario->fecha_final ? $diario->fecha_final->format('Y-m-d') : '' }}";

    const fechaInicioDestinoElem = document.getElementById('fecha_inicio_destino');
    const fechaFinalDestinoElem = document.getElementById('fecha_final_destino');

    if (!fechaInicioDestinoElem || !fechaFinalDestinoElem) {
        console.warn("Flatpickr (Destinos): Inputs de fecha no encontrados.");
        return;
    }

    if (flatpickr.l10ns && flatpickr.l10ns.es) {
        flatpickr.localize(flatpickr.l10ns.es);
    } else {
        console.warn("Flatpickr (Destinos): Localización 'es' no encontrada.");
    }

    let fpInicioDestino = null;
    let fpFinalDestino = null;

    const configFlatpickrComun = {
        altInput: true,
        altFormat: "j F, Y",
        dateFormat: "Y-m-d",
        allowInput: false,
        minDate: diarioFechaInicio || undefined, // undefined para no poner límite si es null o vacío
        maxDate: diarioFechaFinal || undefined,
    };

    fpInicioDestino = flatpickr(fechaInicioDestinoElem, {
        ...configFlatpickrComun,
        onChange: function(selectedDates, dateStr, instance) {
            if (fpFinalDestino) {
                let minDateParaFinal = dateStr; // La fecha final del destino no puede ser anterior a su inicio
                // Asegurar que minDate para fecha_final también respete el inicio del diario padre
                if (diarioFechaInicio && new Date(dateStr) < new Date(diarioFechaInicio)) {
                     minDateParaFinal = diarioFechaInicio;
                }
                fpFinalDestino.set('minDate', minDateParaFinal);

                if (fpFinalDestino.selectedDates.length > 0 && new Date(fpFinalDestino.selectedDates[0]) < new Date(dateStr)) {
                    fpFinalDestino.clear();
                }
            }
        }
    });

    fpFinalDestino = flatpickr(fechaFinalDestinoElem, {
        ...configFlatpickrComun,
    });

    // Configurar minDate inicial para fecha_final si fecha_inicio_destino tiene valor 'old()' o si diarioFechaInicio existe
    const valorOldInicio = fechaInicioDestinoElem.value;
    if (fpFinalDestino) {
        if (valorOldInicio) {
             let minDateInicialFinal = valorOldInicio;
             if (diarioFechaInicio && new Date(valorOldInicio) < new Date(diarioFechaInicio)) {
                 minDateInicialFinal = diarioFechaInicio;
             }
            fpFinalDestino.set('minDate', minDateInicialFinal);
        } else if (diarioFechaInicio) { // Si no hay valor 'old', pero el diario tiene fecha de inicio
            fpFinalDestino.set('minDate', diarioFechaInicio);
        }
    }

});
</script>
@endpush



