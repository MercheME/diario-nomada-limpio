@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto py-10 px-4">
    <h1 class="text-3xl italic text-violet-600 underline text-center mb-6"> Mapas de Tus Diarios de Viaje</h1>
    <div class="text-center mb-6">
        <p class="text-gray-700 text-lg leading-relaxed">
            Bienvenido/a al <span class="italic text-violet-600">mapa</span> de tus diarios de viaje. En esta sección, podrás ver todos los <span class="italic text-violet-600">destinos</span> de tus diarios ubicados geográficamente. Haz clic en cualquier <span class="italic text-violet-600">marcador</span> del mapa para conocer los <span class="italic text-violet-600">detalles</span> de ese lugar y el diario al que pertenece. Además, puedes usar las <span class="italic text-violet-600">listas </span> para mostrar solo los destinos de un diario específico o ver todos los viajes realizados a una misma ubicación. Si prefieres una vista completa, el botón 'Mostrar Todos los Destinos' te enseñará todas tus <span class="italic text-violet-600">aventuras</span> en el mapa a la vez. ¡Disfruta explorando tus <span class="italic text-violet-600">recuerdos de viaje</span> de una forma más visual!
        </p>
    </div>

    <!-- Mapa -->
    <div id="map" class="w-full h-[400px] md:h-[600px] rounded-xl shadow-lg border border-gray-200 mb-6"></div>

    <div class="text-center mb-8">
        <button id="ver-todos" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-violet-100 hover:bg-violet-200 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
        Mostrar Todos los Destinos Visitados
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Ver todos los destinos de tus Diarios</h2>
            <div id="diarios-list" class="space-y-1 max-h-72 overflow-y-auto border border-gray-200 p-3 rounded-md bg-white shadow-sm">
                @forelse($diarios as $diario_item)
                    <p class="text-md text-sky-700 hover:text-sky-900 hover:bg-sky-50 cursor-pointer diario-item p-2 rounded transition-colors"
                        data-diario-id="{{ $diario_item->id }}">
                        {{ $diario_item->titulo }}
                    </p>
                @empty
                    <p class="text-gray-500 p-2">No has creado ningún diario todavía.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Filtrar por Ubicación del Destino:</h2>
        @php
            $nombresDestinosUnicos = [];
            if (isset($diarios) && $diarios->count() > 0) {
                foreach ($diarios as $diario_item) {
                    if ($diario_item->destinos && $diario_item->destinos->count() > 0) {
                        foreach ($diario_item->destinos as $destino_obj) {
                            if (isset($destino_obj->ubicacion)) {
                                $nombresDestinosUnicos[] = $destino_obj->ubicacion;
                            }
                        }
                    }
                }
            }
            $destinosUnicosParaLista = array_unique($nombresDestinosUnicos);
            sort($destinosUnicosParaLista);
        @endphp
        <div id="destinos-unicos-list" class="space-y-1 max-h-72 overflow-y-auto border border-gray-200 p-3 rounded-md bg-white shadow-sm">
            @forelse($destinosUnicosParaLista as $nombreDestino)
                <p class="text-md text-indigo-700 hover:text-indigo-900 hover:bg-indigo-50 cursor-pointer destino-nombre-item p-2 rounded transition-colors"
                data-destino-nombre="{{ $nombreDestino }}">
                    {{ $nombreDestino }}
                </p>
            @empty
                <p class="text-gray-500 p-2">No hay destinos para mostrar.</p>
            @endforelse
        </div>
    </div>

