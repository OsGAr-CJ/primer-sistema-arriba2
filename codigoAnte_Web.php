<?php

use App\Http\Controllers\IncidenciaController;
use Illuminate\Support\Facades\Route;


/* Route::get('/', function () {
  
    return view('auth.login');
});
 */

// ******** Metodo 1 ************
Route::resource('incidencias','App\Http\Controllers\IncidenciaController');

Route::get('/', function () {
    return redirect()->route('incidencias.index');
}); 

// ******** Metodo 2 ************
//Route::get('/', 'App\Http\Controllers\IncidenciaController@index');




 /* Route::get('/', function () {
  
    return view('welcome');

});  */


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    
    // Rutas para los reportes 
    Route::get('incidencias/exportar-excel', [IncidenciaController::class, 'exportExcel'])->name('incidencias.excel');
    Route::get('incidencias/exportar-pdf', [IncidenciaController::class, 'exportPdf'])->name('incidencias.pdf');
    
    // Esta línea crea automáticamente las rutas para index, create, store, etc.
    Route::resource('incidencias', IncidenciaController::class);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
