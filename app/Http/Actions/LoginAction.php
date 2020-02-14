<?php

namespace App\Http\Actions;


use App\Http\Requests\LoginRequest;
use App\Mail\ConfirmEmail;
use App\User;
use App\Traits\HasApiResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;




class LoginAction
{
    use HasApiResponses;

    public function execute(LoginRequest $request)
    {

        $validation = new LoginRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }

        $cred = $request->only(['email', 'password']);

        if (!$token = $this->guard()->attempt($cred)) {
            return JSON(400, [], 'incorrect login details');

        } else {
            return JSON(200, ['token' => $token, 'data' => $cred], 'success');
        }

    }

}
