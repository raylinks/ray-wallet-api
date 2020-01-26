<?php

namespace App\Http\Controllers\Api;

use App\Mail\ConfirmEmail;
use App\User;
use App\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mail;
use Validator;

class UsersController extends Controller
{
    public function Register(Request $request)
    {
        //  dd("raybaba int");

        //   $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:255',
        //     'email' => 'required|unique:users|max:255',
        //     'username' => 'required|unique:users|max:255',
        //     'password' => 'required',
        // ]);

        // if ($validator->fails()) {
        //    dd($validator);
        //    $errors = $validator->errors();
        // }
        $url = config('app.url');
        $callback_url = $request->callback_url;


        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->email_token = $this->random_str(6);
        $user->verified_status = 0;
        $user->password = Hash::make($request->password);
        $user->save();


        $call_back_url = base64_encode($callback_url);
        $user_id = base64_encode($user->id);
        $url .= "/verify?redirect_callback=" . $call_back_url . "&email_token=$user->email_token" . "&user_id=$user_id";


        $create_wallet = UserWallet::create([

            'user_id' => $user->id,
            'initial_amount' => 0,
            'actual_amount' => 0
        ]);

        $data = [];
        if ($user) {
            $data['username'] = $user->username;
            $data['email_token'] = $user->email_token;
            $data['url'] = $url;

        }
        // Send Confirm Email Notification to User
        try {
            Mail::to($user->email)->send(new ConfirmEmail($data));
            // Notification::send($user, new WelcomeNotify($data));
        } catch (Exception $e) {
        }


        return JSON(200, $create_wallet->toArray(), 'success');

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

    public function emailToken(Request $request)
    {

        $user = User::where(['email_token' => $request->email_token])->first();

        if (!$user) {

            $url = $url[0] . 'login';
            return Redirect::to($url);
        }

        $url = base64_decode($request->redirect_callback) . '?status=success' . '&user_id=' . request()->user_id;
        $user->email_token = null;
        $user->save();
        return Redirect::to($url);
    }
}
