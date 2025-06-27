<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/servicios/json', [App\Http\Controllers\ServicioController::class, 'json'])->name('servicios.json');
});

Auth::routes();


// Partidas por capítulo
Route::get('/partidas/capitulo/{id}', [App\Http\Controllers\PartidaController::class, 'getPartidas'])->middleware('auth');

// Cuentas por fondo
Route::get('/cuentas/fondo/{id}', [App\Http\Controllers\CuentaBancariaController::class, 'getCuentasPorFondo'])->middleware('auth');


// Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Endpoint JSON para el dashboard (datos reales)
Route::get('/dashboard.json', [App\Http\Controllers\HomeController::class, 'json'])->name('dashboard.json');


// Rutas para Viaticos
Route::prefix('viaticos')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\ViaticoController::class, 'index'])->middleware('can:ver viaticos')->name('viaticos.index');
    Route::get('/create', [App\Http\Controllers\ViaticoController::class, 'create'])->middleware('can:crear viaticos')->name('viaticos.create');
    Route::post('/', [App\Http\Controllers\ViaticoController::class, 'store'])->middleware('can:crear viaticos')->name('viaticos.store');
    Route::get('/show/{viatico}', [App\Http\Controllers\ViaticoController::class, 'show'])->middleware('can:ver viaticos')->name('viaticos.show');
    Route::get('/{viatico}/edit', [App\Http\Controllers\ViaticoController::class, 'edit'])->middleware('can:editar viaticos')->name('viaticos.edit');
    Route::put('/{viatico}', [App\Http\Controllers\ViaticoController::class, 'update'])->middleware('can:editar viaticos')->name('viaticos.update');
    Route::delete('/{viatico}', [App\Http\Controllers\ViaticoController::class, 'destroy'])->middleware('can:eliminar viaticos')->name('viaticos.destroy');

    // Rutas para comprobaciones
    Route::get('/{viatico}/comprobaciones', [App\Http\Controllers\ViaticosComprobacionController::class, 'index'])->name('comprobaciones.index')->middleware('can:ver viaticos');
    Route::get('/{viatico}/comprobaciones/create', [App\Http\Controllers\ViaticosComprobacionController::class, 'create'])->name('comprobaciones.create')->middleware('can:crear viaticos');
    Route::post('/{viatico}/comprobaciones', [App\Http\Controllers\ViaticosComprobacionController::class, 'store'])->name('comprobaciones.store')->middleware('can:crear viaticos');
    Route::get('/{viatico}/comprobaciones/{comprobacion}', [App\Http\Controllers\ViaticosComprobacionController::class, 'show'])->name('comprobaciones.show')->middleware('can:ver viaticos');
    Route::get('/{viatico}/comprobaciones/{comprobacion}/edit', [App\Http\Controllers\ViaticosComprobacionController::class, 'edit'])->name('comprobaciones.edit')->middleware('can:editar viaticos');
    Route::put('/{viatico}/comprobaciones/{comprobacion}', [App\Http\Controllers\ViaticosComprobacionController::class, 'update'])->name('comprobaciones.update')->middleware('can:editar viaticos');
    Route::delete('/{viatico}/comprobaciones/{comprobacion}', [App\Http\Controllers\ViaticosComprobacionController::class, 'destroy'])->name('comprobaciones.destroy')->middleware('can:eliminar viaticos');
});


