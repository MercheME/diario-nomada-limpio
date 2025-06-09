@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">

@push('styles')
<style>
    /* Estilo personalizado para el input de Flatpickr */
    .flatpickr-alt.form-input {
        display: block;
        width: 100%;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        color: #1f2937;
        background-color: #fff;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<section class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
    <h1 class="text-3xl sm:text-4xl font-playfair font-bold italic text-gray-700 mb-8 text-center">
        <span class="italic text-violet-400 thin-underline underline-offset-6">Crea</span> tu Diario de Viaje
    </h1>

    <div class="my-8 p-6 bg-violet-50 rounded-md border border-violet-200 text-gray-700">
        <p class="text-base md:text-lg mb-2 text-center md:text-left">
            <strong>Comienza</strong> tu diario de viajes con lo más básico: el título, la fecha del viaje, una imágen principal y el estado del viaje.
        </p>
        <p class="text-base md:text-lg mt-3 font-medium text-gray-600 text-center md:text-left">
           Una vez que tengas creado lo esencial, podrás editar cada diario para añadir mucha más información: desde los destinos explorados y tus reflexiones personales hasta las experiencias inolvidables y las anécdotas que hacen único cada viaje.
        </p>
    </div>

    <form action="{{ route('diarios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Título --}}
        <div>
            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título del Diario</label>
            <input type="text" name="titulo" id="titulo" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm" value="{{ old('titulo') }}" required>
            @error('titulo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Fechas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                    value="{{ old('fecha_inicio') }}" required>
                    @error('fecha_inicio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="fecha_final" class="block text-sm font-medium text-gray-700 mb-1">Fecha Final</label>
                <input type="date" name="fecha_final" id="fecha_final"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm"
                       value="{{ old('fecha_final') }}" required>
                <span id="error_fecha_final" class="text-red-600 text-xs block mt-1"></span>
            </div>
        </div>
        <p class="block text-sm font-medium text-gray-600 mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-5 mr-2 text-orange-600 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <span class="text-orange-600">Para elegir las fechas ten en cuenta que las fechas que coincidan con otros calendarios ya creados no estarán disponibles</span>
        </p>

        <span id="error_rango_fechas" class="text-red-600 text-xs block mt-1"></span>


        {{-- Imagen principal --}}
        <div>
            <label for="imagen_principal" class="block text-sm font-medium text-gray-700 mb-6">
                Imagen principal
                <span class="ml-2 px-2 py-0.5 bg-gray-200 text-gray-600 text-xs font-medium rounded-md">OPCIONAL</span>
            </label>
            <input type="file" name="imagen_principal" id="imagen_principal" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
            @error('imagen_principal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Estado --}}
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
            <select name="estado" id="estado" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-violet-500 focus:border-violet-500 sm:text-sm">
                <option value="planificado" {{ old('estado', 'planificado') == 'planificado' ? 'selected' : '' }}>Planificado</option>
                <option value="en_curso" {{ old('estado') == 'en_curso' ? 'selected' : '' }}>En curso</option>
                <option value="realizado" {{ old('estado') == 'realizado' ? 'selected' : '' }}>Realizado</option>
            </select>
            @error('estado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button type="submit" id="submitButton" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                Guardar Diario
            </button>
        </div>
    </form>
</section>
@endsection


@push('scripts')
{{-- Flatpickr desde jsdelivr --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
{{-- Alternativamente, desde unpkg si prefieres:
<script src="https://unpkg.com/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://unpkg.com/flatpickr/dist/l10n/es.js"></script>
--}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fechaInicioElem = document.getElementById('fecha_inicio');
    const fechaFinalElem = document.getElementById('fecha_final');

    if (!fechaInicioElem || !fechaFinalElem) {
        console.error("Inputs de fecha no encontrados. Flatpickr no se inicializará.");
        return;
    }

    let fpInicioInstance = null;
    let fpFinalInstance = null;
    const urlFechasOcupadas = "{{ route('diarios.fechasOcupadas') }}";

    // Imprime la URL para asegurarte de que es la correcta
    console.log("Flatpickr - URL para fetch:", urlFechasOcupadas);

    fetch(urlFechasOcupadas, {
        method: 'GET', // Aunque GET es el default, ser explícito no hace daño
        credentials: 'include', // ¡MUY IMPORTANTE! Asegura que las cookies de sesión se envíen
        headers: {
            'Accept': 'application/json', // Informa al servidor que esperas JSON
            'X-Requested-With': 'XMLHttpRequest', // Estándar para identificar peticiones AJAX
            // Para peticiones GET, X-CSRF-TOKEN no suele ser necesario si usas sesiones/cookies
            // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => {
        console.log("Flatpickr - Respuesta del fetch recibida. Status:", response.status, "OK:", response.ok);
        if (!response.ok) {
            // Intenta leer el cuerpo de la respuesta si no es OK, podría dar más pistas
            return response.text().then(text => {
                console.error("Flatpickr - Respuesta de error del fetch (texto):", text);
                throw new Error('Error al cargar fechas ocupadas: ' + response.status + " (" + response.statusText + ")");
            });
        }
        return response.json(); // Esto fallará si la respuesta no es JSON válido
    })
    .then(rangosOcupados => {
        console.log("Flatpickr - Rangos Ocupados recibidos:", rangosOcupados);

        const configFlatpickrComun = {
            altInput: true,
            altFormat: "j F, Y",
            dateFormat: "Y-m-d",
            locale: "es",
            disable: rangosOcupados,
            allowInput: false,
        };

        fpInicioInstance = flatpickr(fechaInicioElem, {
            ...configFlatpickrComun,
            onChange: function(selectedDates, dateStr, instance) {
                if (fpFinalInstance) {
                    fpFinalInstance.set('minDate', dateStr);
                    if (fpFinalInstance.selectedDates.length > 0 && new Date(fpFinalInstance.selectedDates[0]) < new Date(dateStr)) {
                        fpFinalInstance.clear();
                    }
                }
            }
        });

        fpFinalInstance = flatpickr(fechaFinalElem, {
            ...configFlatpickrComun,
        });

        const valorInicialFechaInicio = fechaInicioElem.value;
        if (valorInicialFechaInicio && fpFinalInstance) {
            fpFinalInstance.set('minDate', valorInicialFechaInicio);
        }
    })
    .catch(error => {
        console.error("Flatpickr - Error en la cadena fetch o procesamiento:", error);
        // Fallback: Inicializar Flatpickr sin fechas deshabilitadas
        const configBasica = { locale: "es", dateFormat: "Y-m-d", altInput: true, altFormat: "j F, Y", allowInput: false };
        if(fpInicioInstance) fpInicioInstance.destroy(); // Destruir instancia previa si existe
        if(fpFinalInstance) fpFinalInstance.destroy();

        fpInicioInstance = flatpickr(fechaInicioElem, {
            ...configBasica,
            onChange: function(selectedDates, dateStr, instance) {
                if (fpFinalInstance) fpFinalInstance.set('minDate', dateStr);
            }
        });
        fpFinalInstance = flatpickr(fechaFinalElem, configBasica);
        const valorInicialFechaInicio = fechaInicioElem.value;
        if (valorInicialFechaInicio && fpFinalInstance) {
            fpFinalInstance.set('minDate', valorInicialFechaInicio);
        }
    });
});
</script>
@endpush
