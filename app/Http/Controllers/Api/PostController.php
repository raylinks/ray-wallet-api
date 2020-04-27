<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Blog\PostAction;
use App\Http\Requests\Blog\PostRequest;
use Illuminate\Http\Request;


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

    public function getPostToAdmin(){
        return(new PostAction())->showAllPostTOAdmin();
    }

    public function AdminToPublishPost(){
        return(new PostAction())->PublishPost();
    }

    public function showPostByID($id)
    {
        return(new PostAction())->showPost($id);
    }




}
