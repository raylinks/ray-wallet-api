<?php

namespace App\Http\Actions;


use App\Http\Requests\RegisterRequest;
use App\Mail\ConfirmEmail;
use App\User;
use App\Traits\HasApiResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;



class AuthenticationAction
{
    use HasApiResponses;

    public function execute(RegisterRequest $request)
    {

        $validation = new RegisterRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
         return $this->formValidationErrorAlert($validation->errors());
        }


        $url = config('app.url');
        $callback_url = $request->callback_url;
        $user = new User;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_token = $this->random_str(6);
        $user->save();


        $call_back_url = base64_encode($callback_url);
        $user_id = base64_encode($user->id);
        $url .= "/verify?redirect_callback=" . $call_back_url . "&email_token=$user->email_token" . "&user_id=$user_id";


        $data = [];
        if ($user) {
            $user->assignRole('writer');
            $user->givePermissionTo('edit articles');
            $data['email_token'] = $user->email_token;
            $data['url'] = $url;
            $data['email'] =$user->email ;

        }
        // Send Confirm Email Notification to User
        try {
            Mail::to($user->email)->send(new ConfirmEmail($data));
            // Notification::send($user, new WelcomeNotify($data));
        } catch (Exception $e) {
        }


        return JSON(200, $user->toArray(), 'A confirmation mail has been sent to youe email, please check to confirm');

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

}
