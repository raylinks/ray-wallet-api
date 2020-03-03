<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\ResetPasswordAction;
use App\Http\Actions\ResumeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function PersonalDetails(Request $request){
        return(new ResumeAction())->execute(
            new PersonalDetailsRequest($request->all())
        );
    }
}
