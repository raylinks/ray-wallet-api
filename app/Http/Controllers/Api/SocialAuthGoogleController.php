<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Prophecy\Exception\Exception;


class SocialAuthGoogleController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        dd("ope");
    //try{
        $googleUser = Socialite::driver('google')->user();
        dd($googleUser);
        $existUser  = User::where('email', $googleUser->email)->first();
        if($existUser){
            dd("baby yo");
        Auth::loginUsingId($existUser->id, true);
        }else{
            dd("mad oo");
            $user = new User;
            $user->userDetails->firstname = $googleUser->name;
            $user->email = $googleUser->email;
            $user->userDetails()->google->id = $googleUser->id;
            $user->password = md5(rand(1,10000));
            $user->save();
            Auth::loginUsingId($user->id, true);

        }
        return JSON(200, ['success'=> "success",  'data' => $user], 'success');
//    }catch(Exception $e){
//
//    }
    }

}
