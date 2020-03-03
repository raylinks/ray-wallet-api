<?php

namespace App\Http\Actions;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\PersonalDetailsRequest;
use App\Mail\ConfirmEmail;
use App\User;
use App\Traits\HasApiResponses;
use App\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class ResumeAction
{
    use HasApiResponses;

    public function execute(PersonalDetailsRequest $request)
    {

        $validation = new PersonalDetailsRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }

        $user = Auth::user();

    }

}