</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
    // Obtiene los datos de los diarios pasados desde PHP y los convierte a un JSON
    const diariosData = @json($diarios);

    // Inicializa el mapa Leaflet en el div con id="map"
    const map = L.map('map').setView([40.4168, -3.7038], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const todosLosMarcadores = [];
    // Objeto para agrupar marcadores por el nombre de su ubicación
    const marcadoresPorUbicacion = {};
    // Objeto para agrupar marcadores por el ID del diario al que pertenecen
    const marcadoresPorDiarioId = {};
    // Crea un grupo de características de Leaflet. Este grupo contendrá todos los marcadores y se añadirá al mapa
    const grupoMarcadores = L.featureGroup().addTo(map);

    // Función asíncrona que procesa los datos de los diarios, obtiene coordenadas para cada destino y crea los marcadores
    async function crearMarcadores() {
        const promesaspeticiones = [];

        // Itera sobre cada diario en los datos recibidos
        for (const diarioItem of diariosData) {

            // Inicializa un array vacío para los marcadores de este diario específico
            marcadoresPorDiarioId[diarioItem.id] = [];

            if (diarioItem.destinos && diarioItem.destinos.length > 0) {
                for (const destino of diarioItem.destinos) {
                    if (destino.ubicacion) {
                        // Crea una promesa para la petición fetch
                        // Nominatim es un servicio de geocodificación para OpenStreetMap
                        // encodeURIComponent asegura que la URL sea válida, escapando caracteres especiales
                        // limit=1 pide solo el primer resultado y addressdetails=1 pide más detalles de la dirección
                        const fetchPromesa = fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(destino.ubicacion)}&format=json&limit=1&addressdetails=1`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`La petición a Nominatim falló para ${destino.ubicacion} con estado ${response.status}`);
                                }
                                return response.json(); // Convierte la respuesta a JSON
                            })
                            .then(data => {
                                // Comprueba si Nominatim devolvió algún resultado
                                if (data.length > 0) {
                                    const lat = parseFloat(data[0].lat);
                                    const lon = parseFloat(data[0].lon);

                                    const contenidoPopup = `
                                        <div class="p-2 bg-white rounded shadow-sm" style="min-width: 200px; max-width: 280px;">
                                            <h4 class="text-md font-semibold text-indigo-700 mb-1">
                                                ${destino.nombre_destino || 'Destino'}
                                            </h4>
                                            <p class="text-xs text-gray-500 mb-2">${destino.ubicacion}</p>
                                            <hr class="my-1">
                                            <p class="text-xs text-gray-700 mb-0.5"><strong>Diario:</strong>
                                                ${diarioItem.titulo}
                                            </p>
                                            ${destino.descripcion ? `<p class="text-xs text-gray-600 mt-1">${destino.descripcion}</p>` : '<p class="text-xs text-gray-500 mt-1 italic">Sin descripción para este destino.</p>'}
                                        </div>`;

                                    // Crea un marcador Leaflet con las coordenadas y el popup
                                    const marker = L.marker([lat, lon]).bindPopup(contenidoPopup);

                                    todosLosMarcadores.push(marker);
                                    marcadoresPorDiarioId[diarioItem.id].push(marker);

                                    // Agrupa por nombre de ubicación
                                    if (!marcadoresPorUbicacion[destino.ubicacion]) {
                                        marcadoresPorUbicacion[destino.ubicacion] = [];
                                    }

                                    marcadoresPorUbicacion[destino.ubicacion].push(marker);
                                } else {
                                    console.warn('No hay resultados de geocodificación:', destino.ubicacion);
                                }
                            })
                            .catch(error => console.error('Error en la petición fetch para la ubicación del destino:', destino.ubicacion, error));
                            // Añade la promesa de la petición actual al array de promesa
                            promesaspeticiones.push(fetchPromesa);
                    }
                }
            }
        }

        // Espera a que todas las promesas de peticiones (geocodificación) se resuelvan o fallen
        // Promise.allSettled para esperar a todas, sin importar si alguna falla
        await Promise.allSettled(promesaspeticiones);
    }

    function mostrarMarcadores(marcadoresAMostrar) {
        grupoMarcadores.clearLayers();
        if (marcadoresAMostrar && marcadoresAMostrar.length > 0) {
            // Copia de los marcadores para no modificar los originales al distribuirlos
            const marcadoresCopia = marcadoresAMostrar.map(m => {
                const popup = m.getPopup() ? m.getPopup().getContent() : "No hay contenido para el popup";
                return L.marker(m.getLatLng()).bindPopup(popup);
            });

            // Distribuye los marcadores para evitar solapamientos exactos
            const marcadoresDistribuidos = distribuirMarcadores(marcadoresCopia);

            // Añade cada marcador distribuido al grupo de marcadores y al mapa
            marcadoresDistribuidos.forEach(marker => marker.addTo(grupoMarcadores));

            // Si hay marcadores en el grupo, ajusta la vista del mapa para que todos sean visibles
            if (grupoMarcadores.getLayers().length > 0) {
                map.fitBounds(grupoMarcadores.getBounds().pad(0.25));
            } else if (marcadoresAMostrar.length > 0 && marcadoresAMostrar[0]) {
                // si la distribución no resultó en capas pero había marcadores, centra el mapa en el primer marcador
                map.setView(marcadoresAMostrar[0].getLatLng(), 10);
            } else {
                // Si no hay marcadores,muestra una vista por defecto
                map.setView([40.4168, -3.7038], 5);
            }
        } else {
            // Si no se proporcionan marcadores para mostrar, establece la vista por defecto
            map.setView([40.4168, -3.7038], 5);
        }
    }

    // Esta función solucioa el solapamiento de marcadores que están exactamente en las mismas coordenadas
    function distribuirMarcadores(marcadores) {
        // Objeto para indexar marcadores por sus coordenadas (redondeadas para agrupar los muy cercanos)
        const indiceCoordenadas = {};
        marcadores.forEach(marker => {
            // Convierte LatLng a una cadena para usarla como clave. toFixed(6) usa 6 decimales de precisión
            const latLngStr = marker.getLatLng().lat.toFixed(6) + ',' + marker.getLatLng().lng.toFixed(6);

            if (!indiceCoordenadas[latLngStr]) {
                indiceCoordenadas[latLngStr] = [];
            }

            indiceCoordenadas[latLngStr].push(marker);
        });

        const marcadoresDistribuidosFinalmente = [];
        // Itera sobre cada grupo de marcadores que comparten (aprox) las mismas coordenadas
        Object.values(indiceCoordenadas).forEach(grupoCoordenadas => {
            if (grupoCoordenadas.length > 1) {
                grupoCoordenadas.forEach((marker, index) => {
                    const angulo = (index / grupoCoordenadas.length) * 2 * Math.PI;
                    const magnitudDesplazamiento = 0.0002 * Math.sqrt(grupoCoordenadas.length -1) ;

                    let coordenadasOriginales = marker.getLatLng();
                    let nuevaLatitud = coordenadasOriginales.lat + magnitudDesplazamiento * Math.sin(angulo);
                    let nuevaLongitud = coordenadasOriginales.lng + magnitudDesplazamiento * Math.cos(angulo);

                    // Actualiza la posición del marcador
                    marker.setLatLng([nuevaLatitud, nuevaLongitud]);
                    marcadoresDistribuidosFinalmente.push(marker);
                });
            } else {
                marcadoresDistribuidosFinalmente.push(grupoCoordenadas[0]);
            }
        });
        return marcadoresDistribuidosFinalmente;
    }

    // --- Event Listeners ---
    // Manejador de clic a cada elemento de la lista de diarios
    document.querySelectorAll('.diario-item').forEach(item => {
        item.addEventListener('click', () => {
            // Obtiene el ID del diario desde el atributo 'data-diario-id'
            const diarioId = item.dataset.diarioId;
            const marcadoresDelDiario = marcadoresPorDiarioId[diarioId] || [];
            mostrarMarcadores(marcadoresDelDiario);
        });
    });

    // Manejador de clic a cada elemento de la lista de nombres de destinos únicos (ubicaciones)
    document.querySelectorAll('.destino-nombre-item').forEach(item => {
        item.addEventListener('click', () => {
            // Obtiene el nombre de la ubicación desde 'data-destino-nombre'
            const ubicacionNombre = item.dataset.destinoNombre;
            // Obtiene los marcadores asociados a esta ubicación
            const marcadoresDeLaUbicacion = marcadoresPorUbicacion[ubicacionNombre] || [];
            // Muestra solo los marcadores de esta ubicación
            mostrarMarcadores(marcadoresDeLaUbicacion);
        });
    });

    // Añade un manejador de clic al botón "Mostrar Todos los Destinos Visitados"
    document.getElementById('ver-todos').addEventListener('click', () => {
        mostrarMarcadores(todosLosMarcadores);
    });

    // Llama a `crearMarcadores` para procesar los datos y generar todos los marcadores
    // `await` asegura que esperamos a que todas las peticiones de geocodificación terminen
    await crearMarcadores();

    if (todosLosMarcadores.length > 0) {
        mostrarMarcadores(todosLosMarcadores);
    } else {
        // Si no hay marcadores muestra la vista por defecto del mapa
        map.setView([40.4168, -3.7038], 5);
        console.log("No se encontraron destinos con ubicaciones válidas para mostrar en el mapa.");
    }
});

</script>
@endsection
