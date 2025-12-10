@extends('adminlte::page')
@livewireScripts
@livewireStyles

@section('title', 'Pedidos')

@section('content_header')
<h1>&nbsp;Nuevo Pedido</h1>
@stop

@section('content')
@livewire('admin.pedido.create')
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('admin.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@stop

@livewireScripts
