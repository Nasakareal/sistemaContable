<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/servicios/json', [App\Http\Controllers\ServicioController::class, 'json'])->name('servicios.json');
});

Auth::routes();

// Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Endpoint JSON para el dashboard (datos reales)
Route::get('/dashboard.json', [App\Http\Controllers\HomeController::class, 'json'])->name('dashboard.json');

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

    // Actividad
    Route::prefix('actividad')->middleware('can:ver actividades')->group(function () {
        Route::get('/', [App\Http\Controllers\ActividadController::class, 'index'])->name('actividades.index');
        Route::get('/actividad', [App\Http\Controllers\ActividadController::class, 'create'])->middleware('can:crear actividades')->name('actividades.create');
        Route::post('/', [App\Http\Controllers\ActividadController::class, 'store'])->middleware('can:crear actividades')->name('actividades.store');
        Route::get('/{actividad}', [App\Http\Controllers\ActividadController::class, 'show'])->middleware('can:ver actividades')->name('actividades.show');
        Route::get('/{actividad}/edit', [App\Http\Controllers\ActividadController::class, 'edit'])->middleware('can:editar actividades')->name('actividades.edit');
        Route::put('/{actividad}', [App\Http\Controllers\ActividadController::class, 'update'])->middleware('can:editar actividades')->name('actividades.update');
        Route::delete('/{actividad}', [App\Http\Controllers\ActividadController::class, 'destroy'])->middleware('can:eliminar actividades')->name('actividades.destroy');
    });
});

Route::get('/prueba-404', function () {
    return response()->view('errors.404', [], 404);
});

