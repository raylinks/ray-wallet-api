<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\RecruitmentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{

   
    public function postRecruitment(Request $request){
        return(new RecruitmentAction())->execute(
            new RecruitmentRequest($request->all())
        );
    }

    public function ambasadorReferral(Request $request){
        return(new ResourcesAction())->execute(
            new AmbasadorReferalRequest($request->all())
        );
    }
}
