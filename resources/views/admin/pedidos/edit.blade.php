@extends('adminlte::page')

@section('title', 'Editar Pedido')

@section('content_header')
<h1>&nbsp;Editar Pedido</h1>
@endsection

@section('content')
@livewire('admin.pedido.edit', ['pedido' => $pedido])
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('admin.css') }}">
@endsection

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    Livewire.on('deleteDet', detalle_id =>{
            Swal.fire({
                title: 'Está seguro que desea eliminar este Producto?',
                text: "No se puede revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Si. Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteDetalle', detalle_id);
                    Swal.fire(
                    'Eliminado!',
                    'El producto ha sido eliminado.',
                    'success'
                    )
                }
            })
        });

        Livewire.on('guardado', () =>{
            Swal.fire(
                'Cambios Guardados!',
                'El pedido ha sido actualizado.',
                'success'
            )
        });

</script>
@endsection