// Rutas para Movimientos
Route::prefix('movimientos')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\MovimientoController::class, 'index'])->middleware('can:ver movimientos')->name('movimientos.index');
    Route::get('/create', [App\Http\Controllers\MovimientoController::class, 'create'])->middleware('can:crear movimientos')->name('movimientos.create');
    Route::post('/', [App\Http\Controllers\MovimientoController::class, 'store'])->middleware('can:crear movimientos')->name('movimientos.store');
    Route::get('/{movimiento}', [App\Http\Controllers\MovimientoController::class, 'show'])->middleware('can:ver movimientos')->name('movimientos.show');
    Route::post('/{movimiento}/alertar', [App\Http\Controllers\MovimientoController::class, 'alertar'])->middleware('can:ver movimientos')->name('movimientos.alertar');
    Route::get('/{movimiento}/edit', [App\Http\Controllers\MovimientoController::class, 'edit'])->middleware('can:editar movimientos')->name('movimientos.edit');
    Route::put('/{movimiento}', [App\Http\Controllers\MovimientoController::class, 'update'])->middleware('can:editar movimientos')->name('movimientos.update');
    Route::delete('/{movimiento}', [App\Http\Controllers\MovimientoController::class, 'destroy'])->middleware('can:eliminar movimientos')->name('movimientos.destroy');
    Route::post('/movimientos/{id}/bloquear', [App\Http\Controllers\MovimientoController::class, 'bloquear'])->middleware('can:eliminar movimientos')->name('movimientos.bloquear');
});


// Rutas para Ministraciones
Route::prefix('ministraciones')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\MinistracionController::class, 'index'])->middleware('can:ver ministraciones')->name('ministraciones.index');
    Route::get('/create', [App\Http\Controllers\MinistracionController::class, 'create'])->middleware('can:crear ministraciones')->name('ministraciones.create');
    Route::post('/', [App\Http\Controllers\MinistracionController::class, 'store'])->middleware('can:crear ministraciones')->name('ministraciones.store');
    Route::get('/{ministracion}', [App\Http\Controllers\MinistracionController::class, 'show'])->middleware('can:ver ministraciones')->name('ministraciones.show');
    Route::get('/{ministracion}/edit', [App\Http\Controllers\MinistracionController::class, 'edit'])->middleware('can:editar ministraciones')->name('ministraciones.edit');
    Route::put('/{ministracion}', [App\Http\Controllers\MinistracionController::class, 'update'])->middleware('can:editar ministraciones')->name('ministraciones.update');
    Route::delete('/{ministracion}', [App\Http\Controllers\MinistracionController::class, 'destroy'])->middleware('can:eliminar ministraciones')->name('ministraciones.destroy');
});

// Rutas para Reportes
Route::prefix('reportes')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\ReporteController::class, 'index'])->middleware('can:ver reportes')->name('reportes.index');
    Route::get('/excel', [App\Http\Controllers\ReporteController::class, 'exportExcel'])->middleware('can:exportar reportes')->name('reportes.excel');
    Route::get('/pdf', [App\Http\Controllers\ReporteController::class, 'exportPdf'])->middleware('can:exportar reportes')->name('reportes.pdf');
    Route::get('/banco', [App\Http\Controllers\ReporteController::class, 'banco'])->middleware('can:ver reportes')->name('reportes.banco.index');
});

// routes/web.php
Route::get('/get-partidas/{id}', [App\Http\Controllers\PartidaController::class, 'getPartidas'])->name('get.partidas');

// Rutas para Transacciones
Route::prefix('transacciones')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\TransaccionController::class, 'index'])->middleware('can:ver transacciones')->name('transacciones.index');
    Route::get('/create', [App\Http\Controllers\TransaccionController::class, 'create'])->middleware('can:crear transacciones')->name('transacciones.create');
    Route::post('/', [App\Http\Controllers\TransaccionController::class, 'store'])->middleware('can:crear transacciones')->name('transacciones.store');
    Route::get('/{transaccion}', [App\Http\Controllers\TransaccionController::class, 'show'])->middleware('can:ver transacciones')->name('transacciones.show');
    Route::get('/{transaccion}/edit', [App\Http\Controllers\TransaccionController::class, 'edit'])->middleware('can:editar transacciones')->name('transacciones.edit');
    Route::put('/{transaccion}', [App\Http\Controllers\TransaccionController::class, 'update'])->middleware('can:editar transacciones')->name('transacciones.update');
    Route::delete('/{transaccion}', [App\Http\Controllers\TransaccionController::class, 'destroy'])->middleware('can:eliminar transacciones')->name('transacciones.destroy');
});

