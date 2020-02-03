<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'Api\Auth\LoginController@Login');
Route::post('register/user', 'Api\UsersController@Register');
Route::post('hello', 'Api\UsersController@hello');



Route::group(['middleware' => 'auth:api'], function(){
    Route::get('post/all', 'Api\PostController@self');
});
