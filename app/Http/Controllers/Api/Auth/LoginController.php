<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Actions\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Traits\HasApiResponses;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use HasApiResponses;

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
        //return Socialite::driver('google')->stateless()->user();
    }

    /**
     * Obtain the user information from the Provider.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();


        $authUser =  $this->findOrCreateUser($user,$provider);
        //login user
        //response
        $message = "you are logged in with goggle";
        return $this->successResponse($message,$authUser);
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id',$user->id)->first();
        if($authUser){
            return $authUser;
        }else{
            return
            User::create([
                'provider'  => $provider,
                'provider_id' => $user->id,

                'email' =>  $user->email,
            ]);
            UserDetail::create([
                'firstname'=> $user->userDetails->firstname,
                ]);
        }
    }



}
