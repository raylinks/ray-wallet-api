<?php
namespace App\Http\Actions;

use App\Http\Requests\AwardRequest;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Requests\SkillRequest;
use App\UserDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

use App\Traits\HasApiResponses;

class RecruitmentAction
{
    use HasApiResponses;

    public function  postRecruitment(RecruitmentRequest $request): JsonResponse
    {
       $validation = new RecruitmentRequest($request->all());

       $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

       if ($validation->fails()) {
           return $this->formValidationErrorAlert($validation->errors());
       }

        $user = Auth::user();

        $AmbasadorReferal = RecruitmentAction::create([
            'job_title' => $request->job_title,
            'location' => $request->location,
            'skills'=> $request->skills,
            'experience' => $request->experience,
            'description'=> $request->description,
            'requirement' => $request->requirement,
            'responsiility' => $request->responsiility,
            'qualification'=> $request->qualification,
            'scope_of_work' => $request->scope_of_work,
            'closing_date'=> $request->closing_date,

        ]);

        $message = "You have created Recruitment postal ";
        return $this->successResponse($message);

    }

}
