@extends('adminlte::page')

@section('title', 'Asistencias')

@section('content_header')
<h1>Asistencias</h1>
@stop

@section('content')
@livewire('admin.asistencia.index')
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('admin.css') }}">
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    Livewire.on('deleteAsis', asistencia_id =>{
            Swal.fire({
                title: 'Está seguro que desea eliminar esta Asistencia?',
                text: "No se puede revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Si. Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteAsistencia', asistencia_id);
                    Swal.fire(
                    'Eliminada!',
                    'La asistencia ha sido eliminada.',
                    'success'
                    )
                }
            })  
        });
    
</script>
@endsection