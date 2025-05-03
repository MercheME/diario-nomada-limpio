{{-- @extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-center mb-6">🗺️ Mapa de Diarios de Viaje</h1>

    <!-- Mapa -->
    <div id="map" class="w-full h-[600px] rounded-xl shadow-lg"></div>

    <!-- Lista de destinos -->
    <div class="mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Destinos:</h2>
        <div id="destinos-list">
            <!-- Aquí aparecerán los destinos -->
            @foreach($diarios as $diario)
                <p class="text-lg">{{ $diario->destino ?? 'Sin destino' }}</p>
            @endforeach

        </div>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const diarios = @json($diarios); // Pasar los diarios desde PHP a JavaScript

        const map = L.map('map').setView([40.4168, -3.7038], 4);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const destinoMap = {};

        for (const diario of diarios) {
            if (diario.destino) {
                if (!destinoMap[diario.destino]) {
                    destinoMap[diario.destino] = [];
                }
                destinoMap[diario.destino].push(diario);
            }
        }

        for (const destino in destinoMap) {
            const diariosGrupo = destinoMap[destino];

            const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(destino)}&format=json&limit=1`);
            const data = await response.json();

            if (data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);

                const popupContent = diariosGrupo.map(d => `
                    <div class="mb-4">
                        <strong class="text-lg font-semibold text-gray-800">${d.titulo}</strong>
                        <p class="text-sm text-gray-600 mt-2">${d.descripcion || 'Sin descripción disponible'}</p>
                    </div>`).join('<br>');

                L.marker([lat, lon])
                    .addTo(map)
                    .bindPopup(`
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md max-w-xs">
                            <h3 class="text-xl font-bold text-indigo-600 mb-3">${destino}</h3>
                            ${popupContent}
                        </div>`
                    );
            }
        }
    });
</script>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-center mb-6">🗺️ Mapa de Diarios de Viaje</h1>

    <!-- Mapa -->
    <div id="map" class="w-full h-[600px] rounded-xl shadow-lg"></div>

    <!-- Lista de destinos -->
    <div class="mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Destinos:</h2>
        <div id="destinos-list">
            <!-- Aquí aparecerán los destinos -->
            @foreach($diarios as $diario)
                <p class="text-lg cursor-pointer destino-item" data-destino="{{ $diario->destino }}">{{ $diario->destino ?? 'Sin destino' }}</p>
            @endforeach
        </div>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        // Pasamos los diarios desde PHP a JavaScript
        const diarios = @json($diarios);
        console.log(diarios); // Verificamos que los diarios se pasen correctamente

        const map = L.map('map').setView([40.4168, -3.7038], 4); // Vista inicial del mapa (España)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let colorIndex = 0; // Índice para cambiar el color de los marcadores

        const colors = [
            'red', 'blue', 'green', 'purple', 'orange', 'pink', 'brown', 'yellow', 'black', 'cyan'
        ]; // Lista de colores de marcadores

        // Almacenamos los marcadores para cada destino en un objeto
        const marcadorPorDestino = {};

        // Recorremos los diarios y creamos los marcadores
        for (const diario of diarios) {
            if (diario.destino) {
                // Obtenemos las coordenadas de cada destino
                const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(diario.destino)}&format=json&limit=1`);
                const data = await response.json();

                // Si la respuesta de la API contiene datos
                if (data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);

                    if (!isNaN(lat) && !isNaN(lon)) {
                        const popupContent = `
                            <div class="mb-4">
                                <strong class="text-lg font-semibold text-gray-800">${diario.titulo}</strong>
                                <p class="text-sm text-gray-600 mt-2">${diario.descripcion || 'Sin descripción disponible'}</p>
                            </div>`;

                        // Obtener el color para el marcador
                        const markerColor = colors[colorIndex % colors.length];
                        colorIndex++;

                        // Crear el marcador
                        const marker = L.marker([lat, lon], {
                            icon: L.divIcon({
                                className: 'leaflet-div-icon',
                                html: `<div style="background-color: ${markerColor}; border-radius: 50%; width: 25px; height: 25px;"></div>`,
                                iconSize: [25, 25],
                            })
                        }).bindPopup(popupContent);

                        // Almacenamos el marcador en el objeto de destino
                        if (!marcadorPorDestino[diario.destino]) {
                            marcadorPorDestino[diario.destino] = [];
                        }
                        marcadorPorDestino[diario.destino].push(marker);
                    }
                }
            }
        }

        // Manejador de clics en los destinos listados
        const destinoItems = document.querySelectorAll('.destino-item');
        destinoItems.forEach(item => {
            item.addEventListener('click', () => {
                const destino = item.getAttribute('data-destino');
                mostrarMarcadoresPorDestino(destino);
            });
        });

        // Función para mostrar los marcadores de un destino específico
        function mostrarMarcadoresPorDestino(destino) {
            // Limpiamos los marcadores actuales
            map.eachLayer(layer => {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            // Agregar los marcadores del destino seleccionado
            if (marcadorPorDestino[destino]) {
                marcadorPorDestino[destino].forEach(marker => {
                    marker.addTo(map);
                });
            }
        }
    });
</script>
@endsection
