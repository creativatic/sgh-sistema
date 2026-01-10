<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProgramacionController;
use App\Http\Controllers\AdelantoController;
use App\Http\Controllers\QrTisurController;
use App\Http\Controllers\DetalleProgramacionController;
use App\Http\Controllers\TisurController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\ExpedientePagoController;
use App\Http\Controllers\SeguimientoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\VolqueteController;
use App\Http\Controllers\VolqueteAdelantoController;

Route::middleware(['auth'])->group(function () {

    // Dashboard
    // Route::get('/dashboard', [DashboardController::class, 'index'])
    //     ->middleware('permission:ver dashboard')
    //     ->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Solo administrador
    Route::middleware('role:Administrador|Supervisor')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show']);
        
        // Buscadores
        Route::get('/programaciones/search', [ExpedienteController::class, 'buscarProgramacion'])->name('programaciones.search');
        // Route::get('/programacion/{id}', [ProgramacionController::class, 'showJson']);
        Route::get('/programacions/{id}/json', [ProgramacionController::class, 'showJson']);

        Route::get('/programacions/conductor/{licencia}', [ProgramacionController::class, 'getConductorByLicencia']);
        Route::get('/programacions/{programacion}/data', [ProgramacionController::class, 'getData']);
        Route::get('/unidades/{id}/data', [ProgramacionController::class, 'unidadData']);
        Route::patch('/programacions/{id}/conformidad', [ProgramacionController::class, 'conformidad'])->name('programacions.conformidad');
        Route::resource('programacions', ProgramacionController::class);

        
        Route::get('/conductores/licencia/{licencia}', [ConductorController::class, 'getByLicencia']);
        
        //Route::get('/tisurs/search', [ExpedienteController::class, 'buscarTisur'])->name('tisurs.search');
        //Route::get('/detalles/search', [ExpedienteController::class, 'buscarDetalle'])->name('detalles.search');


        // Adelantos
        Route::resource('adelantos', AdelantoController::class)->only(['index', 'edit', 'update']);

        // Route::resource('adelantos', AdelantoController::class)->except(['show']);
        // QR Tisur
        Route::get('/reportes/qr', [ReporteController::class, 'reporteQr'])
            ->name('reportes.qr');

        Route::get('/reportes/qr/export', [ReporteController::class, 'exportQr'])
            ->name('reportes.export_qr');
        //Route::get('/programacions/reporte-qr', [ProgramacionController::class, 'reporteQr'])->name('programacions.reporte_qr');
        // Detalles
        //Route::resource('detalleprogramacion', DetalleProgramacionController::class)->except(['show']);
        Route::resource('detalleprogramacion', DetalleProgramacionController::class);
        // Tisur
        Route::resource('tisur', TisurController::class)->except(['show']);
        
        // 馃敼 Ruta AJAX para obtener datos de Programaci贸n por ID
        Route::get('expediente/archivo/{archivo}',[ExpedienteController::class, 'verArchivo'])->name('expediente.archivo');
        Route::get('/expediente/programacion/{id}', [ExpedienteController::class, 'getProgramacion'])->name('expediente.getProgramacion');
        Route::get('/expediente/tisur/{id}', [ExpedienteController::class, 'getTisur']);
        Route::get('/expediente/detalle/{id}', [ExpedienteController::class, 'getDetalle']);
        Route::get('/expediente/{id}', [ExpedienteController::class, 'show'])->name('expediente.show');
        Route::get('/expediente/{id}/edit', [ExpedienteController::class, 'edit'])->name('expediente.edit');
        Route::get('/expediente/precio-tn', [ExpedienteController::class, 'getPrecioTn']);
        Route::get('/expediente', [ExpedienteController::class, 'index'])->name('expediente.index');
        Route::get('/expedientes/autocomplete-tisur', [ExpedienteController::class, 'autocompleteTisur']);
        Route::get('/expedientes/tisur/{id}', [ExpedienteController::class, 'obtenerTisur']);
        Route::patch('expedientes/{expediente}/estado-impresion',[ExpedienteController::class, 'estadoImpresion'])->name('expedientes.estado_impresion');

        // Expediente
        Route::resource('expediente', ExpedienteController::class);

        // ===============================
        // EXPEDIENTE PAGOS
        // ===============================
        // C:\laragon\www\sistema-sgh-1.4\routes\web.php
        Route::prefix('expediente-pagos')->name('expediente_pagos.')->group(function () {
            Route::get('/', [ExpedientePagoController::class, 'index'])->name('index');
            Route::get('/{id}', [ExpedientePagoController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ExpedientePagoController::class, 'edit'])->name('edit');
            // CAMBIA ESTO:
            Route::put('/{id}', [ExpedientePagoController::class, 'update'])->name('update'); 
        });
        
        //  Seguimiento
        Route::resource('seguimientos', SeguimientoController::class)->except(['show']);

        // PROVEEDORES
        Route::resource('proveedores', ProveedorController::class)->except(['show']);
        // UNIDADES
        Route::resource('unidades', UnidadController::class);
        Route::patch('/volquetes/{id}/conformidad',[VolqueteController::class, 'conformidad'])->name('volquetes.conformidad');
        Route::patch('/volquetes/{id}/estado-impresion', [VolqueteController::class, 'estadoImpresion'])->name('volquetes.estado_impresion');

        Route::resource('volquetes', VolqueteController::class);
        
        // 鈿狅笍 ESTA RUTA DEBE IR ANTES DEL RESOURCE
        Route::get('/conductores/search', [ConductorController::class, 'search'])
            ->name('conductores.search');
        Route::get('/conductores/{id}/data', [ConductorController::class, 'getDataCUP']);


        // RUTAS CRUD
        Route::resource('conductores', ConductorController::class)
            ->parameters(['conductores' => 'conductor']);

        
        Route::prefix('volquetes-adelantos')->name('volquetes_adelantos.')->group(function () {

            Route::get('/', [VolqueteAdelantoController::class, 'index'])
                ->name('index');

            Route::get('/{id}/edit', [VolqueteAdelantoController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [VolqueteAdelantoController::class, 'update'])
                ->name('update');

        });

    });
});

// Registro
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Login
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Recuperaci贸n de contrase帽a
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.update');
