<?php
namespace App\Http\Actions;
use App\Http\Requests\ResetPassswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\PasswordReset;
use App\User;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
/**
 * Class ResetPasswordAction
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
        $userToken = PasswordReset::where('token', $request->token)->first();
         $user = User::where('email', $userToken->email)->first();

        if($userToken){
            $data = ['token' => $userToken->token];
            $message ="You have successfully reset your password";
            $password = bcrypt($request['password']);
            $user->update(['password'=> $password]);
            $userToken->update(['token' => null]);
            return $this->successResponse($message, $data);

        }
        return $this->notFoundAlert('token does not exist.', []);
    }




}
