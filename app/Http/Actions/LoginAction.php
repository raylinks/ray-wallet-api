<?php

namespace App\Http\Actions;


use App\Http\Requests\LoginRequest;
use App\Mail\ConfirmEmail;
use App\User;
use App\Traits\HasApiResponses;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class LoginAction
{
    use HasApiResponses, AuthenticatesUsers;

    public function execute(LoginRequest $request): \Illuminate\Http\JsonResponse
    {

        $validation = new LoginRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }

        $cred = $request->only(['email', 'password']);

        if (!$token = JWTAuth::attempt($cred)) {
            return $this->notFoundAlert(
                'incorrect login details');

        }else {
            $user = auth()->user()->load('userDetails');
            $auth_user = Auth::user()->load('roles');

            if (is_null($user->email_verified_at)) {
                return $this->badRequestAlert(
                    'You are yet to verify your email address');
            }
            return JSON(200, [
                $token,
               $auth_user
            ]);
        }



    }

}
