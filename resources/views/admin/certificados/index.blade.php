@extends('adminlte::page')

@section('title', 'Certificados')

@section('content_header')
<h1>Certificados</h1>
@stop

@section('content')
@livewire('admin.certificado.index')
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('admin.css') }}">
<style>
    .form-control {
        font-size: inherit;
    }

    .custom-file-input {
        position: relative;
        overflow: hidden;
        display: inline-block;
        opacity: 1;
        height: auto;
    }

    .custom-file-input input[type="file"] {
        position: absolute;
        left: -9999px;
    }

    .custom-file-input .btn {
        background-color: #4CAF50;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .custom-file-input .btn:hover {
        background-color: #45a049;
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection