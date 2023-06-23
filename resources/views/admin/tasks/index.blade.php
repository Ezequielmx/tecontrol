@extends('adminlte::page')

@section('title','Calendario')

@section('content')

<div class="card">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="tarea" tabindex="-1" role="dialog" aria-labelledby="Tarea" aria-hidden="true">
    @livewire('admin.task.taskform')
</div>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('admin.css') }}">
@stop
@push('js')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>

<script>

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        var calendar = $('#calendar').fullCalendar();
    })
    /*
    document.addEventListener('DOMContentLoaded', function() {
          const calendarEl = document.getElementById('calendar');

          const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            themeSystem: 'bootstrap5',
            events: @json($events),
            eventOrder: 'linea,title',
            
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridYear,dayGridMonth' // user can switch between the two
            },
            
            businessHours: {
                // days of week. an array of zero-based day of week integers (0=Sunday)
                daysOfWeek: [ 1, 2, 3, 4, 5 ] // Monday - Thursday
            },

            dateClick: function(info) {
                Livewire.emit('setFecha', info.dateStr);
                $('#tarea').modal('show');
            },


          });

          calendar.render();
          
          Livewire.on('cerrarModal', function() {
            $('#tarea').modal('hide');
            });
        });*/
  
</script>
@endpush