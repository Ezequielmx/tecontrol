@extends('adminlte::page')

@section('title', 'Clientes')

@section('content')
<br>
<div class="row">
    <div class="col-md-4">
        @livewire('clients-table')
    </div>
    <div class="col-md-8">
        @livewire('edit-clients-form')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos de contacto</h3>
            </div>
            <div class="card-body">
                @livewire('clients-contacts-table')
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('admin.css') }}">
@endsection

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection