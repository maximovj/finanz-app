<?php

use App\Http\Controllers\System\AyudaController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Routes
// --------------------------
// This route file is loaded automatically by web.php.

/*******
* ROUTES WITH A BACKPACK PREFIX
********/
function prefix_backpack()
{
    // Route import excel
    Route::get('/ayuda/importar-excel', [AyudaController::class, 'ayuda_importar_excel'])->name('finanz.ayuda.importar-excel');

    // Route import excel
    Route::get('/ayuda/uso-del-sistema', [AyudaController::class, 'ayuda_uso_del_sistema'])->name('finanz.ayuda.uso-del-sistema');

    // Route log viewer laravel
    Route::get('/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
}

/*******
* ROUTES FROM ROOT (/)
********/
function root_app()
{
    // route home
    Route::get('/', function () {
        return redirect(url(config('backpack.base.route_prefix'), 'dashboard'));
    });

    // route home
    Route::get('/'.config('backpack.base.route_prefix'), function () {
        return redirect(url(config('backpack.base.route_prefix'), 'dashboard'));
    });
}
