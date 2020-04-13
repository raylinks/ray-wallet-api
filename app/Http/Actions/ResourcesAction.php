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

class ResourcesAction
{
    use HasApiResponses;

    public function  ambasadorReferral(AmbasadorReferalRequest $request): JsonResponse
    {
       $validation = new AmbasadorReferalRequest($request->all());

       $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

       if ($validation->fails()) {
           return $this->formValidationErrorAlert($validation->errors());
       }

        $user = Auth::user();

        $AmbasadorReferal = AmbasadorRefer::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'address'=> $request->address,
            'status' => $request->status,
            'work'=> $request->lastname,

        ]);

        $message = "You have created AmbasadorReferal ";
        return $this->successResponse($message);

    }

}
