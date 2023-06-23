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
@stop

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection