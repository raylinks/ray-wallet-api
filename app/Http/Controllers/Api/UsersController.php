<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\AuthenticationAction;
use App\Http\Actions\UpdateUserDetailsAction;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UploadPhotoRequest;
use Illuminate\Http\Request;



class UsersController extends Controller
{
    public function Register(Request $request)
    {

        return (new AuthenticationAction())->execute(
            new RegisterRequest($request->all())
        );
    }



    public function UploadImage(Request $request)
    {
        return (new UpdateUserDetailsAction())->execute(
            new UploadPhotoRequest($request->all())
        );
    }
}
