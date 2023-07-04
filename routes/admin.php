<?php

use App\Http\Controllers\Admin\AsistenciaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\GeneralController;   
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\CertificadoController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\DivisaController;
use App\Http\Controllers\Admin\CotizacionController;
use App\Http\Controllers\Admin\DocController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\FullCalenderController;

route::get('', [HomeController::class, 'index'])->name('admin.home');
route::resource('generales', GeneralController::class)->names('admin.generales');
route::resource('categorias', CategoriaController::class)->names('admin.categories');
route::resource('productos', ProductoController::class)->names('admin.products');
route::resource('clientes', ClienteController::class)->names('admin.clients');
route::resource('proveedores', ProveedorController::class)->names('admin.suppliers');
route::resource('documentos', DocController::class)->names('admin.docs');
route::resource('tareas', TaskController::class)->names('admin.tasks');
route::resource('mails', MailController::class)->names('admin.mails');
route::resource('divisas', DivisaController::class)->names('admin.cotizaciondiv');
route::resource('cotizaciones', CotizacionController::class)->names('admin.cotizaciones');
Route::get('cotizaciones/{cotizacion}/print', [CotizacionController::class, 'print'])->name('admin.cotizaciones.print');
route::resource('asistencias', AsistenciaController::class)->names('admin.asistencias');
route::resource('certificados', CertificadoController::class)->names('admin.certificados');
route::resource('usuarios', UsuarioController::class)->names('admin.usuarios');

route::resource('pedidos', PedidoController::class)->names('admin.pedidos');
route::resource('stocks', StockController::class)->names('admin.stocks');

Route::get('full-calender', [FullCalenderController::class, 'index']);
Route::post('full-calender/action', [FullCalenderController::class, 'action']);
