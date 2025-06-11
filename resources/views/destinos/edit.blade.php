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
<section class="max-w-4xl mx-auto p-6 bg-white shadow-sm rounded-sm mt-10">
    <h1 class="text-3xl sm:text-4xl font-playfair font-bold italic text-gray-700 mb-8 text-center">
        <span class="italic text-violet-400 thin-underline underline-offset-6">Editar</span> el Destino de tu viaje
    </h1>

    {{-- <div class="mb-4 text-sm text-gray-600">
        <p>Fechas del Diario (rango disponible):
            <span class="font-semibold">{{ $diario->fecha_inicio ? $diario->fecha_inicio->format('d/m/Y') : 'N/A' }}</span> -
            <span class="font-semibold">{{ $diario->fecha_final ? $diario->fecha_final->format('d/m/Y') : 'N/A' }}</span>
        </p>
    </div> --}}

    <form action="{{ route('destinos.update', $destino->slug) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <div>
            <label for="nombre_destino" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Destino</label>
            <input type="text" id="nombre_destino" name="nombre_destino" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm" value="{{ old('nombre_destino', $destino->nombre_destino) }}" required>
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

         <p class="block text-sm font-medium text-gray-600 mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-5 mr-2 text-orange-600 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <span class="text-orange-600">Sólo se permiten fechas dentro del rango del diario</span>
        </p>

        <div>
            <label for="alojamiento" class="block text-sm font-medium text-gray-700 mb-1">Alojamiento</label>
            <input type="text" name="alojamiento" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm" value="{{ old('alojamiento', $destino->alojamiento) }}">
            @error('alojamiento') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="personas_conocidas" class="block text-sm font-medium text-gray-700 mb-1">Personas Conocidas</label>
            <textarea name="personas_conocidas" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm" rows="4">{{ old('personas_conocidas', $destino->personas_conocidas) }}</textarea>
            @error('personas_conocidas') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="relato" class="block text-sm font-medium text-gray-700 mb-1">Relato del Destino</label>
            <textarea name="relato" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm" rows="4">{{ old('relato', $destino->relato) }}</textarea>
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
{{-- JS de Leaflet --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

{{-- JS de Flatpickr y su localización en español --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Obtiene la latitud y longitud inicial de los campos ocultos del formulario
        // Si no existen usa coordenadas predeterminadas de España (Madrid)
        const latitudInicial = parseFloat(document.getElementById('latitud').value) || 40.41;
        const longitudInicial = parseFloat(document.getElementById('longitud').value) || -3.70;

        // Si ya hay coordenadas, hace un zoom más cercano (13),sino un zoom más alejado (5) para ver una región más amplia
        const zoomInicial = (document.getElementById('latitud').value && document.getElementById('longitud').value) ? 13 : 5;

        const mapa = L.map('mapa').setView([latitudInicial, longitudInicial], zoomInicial);
        let marcador;

        // Añade OpenStreetMap al mapa
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(mapa);

        // Si ya existen coordenadas iniciales en el formulario, coloca un marcador en esa posicion
        if (document.getElementById('latitud').value && document.getElementById('longitud').value) {
            marcador = L.marker([latitudInicial, longitudInicial]).addTo(mapa);
        }

        const inputUbicacion = document.getElementById('ubicacion');
        const inputLatitud = document.getElementById('latitud');
        const inputLongitud = document.getElementById('longitud');
        const datalistSugerencias = document.getElementById('suggestions');

        // Función para actualizar el marcador y las coordenadas en los inputs
        function actualizarMarcador(lat, lon, zoom = 13) {
            if (marcador) mapa.removeLayer(marcador);

            marcador = L.marker([lat, lon]).addTo(mapa);

            mapa.setView([lat, lon], zoom);

            inputLatitud.value = lat;
            inputLongitud.value = lon;
        }

        // búsqueda de ubicación autocompletar
        inputUbicacion.addEventListener('input', function () {

            if (this.value.length < 3) {
                datalistSugerencias.innerHTML = '';
                return;
            }

            // Realiza una petición fetch a la ruta de búsqueda de destinos
            // 'destinos.buscar' es una ruta que devuelve datos de ubicación
            fetch(`{{ route('destinos.buscar') }}?q=${encodeURIComponent(this.value)}`)
                .then(response => response.json())
                .then(data => {
                    datalistSugerencias.innerHTML = '';

                    // Para cada resultado de la búsqueda, crea una opción en el datalist
                    data.forEach(item => {
                        const opcion = document.createElement('option');
                        opcion.value = item.display_name; // El texto visible de la sugerencia
                        opcion.setAttribute('data-lat', item.lat); // Almacena la latitud como un atributo de dato
                        opcion.setAttribute('data-lon', item.lon); // Almacena la longitud como un atributo de dato
                        datalistSugerencias.appendChild(opcion);
                    });
                });
        });

        // al seleccionar una sugerencia del autocompletar
        inputUbicacion.addEventListener('change', function () {
            const valorSeleccionado = this.value;

            // Itera sobre las opciones del datalist para encontrar la que coincide con el valor seleccionado
            for (let opcion of datalistSugerencias.options) {
                if (opcion.value === valorSeleccionado) {

                    const lat = opcion.getAttribute('data-lat');
                    const lon = opcion.getAttribute('data-lon');

                    if (lat && lon) actualizarMarcador(parseFloat(lat), parseFloat(lon));

                    break;
                }
            }
        });

        // al hacer clic en el mapa
        mapa.on('click', function (evento) {
            // Obtiene las coordenadas de latitud y longitud del clic, redondeadas a 6 decimales
            const latClic = evento.latlng.lat.toFixed(6);
            const lonClic = evento.latlng.lng.toFixed(6);

            actualizarMarcador(parseFloat(latClic), parseFloat(lonClic));
            // Realiza una petición fetch para obtener nombre de lugar a partir de coordenadas
            fetch(`/destinos/obtener-direccion?lat=${latClic}&lon=${lonClic}`)
                .then(response => response.json())
                .then(data => {
                    // Si la respuesta tiene un nombre de visualización, actualiza el campo de ubicación
                    if (data && data.display_name) inputUbicacion.value = data.display_name;
                });
        });

        // Flatpickr para las fechas
        // fechas de inicio y fin del diario principal
        const fechaInicioDiario = "{{ $diario->fecha_inicio ? $diario->fecha_inicio->format('Y-m-d') : '' }}";
        const fechaFinalDiario = "{{ $diario->fecha_final ? $diario->fecha_final->format('Y-m-d') : '' }}";

        const elementoFechaInicioDestino = document.getElementById('fecha_inicio_destino');
        const elementoFechaFinalDestino = document.getElementById('fecha_final_destino');

        if (elementoFechaInicioDestino && elementoFechaFinalDestino) {
            // Localiza Flatpickr al español
            if (flatpickr.l10ns && flatpickr.l10ns.es) {
                flatpickr.localize(flatpickr.l10ns.es);
            }

            // Configuración para selectores de fecha Flatpickr
            const configuracionFlatpickrComun = {
                altInput: true,         // Habilita un input alternativo para un formato de fecha más legibl
                altFormat: "j F, Y",    // Formato de fecha para el input alternativo (ej: "1 Enero, 2023")
                dateFormat: "Y-m-d",    // Formato de fecha real que se enviará en el formulario
                allowInput: false,      // No permite la entrada manual de la fecha
                minDate: fechaInicioDiario || undefined, // La fecha mínima seleccionable es la fecha de inicio del diario
                maxDate: fechaFinalDiario || undefined, // La fecha máxima seleccionable es la fecha final del diario
            };

            // Inicializa Flatpickr para la fecha final del destino
            const fpFinalDestino = flatpickr(elementoFechaFinalDestino, {
                ...configuracionFlatpickrComun,
            });

            // Inicializa Flatpickr para la fecha de inicio del destino
            const fpInicioDestino = flatpickr(elementoFechaInicioDestino, {
                ...configuracionFlatpickrComun,

                // Función que se ejecuta cuando se selecciona una fecha de inicio
                onChange: function(fechasSeleccionadas, cadenaFecha) {

                    // Establece la fecha mínima seleccionable para el selector de fecha final
                    fpFinalDestino.set('minDate', cadenaFecha);

                    // Si la fecha final ya seleccionada es anterior a la nueva fecha de inicio, la limpia
                    if (fpFinalDestino.selectedDates.length > 0 && new Date(fpFinalDestino.selectedDates[0]) < new Date(cadenaFecha)) {
                        fpFinalDestino.clear();
                    }
                }
            });

            // Si ya hay una fecha de inicio en el campo al cargar la página, ajusta la fecha mínima del selector de fecha final para que no sea anterior
            if (elementoFechaInicioDestino.value) {
                fpFinalDestino.set('minDate', elementoFechaInicioDestino.value);
            }
        }
    });
</script>
@endpush
