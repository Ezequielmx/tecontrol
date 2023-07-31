@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
<h1>Productos</h1>
@stop

@section('content')
@livewire('products-table')
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('admin.css') }}">
@stop