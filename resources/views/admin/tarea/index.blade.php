@extends('adminlte::page')

@section('title', 'Tareas')

@section('content')
<div class="row">
    <div class="col-md-5 p-3" style="background-color: #fffbf4; margin-left: -0.5rem">
        @livewire('admin.tareaspers')
    </div>
    <div class="col-md-7 p-3" style="background-color: #e9f6ff;">
        @livewire('admin.tareas')
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('admin.css') }}">
@stop

@section('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@stop