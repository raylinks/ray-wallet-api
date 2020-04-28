<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\CurriculumAction;

use App\Http\Actions\ResetPasswordAction;
use App\Http\Actions\ResumeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AwardRequest;
use App\Http\Requests\CertificateRequest;
use App\Http\Requests\EducationRequest;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Requests\ReferenceRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SkillRequest;
use App\Http\Requests\WorkExperienceRequest;
use Illuminate\Http\Request;

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

    public function  Education(Request $request){
        return (new CurriculumAction())->executeEducation(
            new EducationRequest($request->all())
        );
    }

    public function  sumitReference(Request $request){
        return (new CurriculumAction())->postReference(
            new ReferenceRequest($request->all())
        );
    }

    public function  Award(Request $request){
        return (new CurriculumAction())->postaward(
            new AwardRequest($request->all())
        );
    }

    public function  WorkExperience(Request $request){
        return (new CurriculumAction())->postWorkExperience(
            new WorkExperienceRequest($request->all())
        );
    }

    public function  postCertificate(Request $request){
        return (new CurriculumAction())->Certificate(
            new CertificateRequest($request->all())
        );
    }
}
