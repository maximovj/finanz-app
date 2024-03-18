<?php

use Illuminate\Support\Facades\Route;

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

require 'finanz/custom.php';

Route::group([ 'prefix' => config('backpack.base.route_prefix', 'admin')], 
function(){
    prefix_backpack();
});

root_app();