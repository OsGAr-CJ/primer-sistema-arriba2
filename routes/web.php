<?php

use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\TipoIncidenciaController;
use Illuminate\Support\Facades\Route;

// Redirección inicial al login o al listado
Route::get('/', function () {
    return redirect()->route('incidencias.index');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // IMPORTANTISIMO: Las rutas específicas (como excel) van ANTES del resource
    Route::get('incidencias/exportar-excel', [IncidenciaController::class, 'exportExcel'])->name('incidencias.excel');
    Route::get('incidencias/exportar-pdf', [IncidenciaController::class, 'exportPdf'])->name('incidencias.pdf');
    
    // Resource solo una vez aquí adentro
    Route::resource('incidencias', IncidenciaController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('sistemas', SistemaController::class);
    Route::resource('tipos', TipoIncidenciaController::class);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});