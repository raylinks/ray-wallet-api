<?php
namespace App\Http\Actions;
use App\Http\Requests\ForgotPassswordRequest;
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
class ForgotPasswordAction
{
    use HasApiResponses;

    /**
     * @param \App\Http\Requests\ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function execute(ForgotPassswordRequest $request): JsonResponse
    {
        $validation = new ForgotPassswordRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }

       // $user = User::where('email', $request->email)->pluck('email');
        $user = User::where('email', $request->email)->get();

        if(!$user){
            return $this->notFoundAlert('Your account could not be found.', []);
        }

            return $this->redirectToUrl($user);
    }


    public function redirectToUrl($user){
        //dd($user);
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user[0]->email],
            ['token' => $this->randomStr(32)]
        );

//        $url = config('app.url');
//        $url .= /forgetpassword?"token"{$passwordReset->token}
        $message = 'Amail has been sent to your mail';
        $data = ['token' => $passwordReset->token];
        Mail::send(new ForgetPasswordMail([$passwordReset, $user, $data]));
        return $this->notFoundAlert($message, [$data]);




    }
    private function randomStr($length, $keySpace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keySpace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keySpace[random_int(0, $max)];
        }
        return $str;
    }

}
