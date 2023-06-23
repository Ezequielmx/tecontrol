<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asistencia;

class AsistenciaController extends Controller
{
    public function index(){
        return view('admin.asistencias.index');
    }

    public function create(){
        return view('admin.asistencias.create');
    }

    public function edit(Asistencia $asistencia){
        return view('admin.asistencias.edit', compact('asistencia'));
    }
}
