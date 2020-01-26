<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function Login(Request $request)
    {
        $cred = $request->only(['email', 'password']);

        if (!$token = $this->guard()->attempt($cred)) {
            return JSON(400, [], 'incorrect login details');

        } else {
            return JSON(200, ['token' => $token, 'data' => $cred], 'success');
        }

        // return $token;
    }
}
