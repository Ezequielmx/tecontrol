@extends('adminlte::page')

@section('title', 'Tablero')

@section('content_header')
<h1>Tablero</h1>
@stop

@section('content')
@livewire('admin.tablero')
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('admin.css') }}">
@stop

@section('js')


@stop