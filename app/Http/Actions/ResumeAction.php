<?php

namespace App\Http\Actions;


use App\Http\Requests\AwardRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Requests\SkillRequest;
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

    public function skills(SkillRequest $request)
    {
        $validation = new SkillRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
    }


    public function  award(AwardRequest $request)
    {
        $validation = new SkillRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
    }
}
