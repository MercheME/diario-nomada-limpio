@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto py-10 px-4">
    <h1 class="text-gray-800 text-6xl mt-4 text-center mb-6"><span class="italic text-violet-400 thin-underline underline-offset-6"> Mapa</span> de Tus Diarios de Viajes</h1>
    <div class="text-center mb-6">
        <p class="text-gray-700 text-lg leading-relaxed">
            En esta sección, podrás ver todos los <span class="italic text-violet-600">destinos</span> de tus diarios ubicados geográficamente. Haz clic en cualquier <span class="italic text-violet-600">marcador</span> del mapa para conocer los <span class="italic text-violet-600">detalles</span> de ese lugar y el diario al que pertenece.
        </p>
        <p>¡Disfruta explorando tus <span class="italic text-violet-600">recuerdos de viaje</span> de una forma más visual!</p>
    </div>

    <div id="map" class="w-full h-[400px] md:h-[600px] rounded-sm shadow-lg border border-gray-200 mb-6"></div>

    <div class="text-center mb-8">
        <button id="ver-todos" class="cursor-pointer inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-sm text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mx-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            Todos los Destinos Visitados
        </button>
    </div>

    <div class="grid grid-cols-1 gap-2">
        <div>
            <h1 class="text-gray-800 text-4xl mt-4 mb-2"><span class="italic text-violet-400 thin-underline underline-offset-6"> Diarios</span> y sus rutas</h1>
            <p class="text-gray-700 text-lg leading-relaxed">
                Selecciona un diario para ver todos los destinos que has visitado durante ese viaje.
            </p>
            <div class="block text-sm font-medium text-gray-600 mb-6 my-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-5 mr-2 text-gray-500 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <pre class="text-xs"> Haz clic en cualquier marcador del mapa para conocer más detalles</pre>
            </div>
            <div id="diarios-list" class="space-y-1 max-h-72 overflow-y-auto border border-gray-200 p-3 rounded-sm bg-white shadow-sm my-5">
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

    <div class="grid grid-cols-1 gap-2">
        <div>
            <h1 class="text-gray-800 text-4xl mt-4 mb-2"><span class="italic text-violet-400 thin-underline underline-offset-6"> Ubicaciones</span> de cada <span class="italic text-violet-400 thin-underline underline-offset-6">destino</span> visitado</h1>
            <p class="text-gray-700 text-lg leading-relaxed mb-6 ">
                Selecciona una ubicación para ver los diarios asociados a esa ubicación.
            </p>
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
            <div id="destinos-unicos-list" class="space-y-1 max-h-72 overflow-y-auto border border-gray-200 p-3 rounded-sm bg-white shadow-sm my-5">
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

</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', async () => {

    const diariosData = @json($diarios);

    const map = L.map('map').setView([40.4168, -3.7038], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const todosLosMarcadores = [];

    const marcadoresPorUbicacion = {};

    const marcadoresPorDiarioId = {};
    // grupo de características de Leaflet contendrá todos los marcadores
    const grupoMarcadores = L.featureGroup().addTo(map);

    // Función asíncrona que procesa los datos de los diarios, obtiene coordenadas para cada destino y crea los marcadores
    async function crearMarcadores() {
        const promesaspeticiones = [];

        for (const diarioItem of diariosData) {

            // Inicializa un array vacío para los marcadores de este diario específico
            marcadoresPorDiarioId[diarioItem.id] = [];

            if (diarioItem.destinos && diarioItem.destinos.length > 0) {
                for (const destino of diarioItem.destinos) {
                    if (destino.ubicacion) {
                        // Crea una promesa para la petición fetch
                        // encodeURIComponent asegura que la URL sea válida, escapando caracteres especiales
                        // limit=1 pide solo el primer resultado y addressdetails=1 pide más detalles de la dirección
                        const fetchPromesa = fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(destino.ubicacion)}&format=json&limit=1&addressdetails=1`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`La petición a Nominatim falló para ${destino.ubicacion} con estado ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {

                                if (data.length > 0) {
                                    const lat = parseFloat(data[0].lat);
                                    const lon = parseFloat(data[0].lon);

                                    const contenidoPopup = `
                                        <div class="p-2 " style="min-width: 200px; max-width: 280px;">
                                            <h4 class="text-md font-semibold text-indigo-700 mb-1">
                                                ${destino.nombre_destino || 'Destino'}
                                            </h4>
                                            <p class="text-xs text-gray-500 mb-2">${destino.ubicacion}</p>
                                            <hr class="my-1 text-gray-200">
                                            <p class="text-xs text-gray-700 mb-0.5"><strong>Diario:</strong>
                                                ${diarioItem.titulo}
                                            </p>
                                        </div>
                                    `;

                                    const marker = L.marker([lat, lon]).bindPopup(contenidoPopup);

                                    todosLosMarcadores.push(marker);
                                    marcadoresPorDiarioId[diarioItem.id].push(marker);

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
                // Si no hay marcadores
                map.setView([40.4168, -3.7038], 5);
            }
        } else {
            // Si no se proporcionan marcadores para mostrar
            map.setView([40.4168, -3.7038], 5); // vista por defexto
        }
    }

    // Esta función solucioa el solapamiento de marcadores que están exactamente en las mismas coordenadas
    function distribuirMarcadores(marcadores) {

        const indiceCoordenadas = {};
        marcadores.forEach(marker => {
            // Convierte LatLng a una cadena para usarla como clave
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

    // Eventos
    // Manejador de clic a cada elemento de la lista de diarios
    document.querySelectorAll('.diario-item').forEach(item => {
        item.addEventListener('click', () => {
            // Obtiene el ID del diario desde el atributo 'data-diario-id'
            const diarioId = item.dataset.diarioId;
            const marcadoresDelDiario = marcadoresPorDiarioId[diarioId] || [];
            mostrarMarcadores(marcadoresDelDiario);
        });
    });

    // Manejador de clic a cada elemento de la lista de nombres de destinos únicos
    document.querySelectorAll('.destino-nombre-item').forEach(item => {
        item.addEventListener('click', () => {

            // Obtiene el nombre de la ubicación desde 'data-destino-nombre'
            const ubicacionNombre = item.dataset.destinoNombre;

            // Obtiene los marcadores asociados a esta ubicación
            const marcadoresDeLaUbicacion = marcadoresPorUbicacion[ubicacionNombre] || [];

            mostrarMarcadores(marcadoresDeLaUbicacion);
        });
    });

    // manejador de clic a "Mostrar Todos los Destinos Visitados"
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
