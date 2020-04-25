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

    public function submitPost(Request $request)
    {
        return(new PostAction())->execute(
            new PostRequest($request->all())
        );
    }

    public function displayPostToUsers(){
        return(new PostAction())->showAllPostUser();
    }

    public function getdPostToAdmin(){
        return(new PostAction())->showAllPostTOAdmin();
    }

    public function AdminToPublishPost(){
        return(new PostAction())->PublishPost();
    }
    
    

}
