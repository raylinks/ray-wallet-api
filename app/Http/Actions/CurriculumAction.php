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
            'date_of_birth' =>$request->date_of_work,
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
    }


    public function  award(AwardRequest $request)
    {
        $validation = new SkillRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
    }

}
