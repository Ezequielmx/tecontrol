<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    //if role is admin return route admin, else return route user

    if(Auth::user()->hasRole('Admin')){
        return redirect()->route('admin.home');
    }elseif(Auth::user()->hasRole('Cliente')){
        return view('cliente');
    }elseif(Auth::user()->hasRole('Usuario Administrativo')){
        return redirect()->route('admin.asistencias.index');
    }elseif(Auth::user()->hasRole('Usuario Certificados')){
        return redirect()->route('admin.certificados.index');
    }else{
        return redirect()->route('login');
    }
});


