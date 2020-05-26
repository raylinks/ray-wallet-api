<?php

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

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return Response::json([
        'name' => 'Welcome to genius consult API service',
        'version' => '1.0',
        'base_url' => '',
    ]);
});


Route::get('/home', 'HomeController@index')->name('home');
