<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\ResetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{

    public function ResetPassword(Request $request){
        return(new ResetPasswordAction())->execute(
            new ResetPasswordRequest($request->all())
        );
    }
}
