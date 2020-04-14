<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\RecruitmentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecruitmentRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{


    public function Recruitment(Request $request){
        return(new RecruitmentAction())->postRecruitment(
            new RecruitmentRequest($request->all())
        );
    }

    public function getAllRecruitment(){
        return(new RecruitmentAction())->getRecruits();

    }

    public function pulishRecruitment(){
        return(new RecruitmentAction())->postPublish();

    }
}
