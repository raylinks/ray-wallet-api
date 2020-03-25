<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\VerificationAction;
use App\Http\Requests\EmailVerifyRequest;
use Illuminate\Http\Request;



class VerificationController extends Controller
{
    public function VerifyEmailRegistration(Request $request)
    {

        return (new VerificationAction())->execute(
            new EmailVerifyRequest($request->all())
        );
    }


    public function ProfileImage(Request $request){
        return (new AuthenticationAction())->imageUpload($request);
    }
}
