<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\GuiasRemisionController;
use App\Http\Controllers\VistasIntranetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Rutas para la web Publicas
//Rutas get
Route::get('/login', [VistasIntranetController::class, 'vistalogin'])->name('vistalogin');
Route::get('/dashboard', [VistasIntranetController::class, 'vistadashboard'])->name('vistadashboard');
//usuarios
Route::get('/usuarios', [VistasIntranetController::class, 'vistausuarios'])->name('vistausuarios');
//vehiculo
Route::get('/vehiculo', [VistasIntranetController::class, 'vistavehiculo'])->name('vistavehiculo');
Route::post('/mantenimientovehiculo', [VehiculoController::class, 'mantenimientovehiculo'])->name('api.mantenimientovehiculo');
Route::post('/estadovehiculo', [VehiculoController::class, 'eliminarvehiculo'])->name('api.eliminarvehiculo');
//conductores
Route::get('/conductores', [VistasIntranetController::class, 'vistaconductores'])->name('vistaconductores');
//productos
Route::get('/producto', [VistasIntranetController::class, 'vistaproducto'])->name('vistaproducto');
Route::post('/registrarproducto', [ProductoController::class, 'registrarProducto'])->name('api.registrarProducto');
Route::post('/eliminarproducto', [ProductoController::class, 'eliminarProducto'])->name('api.eliminarProducto');
//guias
Route::get('/guiasremision', [VistasIntranetController::class, 'vistaguiasderemision'])->name('vistaguiasderemision');
Route::post('/registrarguiaremision', [GuiasRemisionController::class, 'registrarGuiaRemision'])->name('registrarGuiaRemision');
