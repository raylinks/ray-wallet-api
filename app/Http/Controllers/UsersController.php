<?php

namespace App\Http\Controllers;
use App\User;
use App\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function Register(Request $request){
      //  dd("raybaba int");


        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->email_token = $this->random_str(6);
        $user->verified_status  = 0;
        $user->password =  Hash::make($request->password);
        $user->save();



        $create_wallet = UserWallet::create([

            'user_id' => $user->id,
            'initial_amount' => 0,
            'actual_amount' => 0
        ]);

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
