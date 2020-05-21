<?php

namespace App\Http\Controllers\Api;


use App\Http\Actions\ForgotPasswordAction;
use App\Http\Requests\ForgotPassswordRequest;
use Illuminate\Http\Request;
use App\Post;

class ForgotController extends Controller
{
    public function ForgotPassword(Request $request)
    {

            return (new ForgotPasswordAction())->execute(
                new ForgotPassswordRequest($request->all())
            );

    }

}
