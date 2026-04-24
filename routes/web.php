<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessUserController;
use App\Http\Controllers\FarmaciaTurnoController;
use App\Http\Controllers\FarmaciaRotacionController;
use App\Http\Controllers\TransporteController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\HorarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Pública
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    // Perfil
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Negocios (CRUD completo)
    Route::resource('negocios', BusinessController::class);

    // ======================
    // Farmacias de Turno
    // ======================
    Route::prefix('farmacias')->name('farmacias.')->group(function () {
        Route::controller(FarmaciaTurnoController::class)->group(function () {
            // CRUD principal
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');

            // API / Widget
            Route::get('/turno-hoy', 'turnoHoy')->name('turnoHoy');
            Route::get('/{id}/eventos-turnos', 'eventosTurnos')->name('farmacias.eventosTurnos');
        });
    });

    // ======================
    // Rotaciones de Farmacias
    // ======================
    Route::prefix('farmacias')->name('farmacias.')->group(function () {
        Route::controller(FarmaciaRotacionController::class)->group(function () {
            Route::get('/{farmacia_id}/rotaciones', 'index')->name('rotaciones.index');
            Route::get('/{farmacia_id}/rotaciones/create', 'create')->name('rotaciones.create');
            Route::post('/{farmacia_id}/rotaciones', 'store')->name('rotaciones.store');
            Route::get('/rotaciones/{id}/edit', 'edit')->name('rotaciones.edit');
            Route::put('/rotaciones/{id}', 'update')->name('rotaciones.update');
            Route::delete('/rotaciones/{id}', 'destroy')->name('rotaciones.destroy');
        });
    });

    // ======================
    // Servicios Públicos
    // ======================
    Route::prefix('servicios')->name('servicios.')->group(function () {
        // Transportes
        Route::resource('transportes', TransporteController::class);
        // Rutas
        Route::get('rutas/transporte/{transporte}', [RutaController::class, 'index'])->name('rutas.por_transporte');
        Route::resource('rutas', RutaController::class);
        // Horarios
        Route::get('horarios/ruta/{ruta}', [HorarioController::class, 'index'])->name('horarios.por_ruta');
        Route::resource('horarios', HorarioController::class);
    });

    // ======================
    // Monitoreo - Business Users
    // ======================
    Route::prefix('monitoreo')->name('monitoreo.')->group(function () {
        Route::controller(BusinessUserController::class)->group(function () {
            Route::get('/negocios-usuarios', 'index')->name('negociosUsuarios.index');
            Route::get('/negocios-usuarios/create', 'create')->name('negociosUsuarios.create');
            Route::post('/negocios-usuarios', 'store')->name('negociosUsuarios.store');
            Route::post('/negocios-usuarios/store-multiple', 'storeMultiple')->name('negociosUsuarios.storeMultiple');
            Route::get('/negocios-usuarios/{id}/edit', 'edit')->name('negociosUsuarios.edit');
            Route::put('/negocios-usuarios/{id}', 'update')->name('negociosUsuarios.update');
            Route::delete('/negocios-usuarios/{id}', 'destroy')->name('negociosUsuarios.destroy');
        });
    });
});

require __DIR__ . '/auth.php';
