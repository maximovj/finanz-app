<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Routes
// --------------------------
// This route file is loaded automatically by web.php.

/*******
* * * * * * * CUSTOM ROUTE
********/

function rutas_exportar_excel()
{
    Route::get('/exportar', function(){
        return 'Exportar archivo';
    });
}

function route_log_viewer_laravel()
{
    Route::get('/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
}

function route_home()
{
    Route::get('/', function () {
        return redirect('/'.config('backpack.base.route_prefix', 'admin'));
    });
}

/*******
* ROUTES WITH A BACKPACK PREFIX
********/
function prefix_backpack(){
    rutas_exportar_excel();
    route_log_viewer_laravel();
}

/*******
* ROUTES FROM ROOT (/)
********/
function root_app(){
    route_home();
}
