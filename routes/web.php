<?php

use App\Http\Controllers\GuiasRemisionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ConductoresController;
use App\Http\Controllers\RevisionDeGuiasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\VistasIntranetController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Rutas para la web Publicas
//Rutas get
Route::get('/login', [VistasIntranetController::class, 'vistalogin'])->name('vistalogin');
Route::middleware(['auth', 'role:administrador,superadmin'])->group(function () {
    Route::get('/dashboard', [VistasIntranetController::class, 'vistadashboard'])->name('vistadashboard');

    //usuarios
    Route::get('/usuarios', [VistasIntranetController::class, 'vistausuarios'])->name('vistausuarios');
    Route::post('/verificarusuario', [UsuariosController::class, 'verificarusuario'])->name('api.verificarusuario');
    Route::post('/estadousuario', [UsuariosController::class, 'eliminarusuario'])->name('api.eliminarusuario');

    //conductores
    Route::get('/conductor', [VistasIntranetController::class, 'vistaconductor'])->name('vistaconductor');
    Route::post('/mantenimientoconductor', [ConductoresController::class, 'mantenimientoconductor'])->name('api.mantenimientoconductor');
    //transporte

    //vehiculo
    Route::get('/vehiculo', [VistasIntranetController::class, 'vistavehiculo'])->name('vistavehiculo');
    Route::post('/mantenimientovehiculo', [VehiculoController::class, 'mantenimientovehiculo'])->name('api.mantenimientovehiculo');
    Route::post('/estadovehiculo', [VehiculoController::class, 'eliminarvehiculo'])->name('api.eliminarvehiculo');
    //productos
    Route::get('/producto', [VistasIntranetController::class, 'vistaproducto'])->name('vistaproducto');
    Route::post('/registrarproducto', [ProductoController::class, 'registrarproducto'])->name('api.registrarproducto');
    Route::post('/eliminarproducto', [ProductoController::class, 'eliminarproducto'])->name('api.eliminarproducto');
});


//Vista para prevencionista
Route::middleware(['auth', 'role:prevencionista,superadmin'])->group(function () {
    Route::get('/guiasremision', [VistasIntranetController::class, 'vistaguiasderemision'])->name('vistaguiasderemision');
    Route::get('/vistadetalleguia/{idguia?}', [VistasIntranetController::class, 'vistadetalleguia'])->name('vistadetalleguia');
    Route::get('/crearguiaremision', [VistasIntranetController::class, 'vistaaddguiaremision'])->name('vistaaddguiaremision');
    Route::post('/registrarguiaremision', [GuiasRemisionController::class, 'registrarguiaremision'])->name('api.registrarguiaremision');
    Route::post('/estadoguia/{id}', [GuiasRemisionController::class, 'eliminarguia'])->name('api.eliminarguia');
    Route::post('/registrarvalidacionguia', [RevisionDeGuiasController::class, 'registrarguiarevicion_validacion'])->name('registrarguiarevicion_validacion');
    Route::get('/conductores-por-empresa/{idtransportista}', [ConductoresController::class, 'getConductoresPorEmpresa']);
    Route::get('/revisionguias/{idguia?}', [VistasIntranetController::class, 'vistarevisionguias'])->name('vistarevisionguias');

    Route::get('/empresa/{id}', function($id) {
    $empresa = \App\Models\TipoEmpresa::find($id);

    if (!$empresa) {
        return response()->json(null, 404);
    }

    return response()->json([
        'direccion' => $empresa->direccion,
        'provincia' => $empresa->provincia,
        'departamento' => $empresa->departamento,
        'ruc' => $empresa->ruc,
        'ubigeo' => $empresa->ubigeo,
        'codigoestablecimiento' => $empresa->codigoestablecimiento,
    ]);
    });

    //generar el reporte
    Route::get('/guias/{id}/pdf', [ReporteController::class, 'generarPdfGuia'])->name('guias.pdf');
    Route::post("/buscarproductocodigo", [ProductoController::class, 'buscarproductocodigo'])->name('api.buscarproductocodigo');
});

Route::post('/iniciarsesion', [UsuariosController::class, 'validarLogin'])->name('api.validarLogin');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return response()->json(['success' => true]);
})->name('logout');
