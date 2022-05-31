<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/', function () {
	
    return view('welcome');
});
Route::get('config', function(){
	Artisan::call('vendor:publish --tag=passport-config');
	return 'done';
	//php artisan vendor:publish --tag=passport-config

});
Route::get("/clear", function(){
	Artisan::call("optimize:clear");
	return "Cleared";
	
});

Route::get('/login', function () {
	
    return view('welcome');
})->name("login");