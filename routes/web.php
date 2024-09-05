<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\AyudaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*******
* ROUTES FROM ROOT (/)
********/

// route home
Route::get('/', function () {
    return redirect(url(config('backpack.base.route_prefix'), 'dashboard'));
});

// route home
Route::get('/'.config('backpack.base.route_prefix'), function () {
    return redirect(url(config('backpack.base.route_prefix'), 'dashboard'));
});

Route::group([ 'prefix' => config('backpack.base.route_prefix', 'dashboard')],
function(){
    /*******
    * ROUTES WITH A BACKPACK PREFIX
    ********/
    // Route import excel
    Route::get('/ayuda/importar-excel', [AyudaController::class, 'ayuda_importar_excel'])->name('finanz.ayuda.importar-excel');

    // Route import excel
    Route::get('/ayuda/uso-del-sistema', [AyudaController::class, 'ayuda_uso_del_sistema'])->name('finanz.ayuda.uso-del-sistema');

    // Route log viewer laravel
    Route::get('/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
});