// Rutas para Evidencias
Route::prefix('evidencias')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\EvidenciaController::class, 'index'])->middleware('can:ver evidencias')->name('evidencias.index');
    Route::get('/create', [App\Http\Controllers\EvidenciaController::class, 'create'])->middleware('can:crear evidencias')->name('evidencias.create');
    Route::post('/', [App\Http\Controllers\EvidenciaController::class, 'store'])->middleware('can:crear evidencias')->name('evidencias.store');
    Route::get('/{evidencia}', [App\Http\Controllers\EvidenciaController::class, 'show'])->middleware('can:ver evidencias')->name('evidencias.show');
    Route::get('/{evidencia}/edit', [App\Http\Controllers\EvidenciaController::class, 'edit'])->middleware('can:editar evidencias')->name('evidencias.edit');
    Route::put('/{evidencia}', [App\Http\Controllers\EvidenciaController::class, 'update'])->middleware('can:editar evidencias')->name('evidencias.update');
    Route::delete('/{evidencia}', [App\Http\Controllers\EvidenciaController::class, 'destroy'])->middleware('can:eliminar evidencias')->name('evidencias.destroy');
});

// Rutas para Solicitudes Dev
Route::prefix('solicitudesDev')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\SolicitudDevController::class, 'index'])->middleware('can:ver solicitudesDev')->name('solicitudesDev.index');
    Route::get('/create', [App\Http\Controllers\SolicitudDevController::class, 'create'])->middleware('can:crear solicitudesDev')->name('solicitudesDev.create');
    Route::post('/', [App\Http\Controllers\SolicitudDevController::class, 'store'])->middleware('can:crear solicitudesDev')->name('solicitudesDev.store');
    Route::get('/{solicitudDev}', [App\Http\Controllers\SolicitudDevController::class, 'show'])->middleware('can:ver solicitudesDev')->name('solicitudesDev.show');
    Route::get('/{solicitudDev}/edit', [App\Http\Controllers\SolicitudDevController::class, 'edit'])->middleware('can:editar solicitudesDev')->name('solicitudesDev.edit');
    Route::put('/{solicitudDev}', [App\Http\Controllers\SolicitudDevController::class, 'update'])->middleware('can:editar solicitudesDev')->name('solicitudesDev.update');
    Route::delete('/{solicitudDev}', [App\Http\Controllers\SolicitudDevController::class, 'destroy'])->middleware('can:eliminar solicitudesDev')->name('solicitudesDev.destroy');
});

// Rutas para Areas
Route::prefix('areas')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\AreaController::class, 'index'])->middleware('can:ver areas')->name('areas.index');
    Route::get('/create', [App\Http\Controllers\AreaController::class, 'create'])->middleware('can:crear areas')->name('areas.create');
    Route::post('/', [App\Http\Controllers\AreaController::class, 'store'])->middleware('can:crear areas')->name('areas.store');
    Route::get('/{area}', [App\Http\Controllers\AreaController::class, 'show'])->middleware('can:ver areas')->name('areas.show');
    Route::get('/{area}/edit', [App\Http\Controllers\AreaController::class, 'edit'])->middleware('can:editar areas')->name('areas.edit');
    Route::put('/{area}', [App\Http\Controllers\AreaController::class, 'update'])->middleware('can:editar areas')->name('areas.update');
    Route::delete('/{area}', [App\Http\Controllers\AreaController::class, 'destroy'])->middleware('can:eliminar areas')->name('areas.destroy');
});

