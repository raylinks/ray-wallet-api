<?php
namespace App\Http\Actions;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\ForgetPasswordMail;
use App\Models\PasswordReset;
use App\User;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
/**
 * Class ForgotPasswordAction
 * @package App\Http\Actions
 */
class ResetPasswordAction
{
    use HasApiResponses;

    /**
     * @param \App\Http\Requests\ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function execute(ResetPasswordRequest $request): JsonResponse
    {
        $validation = new ResetPasswordRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }

        // $user = User::where('email', $request->email)->pluck('email');
        $userToken = PasswordReset::where('token', $request->token)->first();

        if(!$userToken){
            return $this->notFoundAlert('Your token is not valid.', []);
        }

        $user  = User::where('email', $userToken->email)->first();
        $userToken->update(['token' => null]);
        $user->update(['password' => $request->password]);
        $message = ' Your Password has been reset';

        return $this->successResponse($message);

    }



}
