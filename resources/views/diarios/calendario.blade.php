@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-3xl text-center mb-4">Calendario de Diarios</h2>

        <!-- Contenedor del calendario -->
        <div id="calendario"></div>
    </div>

    <!-- Cargar jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Cargar Moment.js (Requerido para FullCalendar 3.x) -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <!-- Cargar FullCalendar 3.x -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializar FullCalendar
            $('#calendario').fullCalendar({
                 locale: 'es',         // idioma español
        firstDay: 1,   
                aspectRatio: 2.5,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: "{{ route('calendario.eventos') }}",
                eventClick: function(info) {
                    // Mostrar información del evento (diario) y destinos relacionados
                    alert( info.title + "\n" + info.description);
                },
            });
        });
    </script>
@endsection