// Rutas para Unidad Responsables
Route::prefix('unidad_responsables')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\UnidadResponsableController::class, 'index'])->middleware('can:ver unidad')->name('unidad_responsables.index');
    Route::get('/create', [App\Http\Controllers\UnidadResponsableController::class, 'create'])->middleware('can:crear unidad')->name('unidad_responsables.create');
    Route::post('/', [App\Http\Controllers\UnidadResponsableController::class, 'store'])->middleware('can:crear unidad')->name('unidad_responsables.store');
    Route::get('/{unidad_responsable}', [App\Http\Controllers\UnidadResponsableController::class, 'show'])->middleware('can:ver unidad')->name('unidad_responsables.show');
    Route::get('/{unidad_responsable}/edit', [App\Http\Controllers\UnidadResponsableController::class, 'edit'])->middleware('can:editar unidad')->name('unidad_responsables.edit');
    Route::put('/{unidad_responsable}', [App\Http\Controllers\UnidadResponsableController::class, 'update'])->middleware('can:editar unidad')->name('unidad_responsables.update');
    Route::delete('/{unidad_responsable}', [App\Http\Controllers\UnidadResponsableController::class, 'destroy'])->middleware('can:eliminar unidad')->name('unidad_responsables.destroy');
});

// Rutas para Partidas
Route::prefix('partidas')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\PartidaController::class, 'index'])->middleware('can:ver partidas')->name('partidas.index');
    Route::get('/create', [App\Http\Controllers\PartidaController::class, 'create'])->middleware('can:crear partidas')->name('partidas.create');
    Route::post('/', [App\Http\Controllers\PartidaController::class, 'store'])->middleware('can:crear partidas')->name('partidas.store');
    Route::get('/{partida}', [App\Http\Controllers\PartidaController::class, 'show'])->middleware('can:ver partidas')->name('partidas.show');
    Route::get('/{partida}/edit', [App\Http\Controllers\PartidaController::class, 'edit'])->middleware('can:editar partidas')->name('partidas.edit');
    Route::put('/{partida}', [App\Http\Controllers\PartidaController::class, 'update'])->middleware('can:editar partidas')->name('partidas.update');
    Route::delete('/{partida}', [App\Http\Controllers\PartidaController::class, 'destroy'])->middleware('can:eliminar partidas')->name('partidas.destroy');
});

// Rutas para Capitulos
Route::prefix('capitulos')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\CapituloController::class, 'index'])->middleware('can:ver capitulos')->name('capitulos.index');
    Route::get('/create', [App\Http\Controllers\CapituloController::class, 'create'])->middleware('can:crear capitulos')->name('capitulos.create');
    Route::post('/', [App\Http\Controllers\CapituloController::class, 'store'])->middleware('can:crear capitulos')->name('capitulos.store');
    Route::get('/{capitulo}', [App\Http\Controllers\CapituloController::class, 'show'])->middleware('can:ver capitulos')->name('capitulos.show');
    Route::get('/{capitulo}/edit', [App\Http\Controllers\CapituloController::class, 'edit'])->middleware('can:editar capitulos')->name('capitulos.edit');
    Route::put('/{capitulo}', [App\Http\Controllers\CapituloController::class, 'update'])->middleware('can:editar capitulos')->name('capitulos.update');
    Route::delete('/{capitulo}', [App\Http\Controllers\CapituloController::class, 'destroy'])->middleware('can:eliminar capitulos')->name('capitulos.destroy');
});

// Rutas para Cuentas
Route::prefix('cuentas')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\CuentaBancariaController::class, 'index'])->middleware('can:ver cuentas')->name('cuentas');
    Route::get('/create', [App\Http\Controllers\CuentaBancariaController::class, 'create'])->middleware('can:crear cuentas')->name('cuentas.create');
    Route::post('/', [App\Http\Controllers\CuentaBancariaController::class, 'store'])->middleware('can:crear cuentas')->name('cuentas.store');
    Route::get('/{cuenta}', [App\Http\Controllers\CuentaBancariaController::class, 'show'])->middleware('can:ver cuentas')->name('cuentas.show');
    Route::get('/{cuenta}/edit', [App\Http\Controllers\CuentaBancariaController::class, 'edit'])->middleware('can:editar cuentas')->name('cuentas.edit');
    Route::put('/{cuenta}', [App\Http\Controllers\CuentaBancariaController::class, 'update'])->middleware('can:editar cuentas')->name('cuentas.update');
    Route::delete('/{cuenta}', [App\Http\Controllers\CuentaBancariaController::class, 'destroy'])->middleware('can:eliminar cuentas')->name('cuentas.destroy');
});

