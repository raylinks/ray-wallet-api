<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\ResetPasswordAction;
use App\Http\Actions\ResumeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AwardRequest;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SkillRequest;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function PersonalDetails(Request $request){
        return(new ResumeAction())->execute(
            new PersonalDetailsRequest($request->all())
        );
    }

    public function PostSkills(Request $request){
        return (new ResumeAction())->skills(
            new SkillRequest($request->all())
        );
    }

    public function  PostAward(Request $request){
        return (new ResumeAction())->award(
            new AwardRequest($request->all())
        );
    }
}
