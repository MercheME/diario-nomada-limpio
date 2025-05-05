@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-center mb-6">🗺️ Mapa de Diarios de Viaje</h1>

    <!-- Mapa -->
    <div id="map" class="w-full h-[600px] rounded-xl shadow-lg"></div>

    <button id="ver-todos" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Ver todos los destinos
    </button>

    <!-- Lista de destinos -->
    <div class="mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Destinos:</h2>
        <div id="destinos-list">
            <!-- Aquí aparecerán los destinos -->
            @foreach(collect($diarios)->pluck('destino')->unique() as $destino)
                <p class="text-lg cursor-pointer destino-item" data-destino="{{ $destino }}">{{ $destino ?? 'Sin destino' }}</p>
            @endforeach
        </div>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
    const diarios = @json($diarios);

    const map = L.map('map').setView([40.4168, -3.7038], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const todosLosMarcadores = [];
    const marcadorPorDestino = {};

    const markerGroup = L.featureGroup().addTo(map);

    for (const diario of diarios) {
        if (diario.destino) {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(diario.destino)}&format=json&limit=1`);
            const data = await response.json();

            if (data.length > 0) {
                let lat = parseFloat(data[0].lat);
                let lon = parseFloat(data[0].lon);

                const popupContent = `
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md max-w-xs">
                        <h3 class="text-xl font-bold text-indigo-600 mb-3">${diario.destino}</h3>
                        <div class="mb-4">
                            <strong class="text-lg font-semibold text-gray-800">${diario.titulo}</strong>
                            <p class="text-sm text-gray-600 mt-2">${diario.descripcion || 'Sin descripción disponible'}</p>
                        </div>
                    </div>`;

                const marker = L.marker([lat, lon])
                    .bindPopup(popupContent)
                    .addTo(markerGroup);

                todosLosMarcadores.push(marker);

                // Agrupar por destino
                if (!marcadorPorDestino[diario.destino]) {
                    marcadorPorDestino[diario.destino] = [];
                }
                marcadorPorDestino[diario.destino].push(marker);
            }
        }
    }

    function mostrarMarcadores(marcadores) {
        markerGroup.clearLayers();
        marcadores.forEach(marker => marker.addTo(markerGroup));

        if (marcadores.length > 0) {
            const group = new L.featureGroup(marcadores);
            map.fitBounds(group.getBounds().pad(0.2));
        }
    }

    function distribuirMarcadores(marcadores) {
        const distribuidos = marcadores.map((marker, index) => {
            const offsetX = (Math.random() - 0.5) * 0.01; // 0.01 grados = 1 km de diferencia
            const offsetY = (Math.random() - 0.5) * 0.01; // 0.01 grados = 1 km de diferencia

            let latLng = marker.getLatLng();
            let newLat = latLng.lat + offsetY;
            let newLon = latLng.lng + offsetX;

            marker.setLatLng([newLat, newLon]);
            return marker;
        });

        return distribuidos;
    }

    // Click en destino específico
    const destinoItems = document.querySelectorAll('.destino-item');
    destinoItems.forEach(item => {
        item.addEventListener('click', () => {
            const destino = item.getAttribute('data-destino');
            const marcadorDestino = marcadorPorDestino[destino] || [];

            // Desplazamos los marcadores del destino específico
            const marcadoresDesplazados = distribuirMarcadores(marcadorDestino);

            mostrarMarcadores(marcadoresDesplazados);
        });
    });

    // Click en "Ver todos"
    document.getElementById('ver-todos').addEventListener('click', () => {
        // Desplazamos todos los marcadores para evitar que se solapen
        const todosDesplazados = distribuirMarcadores(todosLosMarcadores);

        mostrarMarcadores(todosDesplazados);
    });

    // Mostrar todos al inicio
    mostrarMarcadores(todosLosMarcadores);
});

</script>
@endsection
