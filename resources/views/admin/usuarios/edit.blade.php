@extends('adminlte::page')

@section('title','Estrella del Plata')

@section('content')
    <h1 style="padding:7px"><i class="fas fa-book-open"></i>&nbsp;&nbsp;Editar Usuario</h1>
    <div class="card">
        <div class="card-body">

            {!! Form::model($user, ['route' => ['admin.usuarios.update', $user], 'method' => 'put']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Nombre') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Nombre']) !!}
                
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el email']) !!}
                
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('pass', 'Contraseña') !!}
                    {!! Form::text('pass', null, ['class' => 'form-control', 'placeholder' => 'Nueva contraseña']) !!}
                    <p>Longitud mínima: 8 caracteres</p>
                    @error('pass')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <p>Roles</p>
                    @foreach ($roles as $role)
                        <div>
                            <label>
                                {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="form-group" id="cliente-select" style="display: none;">
                    {!! Form::label('client_id', 'Cliente') !!}
                    {!! Form::select('client_id', $clientes, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un cliente']) !!}
                    @error('cliente_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.usuarios.index') }}"  class="btn btn-secondary">Cancelar</a>
        {!! Form::close() !!}
        </div>
    </div>

@stop

@section('css')

    <link rel="stylesheet" href="/css/admin.css">

@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var clienteSelect = $('#cliente-select');
        var clienteCheckbox = $('input[name="roles[]"][value="6"]');

        function toggleClienteSelect() {
            if (clienteCheckbox.is(':checked')) {
                clienteSelect.show();
            } else {
                clienteSelect.hide();
            }
        }

        clienteCheckbox.on('change', toggleClienteSelect);

        // Verificar el estado inicial
        toggleClienteSelect();
    });
</script>
@stop