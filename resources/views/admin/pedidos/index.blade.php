@extends('adminlte::page')

@section('title', 'Pedidos')

@section('content_header')
<h1>Pedidos a Proveedores</h1>
@stop

@section('content')
@livewire('admin.pedido.index')
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('admin.css') }}">
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    Livewire.on('deletePed', pedido_id =>{
            Swal.fire({
                title: 'Está seguro que desea eliminar este Pedido?',
                text: "No se puede revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Si. Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deletePedido', pedido_id);
                    Swal.fire(
                    'Eliminado!',
                    'El pedido ha sido eliminado.',
                    'success'
                    )
                }
            })
        });

</script>
@endsection
