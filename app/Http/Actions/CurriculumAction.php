<?php
namespace App\Http\Actions;

use App\Http\Requests\AwardRequest;
use App\Http\Requests\CertificateRequest;
use App\Http\Requests\EducationRequest;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Requests\ReferenceRequest;
use App\Http\Requests\SkillRequest;
use App\Http\Requests\WorkExperienceRequest;
use App\Models\Award;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Reference;
use App\Models\Skill;
use App\Models\WorkExperience;
use App\UserDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\HasApiResponses;

class CurriculumAction
{
    use HasApiResponses;

    public function execute(PersonalDetailsRequest $request): JsonResponse
    {
       $validation = new PersonalDetailsRequest($request->all());

       $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

       if ($validation->fails()) {
           return $this->formValidationErrorAlert($validation->errors());
       }

        $user = Auth::user();

        $submitPersonalDetails = UserDetail::create([
            'user_id' => $user->id,
            'title'=> $request->title,
            'firstname' => $request->firstname,
            'lastname'=> $request->lastname,
            'date_of_birth' =>$request->date_of_birth,
            'nationality' => $request->nationality,
            'phone' => $request->phone,
            'email' => $request->email,
            'web' => $request->web,
            'address' => $request->address,
            'profile' =>$request->profile,
            'picture_url' => $request->picture_url,
            'interest' => $request->interest,
            'username' => $request->username,

        ]);

        $message = "You have created your personal details";
        return $this->successResponse($submitPersonalDetails);



    }

    public function skills(SkillRequest $request)
    {
        $validation = new SkillRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }

        $user = Auth::user();

        $submitSkills = Skill::create([
            'user_id' => $user->id,
            'skill_category'=> $request->skill_category,
            'skill_name' => $request->skill_name,
            'skill_level'=> $request->skill_level,

        ]);

        $message = "You have created your skills details";
        return $this->successResponse($message);

    }

    public function  executeEducation(EducationRequest $request)
    {
        $validation = new EducationRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        $user = Auth::user();

        $submitEducation = Education::create([
            'user_id' => $user->id,
            'institution'=> $request->institution,
            'field_of_study' => $request->field_of_study,
            'country'=> $request->country,
            'city' => $request->city,
            'time_from'=> $request->time_from,
            'time_to'=> $request->time_to,
            'note'=> $request->note,

        ]);


        $message = "You have created your Education details";
        return $this->successResponse($message);
    }


    public function postReference(ReferenceRequest $request)
    {
        $validation = new ReferenceRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        $user = Auth::user();

        $submitEducation = Reference::create([
            'user_id' => $user->id,
            'company_name'=> $request->company_name,
            'name' => $request->name,
            'contact_1'=> $request->contact_1,
            'contact_2' => $request->contact_2,
            'note'=> $request->note,

        ]);

        $message = "You have created your Reference details";
        return $this->successResponse($message);
    }


    public function  postaward(AwardRequest $request)
    {
        $validation = new AwardRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());
        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        $user = Auth::user();

        $submitEducation = Award::create([
            'user_id' => $user->id,
            'title'=> $request->title,
            'issuer' => $request->issuer,
            'web_url'=> $request->web_url,
            'date' => $request->date,
            'note'=> $request->note,
        ]);

        $message = "You have created your award details";
        return $this->successResponse($message);
    }

    public function  postWorkExperience(WorkExperienceRequest $request)
    {
        $validation = new WorkExperienceRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        $user = Auth::user();

        $WorkExperience = WorkExperience::create([
            'user_id' => $user->id,
            'company_name'=> $request->company_name,
            'job_title' => $request->job_title,
            'country'=> $request->country,
            'city' => $request->city,
            'time_from'=> $request->time_from,
            'time_to'=> $request->time_to,
            'currently_work'=> $request->currently_work,
            'note'=> $request->note,

        ]);

        $message = "You have created your WorkExperience details";
        return $this->successResponse($message);
    }


    public function  Certificate(CertificateRequest $request)
    {
        $validation = new CertificateRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        $user = Auth::user();

        $WorkExperience = Certificate::create([
            'user_id' => "1",
            'name'=> $request->name,
            'authority' => $request->authority,
            'url'=> $request->url,
            'date'=> $request->date,


        ]);

        $message = "You have created your Certificate details";
        return $this->successResponse($message);
    }

}
