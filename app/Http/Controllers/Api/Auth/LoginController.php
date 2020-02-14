<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Actions\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function Login(Request $request)
    {
        return (new LoginAction())->execute(
          new LoginRequest($request->all())
        );

        // return $token;
    }
}
