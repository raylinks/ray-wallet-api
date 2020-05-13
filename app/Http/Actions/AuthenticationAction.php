<?php

namespace App\Http\Actions;


use App\Http\Requests\RegisterRequest;
use App\Jobs\EmailVerification;
use App\Mail\ConfirmEmail;
use App\User;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;



class AuthenticationAction
{
    use HasApiResponses;

    public function execute(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        //dd($request->all());

        $validation = new RegisterRequest($request->all());
        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
         return $this->formValidationErrorAlert($validation->errors());
        }


        $url = config('app.url');
        $callback_url = $request->callback_url;
        $user = new User;
        $user->assignRole('customer');
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_token = $this->random_str(6);
        $user->save();


        $call_back_url = base64_encode($callback_url);
        $user_id = base64_encode($user->id);
        $url .= "/verify" . $call_back_url . "&email_token=$user->email_token" . "&user_id=$user_id";


        $data = [];
        if ($user) {
            // $user->assignRole('customer');
            // $user->givePermissionTo('edit articles');
            $data['email_token'] = $user->email_token;
            $data['url'] = $url;
            $data['email'] =$user->email ;

        }

        // Send Confirm Email Notification to User
        try {
            dispatch(new  EmailVerification([
                'user' => $data
            ]));
            // Notification::send($user, new WelcomeNotify($data));
        } catch (\Exception $e) {
            return $this->serverErrorAlert($e);
        }


        return $this->successResponse('A confirmation mail has been sent to your mail');

    }

    private function random_str($length, $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }

        return $str;
    }


    public function imageUpload(Request $request): JsonResponse
    {
        $user = Auth::user();
        $ext = "only supported jpeg files";
        $extension = $request->file('avatar')->extension();
        $os = array("jpeg", "png");
        if (!in_array("ooo", $os))
       {
           return $this->formValidationErrorAlert(ooo);
       }

        // store file locally
        Storage::disk('local')->put('file.txt', 'Contents');

        Storage::disk('s3')->put('avatars/1', $fileContents);
        $path = Storage::putFile('avatars', $request->file('avatar'));

        $path = $request->file('avatar')->store('avatars');
       $fileee =  $request->file('avatar')->store::putFileAs('ray_image_bucket', 'gcp',$user->id);
        $path = Storage::putFile('avatars', $request->file('avatar'));
        return $fileee;
    }




}
