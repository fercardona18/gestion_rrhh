<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\HistorialLaboralController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\EmpleoController;
use App\Http\Controllers\VacacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InformacionGeneralController;

// Rutas protegidas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    Route::resource('empleados', EmpleadoController::class);
    Route::get('empleados/{empleado}/historial/create', [HistorialLaboralController::class, 'create'])->name('historial.create');
    Route::post('empleados/{empleado}/historial', [HistorialLaboralController::class, 'store'])->name('historial.store');
    Route::resource('nomina', NominaController::class);
    Route::resource('empleos', EmpleoController::class);
    Route::get('/nomina/create/{empleadoId}', [NominaController::class, 'create'])->name('nomina.create');
    Route::post('/nomina/{empleadoId}/store', [NominaController::class, 'store'])->name('nomina.store');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/nomina', [NominaController::class, 'index'])->name('nomina.index');
    Route::resource('vacaciones', VacacionController::class);
    Route::get('/vacaciones/create/{empleadoId}', [VacacionController::class, 'create'])->name('vacaciones.create');
    Route::resource('informacion', InformacionGeneralController::class);
    Route::post('vacaciones/{id}/approve', [VacacionController::class, 'approve'])->name('vacaciones.approve');
    Route::post('vacaciones/{id}/reject', [VacacionController::class, 'reject'])->name('vacaciones.reject');

    Route::get('/', function () {
        return redirect('/login'); // Redirige a /login al acceder a la raíz.
    });

});

// Rutas de autenticación
Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


