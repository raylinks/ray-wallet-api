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

use Illuminate\Support\Facades\Route;

Route::post('login', 'Api\Auth\LoginController@Login');
Route::post('register/user', 'Api\UsersController@Register');
Route::post('hello', 'Api\UsersController@hello');
Route::post('role', 'Api\Auth\PermissionsController@createRole');
Route::get('get/roles', 'Api\Auth\PermissionsController@get');
Route::post('assign', 'Api\Auth\PermissionsController@assignPermissionToRole');
Route::post('forgotpassword', 'Api\ForgotController@ForgotPassword');
Route::post('verify', 'Api\VerificationController@VerifyEmailRegistration');
Route::post('resetpassword', 'Api\ResetPasswordController@ResetPassword');
Route::post('personal/detail', 'Api\ResumeController@PersonalDetails');
Route::post('get/request', 'Api\PaystackController@getLinkUrl');
Route::post('image/upload', 'Api\UsersController@ProfileImage');

Route::middleware(['cors'])->group(function () {
    Route::post('login', 'Api\Auth\LoginController@Login');
    Route::post('register/user', 'Api\UsersController@Register');
    Route::post('hello', 'Api\UsersController@hello');
    Route::post('role', 'Api\Auth\PermissionsController@createRole');
    Route::get('get/roles', 'Api\Auth\PermissionsController@get');
    Route::post('assign', 'Api\Auth\PermissionsController@assignPermissionToRole');
    Route::post('forgotpassword', 'Api\ForgotController@ForgotPassword');
    Route::post('resetpassword', 'Api\ResetPasswordController@ResetPassword');
    Route::post('personal/detail', 'Api\ResumeController@PersonalDetails');
    Route::post('get/request', 'Api\PaystackController@getLinkUrl');
});

//Route::get('login/github', 'Auth\LoginController@redirectToProvider');
//Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');


Route::get('auth/{provider}', 'Api\Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Api\Auth\LoginController@handleProviderCallback');


Route::group(['middleware' => 'auth:api'], function () {
    Route::get('post/all', 'Api\PostController@self');

    Route::post('personal/details', 'Api\ResumeController@PersonalDetails');
});
