<?php

use App\Http\Controllers\Admin\AsistenciaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\CertificadoController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\DivisaController;
use App\Http\Controllers\Admin\CotizacionController;
use App\Http\Controllers\Admin\DocController;
use App\Http\Controllers\Admin\PatroneController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UsuarioclienteController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\FullCalenderController;

route::get('', [HomeController::class, 'index'])->name('admin.home')->middleware('can:admin.home');

route::resource('categorias', CategoriaController::class)->names('admin.categories')->middleware('can:admin.categorias.index');
route::resource('productos', ProductoController::class)->names('admin.products')->middleware('can:admin.productos.index');
route::resource('clientes', ClienteController::class)->names('admin.clients')->middleware('can:admin.clientes.index');
route::resource('proveedores', ProveedorController::class)->names('admin.suppliers')->middleware('can:admin.proveedores.index');
route::resource('documentos', DocController::class)->names('admin.docs')->middleware('can:admin.documentos');

route::resource('tareas', TaskController::class)->names('admin.tasks');
route::resource('mails', MailController::class)->names('admin.mails');

route::resource('cotizaciones', CotizacionController::class)->names('admin.cotizaciones')->middleware('can:admin.cotizaciones.index');
Route::get('cotizaciones/{cotizacion}/print', [CotizacionController::class, 'print'])->name('admin.cotizaciones.print')->middleware('can:admin.cotizaciones.index');
route::resource('asistencias', AsistenciaController::class)->names('admin.asistencias')->middleware('can:admin.asistencias.index');
route::resource('certificados', CertificadoController::class)->names('admin.certificados')->middleware('can:admin.certificados');
route::resource('usuarios', UsuarioController::class)->names('admin.usuarios')->middleware('can:admin.usuarios');
route::resource('usuarioscliente', UsuarioclienteController::class)->names('admin.usuarioscliente')->middleware('can:admin.usuarioscliente');
route::resource('patrones', PatroneController::class)->names('admin.patrones')->middleware('can:patrones');


route::resource('pedidos', PedidoController::class)->names('admin.pedidos');
route::resource('stocks', StockController::class)->names('admin.stocks');

Route::get('full-calender', [FullCalenderController::class, 'index']);
Route::post('full-calender/action', [FullCalenderController::class, 'action']);
