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
        return redirect('/'.config('backpack.base.route_prefix', 'admin'));
    });
}