// Rutas para Fondos
Route::prefix('fondos')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\FondoController::class, 'index'])->middleware('can:ver fondos')->name('fondos.index');
    Route::get('/create', [App\Http\Controllers\FondoController::class, 'create'])->middleware('can:crear fondos')->name('fondos.create');
    Route::post('/', [App\Http\Controllers\FondoController::class, 'store'])->middleware('can:crear fondos')->name('fondos.store');
    Route::get('/{fondo}', [App\Http\Controllers\FondoController::class, 'show'])->middleware('can:ver fondos')->name('fondos.show');
    Route::get('/{fondo}/edit', [App\Http\Controllers\FondoController::class, 'edit'])->middleware('can:editar fondos')->name('fondos.edit');
    Route::put('/{fondo}', [App\Http\Controllers\FondoController::class, 'update'])->middleware('can:editar fondos')->name('fondos.update');
    Route::delete('/{fondo}', [App\Http\Controllers\FondoController::class, 'destroy'])->middleware('can:eliminar fondos')->name('fondos.destroy');
});

// Configuraciones generales
Route::prefix('admin/settings')->middleware('can:ver configuraciones')->group(function () {
    // Configuración general
    Route::get('/', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');

    // Proyecciones
    Route::prefix('proyecciones')->middleware('can:ver proyecciones')->group(function () {
        Route::get('/', [App\Http\Controllers\ProyeccionController::class, 'index'])->name('proyecciones.index');
        Route::get('/create', [App\Http\Controllers\ProyeccionController::class, 'create'])->middleware('can:crear proyecciones')->name('proyecciones.create');
        Route::post('/', [App\Http\Controllers\ProyeccionController::class, 'store'])->middleware('can:crear proyecciones')->name('proyecciones.store');
        Route::get('/{proyeccion}/edit', [App\Http\Controllers\ProyeccionController::class, 'edit'])->middleware('can:editar proyecciones')->name('proyecciones.edit');
        Route::put('/{proyeccion}', [App\Http\Controllers\ProyeccionController::class, 'update'])->middleware('can:editar proyecciones')->name('proyecciones.update');
        Route::delete('/{proyeccion}', [App\Http\Controllers\ProyeccionController::class, 'destroy'])->middleware('can:eliminar proyecciones')->name('proyecciones.destroy');
    });

    // Estadísticas
    Route::prefix('estadisticas')->middleware('can:ver estadisticas')->group(function () {
        Route::get('/', [App\Http\Controllers\EstadisticaController::class, 'index'])->name('estadisticas.index');
        Route::get('/ver/{tipo}', [App\Http\Controllers\EstadisticaController::class, 'ver'])->name('estadisticas.ver');
        Route::get('/descargar/{tipo}', [App\Http\Controllers\EstadisticaController::class, 'descargar'])->name('estadisticas.descargar');
    });


    // Cuentas
    Route::prefix('cuentas')->middleware('can:ver cuentas')->group(function () {
        Route::get('/', [App\Http\Controllers\CuentaBancariaController::class, 'index'])->name('cuentas.index');
        Route::get('/create', [App\Http\Controllers\CuentaBancariaController::class, 'create'])->middleware('can:crear cuentas')->name('cuentas.create');
        Route::post('/', [App\Http\Controllers\CuentaBancariaController::class, 'store'])->middleware('can:crear cuentas')->name('cuentas.store');
        Route::get('/{cuenta}', [App\Http\Controllers\CuentaBancariaController::class, 'show'])->middleware('can:ver cuentas')->name('cuentas.show');
        Route::get('/{cuenta}/edit', [App\Http\Controllers\CuentaBancariaController::class, 'edit'])->middleware('can:editar cuentas')->name('cuentas.edit');
        Route::put('/{cuenta}', [App\Http\Controllers\CuentaBancariaController::class, 'update'])->middleware('can:editar cuentas')->name('cuentas.update');
        Route::delete('/{cuenta}', [App\Http\Controllers\CuentaBancariaController::class, 'destroy'])->middleware('can:eliminar cuentas')->name('cuentas.destroy');
    });

    // Usuarios
    Route::prefix('users')->middleware('can:ver usuarios')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])->middleware('can:crear usuarios')->name('users.create');
        Route::post('/', [App\Http\Controllers\UserController::class, 'store'])->middleware('can:crear usuarios')->name('users.store');
        Route::get('/{user}', [App\Http\Controllers\UserController::class, 'show'])->middleware('can:ver usuarios')->name('users.show');
        Route::get('/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->middleware('can:editar usuarios')->name('users.edit');
        Route::put('/{user}', [App\Http\Controllers\UserController::class, 'update'])->middleware('can:editar usuarios')->name('users.update');
        Route::delete('/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('can:eliminar usuarios')->name('users.destroy');
    });


    // Roles
    Route::prefix('roles')->middleware('can:ver roles')->group(function () {
        Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [App\Http\Controllers\RoleController::class, 'create'])->middleware('can:crear roles')->name('roles.create');
        Route::post('/', [App\Http\Controllers\RoleController::class, 'store'])->middleware('can:crear roles')->name('roles.store');
        Route::get('/{role}', [App\Http\Controllers\RoleController::class, 'show'])->name('roles.show');
        Route::get('/{role}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->middleware('can:editar roles')->name('roles.edit');
        Route::put('/{role}', [App\Http\Controllers\RoleController::class, 'update'])->middleware('can:editar roles')->name('roles.update');
        Route::delete('/{role}', [App\Http\Controllers\RoleController::class, 'destroy'])->middleware('can:eliminar roles')->name('roles.destroy');
        Route::get('/{role}/permissions', [App\Http\Controllers\RoleController::class, 'permissions'])->middleware('can:editar roles')->name('roles.permissions');
        Route::post('/{role}/permissions', [App\Http\Controllers\RoleController::class, 'assignPermissions'])->middleware('can:editar roles')->name('roles.assignPermissions');
    });

    // Asignación Presupuestal
    Route::prefix('asignacion_presupuestal')->middleware('can:ver asignacionpresupuestal')->group(function () {
        Route::get('/', [App\Http\Controllers\AsignacionPresupuestalController::class, 'index'])->name('asignacion_presupuestal.index');
        Route::get('/create', [App\Http\Controllers\AsignacionPresupuestalController::class, 'create'])->middleware('can:crear asignacionpresupuestal')->name('asignacion_presupuestal.create');
        Route::post('/', [App\Http\Controllers\AsignacionPresupuestalController::class, 'store'])->middleware('can:crear asignacionpresupuestal')->name('asignacion_presupuestal.store');
        Route::get('/{asignacion}', [App\Http\Controllers\AsignacionPresupuestalController::class, 'show'])->middleware('can:ver asignacionpresupuestal')->name('asignacion_presupuestal.show');
        Route::get('/{asignacion}/edit', [App\Http\Controllers\AsignacionPresupuestalController::class, 'edit'])->middleware('can:editar asignacionpresupuestal')->name('asignacion_presupuestal.edit');
        Route::put('/{asignacion}', [App\Http\Controllers\AsignacionPresupuestalController::class, 'update'])->middleware('can:editar asignacionpresupuestal')->name('asignacion_presupuestal.update');
        Route::delete('/{asignacion}', [App\Http\Controllers\AsignacionPresupuestalController::class, 'destroy'])->middleware('can:eliminar asignacionpresupuestal')->name('asignacion_presupuestal.destroy');
    });

    // Actividad
    Route::prefix('historial')->middleware('can:ver historial')->group(function () {
        Route::get('/', [App\Http\Controllers\ActivityLogController::class, 'index'])->name('actividades.index');
        Route::get('/{log}', [App\Http\Controllers\ActivityLogController::class, 'show'])->name('actividades.show');
    });

});

Route::get('/prueba-404', function () {
    return response()->view('errors.404', [], 404);
});

