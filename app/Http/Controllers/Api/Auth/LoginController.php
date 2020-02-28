<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Actions\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function Login(Request $request)
    {
        return (new LoginAction())->execute(
          new LoginRequest($request->all())
        );

        // return $token;
    }


    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from the Provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        dd($provider);
        $user = Socialite::driver($provider)->user();


        $authUser =  $this->findOrCreateUser($user,$provider);
        //login user
        //response
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id',$user->id)->first();
        if($authUser){
            return $authUser;
        }else{
            return
            User::create([
            'firstname'=> $user->userDetails->firstname,
            'email' =>  $user->email
            ]);
            UserDetail::create([
                'provider'  => $provider,
                'provider_id' => $user->id
                ]);
        }
    }



}
