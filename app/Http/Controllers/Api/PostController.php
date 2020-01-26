<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function self()
    {
        $user = auth()->user();
        $post = $user->posts;

        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            // do something
            return JSON(200, ['token'=> "success", $e->getMessage()], 'fail');
        }

        return JSON(200, ['success'=> "success",  'data' => $post], 'success');

    }

}
