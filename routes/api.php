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


Route::post('upload', 'Api\UsersController@UploadImage');


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
    Route::post('paystack/auhorization', 'Api\PaystackController@getLinkUrl');
    Route::post('verify/pay', 'Api\PaystackController@verifyResponseFromPay');
    Route::get('verify', 'Api\VerificationController@VerifyEmailRegistration');
    Route::post('personal/details', 'Api\ResumeController@PersonalDetails');
    Route::post('skills/details', 'Api\ResumeController@PostSkills');
   // Route::post('education/details', 'Api\ResumeController@Education');
     Route::post('reference/details', 'Api\ResumeController@sumitReference');
     Route::post('award/details', 'Api\ResumeController@Award');
     Route::post('work/experience', 'Api\ResumeController@WorkExperience');
      Route::post('certificate', 'Api\ResumeController@postCertificate');

      //Recruitment  route
      Route::post('post/recruitment', 'Api\RecruitmentController@Recruitment');
      Route::get('get/recruitment', 'Api\RecruitmentController@getAllRecruitment');
       Route::post('publish/recruitment', 'Api\RecruitmentController@pulishRecruitment');
      Route::get('get/all/jobs', 'Api\RecruitmentController@ShowUsersJobs');


       //Blog  route
       Route::post('submit/posts', 'Api\PostController@submitPost');
       Route::get('get/posts/users', 'Api\PostController@displayPostToUsers');
       Route::get('admin/all/posts', 'Api\PostController@getPostToAdmin');
       Route::post('admin/publish/posts', 'Api\PostController@AdminToPublishPost');
      // Route::get('get/comment/post', 'Api\CommentController@getCommentPost');
       Route::post('submit/comment', 'Api\CommentController@submitComment');
      // Route::get('get/commentable', 'Api\CommentController@Commentable');
         Route::get('post/{id}/', 'Api\PostController@showPostByID');

    //blog  like  and Unlike
    Route::post('like/{id}/post', 'Api\LikeController@PostLike');
   // Route::post('unlike/{id}/post', 'Api\LikeController@PostUnlike');

    //ADMIN ROLES  AND PERMISSION  ROUtes
    Route::post('post/role', 'Api\RolesAndPermissionController@createRole');

});

//Route::get('login/github', 'Auth\LoginController@redirectToProvider');
//Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');


Route::get('auth/{provider}', 'Api\Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Api\Auth\LoginController@handleProviderCallback');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('post/all', 'Api\PostController@self');


});
