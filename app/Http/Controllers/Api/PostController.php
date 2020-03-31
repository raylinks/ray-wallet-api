<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Helpers\FileStorage;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Facades\Validator;
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
