<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\HistorialLaboralController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\EmpleoController;
use App\Http\Controllers\VacacionController;

Route::resource('empleados', EmpleadoController::class);
Route::get('empleados/{empleado}/historial/create', [HistorialLaboralController::class, 'create'])->name('historial.create');
Route::post('empleados/{empleado}/historial', [HistorialLaboralController::class, 'store'])->name('historial.store');
Route::resource('nomina', NominaController::class);
Route::resource('empleos', EmpleoController::class);
Route::get('/nomina/create/{empleadoId}', [NominaController::class, 'create'])->name('nomina.create');
Route::post('/nomina/{empleadoId}/store', [NominaController::class, 'store'])->name('nomina.store');
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/nomina', [NominaController::class, 'index'])->name('nomina.index');
Route::resource('vacaciones', VacacionController::class);
Route::get('/vacaciones/create/{empleadoId}', [VacacionController::class, 'create'])->name('vacaciones.create');
use App\Http\Controllers\InformacionGeneralController;

Route::resource('informacion', InformacionGeneralController::class);