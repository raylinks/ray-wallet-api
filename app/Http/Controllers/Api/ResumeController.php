<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\CurriculumAction;

use App\Http\Actions\ResetPasswordAction;
use App\Http\Actions\ResumeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AwardRequest;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SkillRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{


    public function PersonalDetails(Request $request)
    {
        return (new CurriculumAction())->execute(
            new PersonalDetailsRequest($request->all())
        );
    }

    public function PostSkills(Request $request){
        return (new CurriculumAction())->skills(
            new SkillRequest($request->all())
        );
    }

    public function  PostAward(Request $request){
        return (new ResumeAction())->award(
            new AwardRequest($request->all())
        );
    }
}
