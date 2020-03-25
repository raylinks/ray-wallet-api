<?php

namespace App\Http\Actions;


use App\Http\Requests\EmailVerifyRequest;
use App\Jobs\EmailVerification;
use App\Mail\ConfirmEmail;
use App\User;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;



class VerificationAction
{
    use HasApiResponses;

    public function execute(EmailVerifyRequest $request): JsonResponse
    {
    //dd("bimbo");
        $validation = new EmailVerifyRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
         return $this->formValidationErrorAlert($validation->errors());
        }




        $url = config('app.app_url');
        $callback_url = $request->callback_url;
        $user = User::where('email_token', $request->email_token)->first();

        if(!$user)
        {
            return $this->notFoundAlert('Your token could not be found.', []);
        }

        $user->email_token = null;
        $user->save();



        $call_back_url = base64_encode($callback_url);
        $user_id = base64_encode($user->id);
        $url .= "/verify?redirect_callback=" . $call_back_url . "&user_id=$user->id";
        

        return Redirect::to($url);

    }



}
