<?php
namespace App\Http\Actions;

use App\Helpers\FileStorage;
use App\Http\Requests\UploadPhotoRequest;
use App\UserDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\HasApiResponses;

class UpdateUserDetailsAction
{
    use HasApiResponses;

//    protected $user;
//
//    public function __construct()
//    {
//        $this->user = auth()->user();
//    }

    public function execute(UploadPhotoRequest $request): ?\Illuminate\Http\JsonResponse
    {

        $validation = new UploadPhotoRequest($request->all());
        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());
        // validate user input
        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        try {

//            $user = Auth::user();
//            dd($user);
                if (request()->hasFile('profile_picture')) {

                    $fileName = FileStorage::upload(request()->profile_picture, 'public');
                    $this->user->user->update(['profile_picture' => $fileName]);
                    return $this->successResponse(
                        'Profile updated successfully.'
                    );
                }

            return $this->badRequestAlert(
                'Unable to update user profile.'

            );
        } catch (\Exception $exception) {
            dd($exception);
           // return $this->serverErrorAlert('Server error', $exception);
        }
    }

}
