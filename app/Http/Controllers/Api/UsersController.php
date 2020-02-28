<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\AuthenticationAction;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;



class UsersController extends Controller
{
    public function Register(Request $request)
    {

        return (new AuthenticationAction())->execute(
            new RegisterRequest($request->all())
        );
    }
}
