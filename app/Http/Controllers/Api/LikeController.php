<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Blog\LikeAction;
use App\Http\Actions\Blog\PostAction;
use App\Http\Requests\Blog\PostRequest;
use Illuminate\Http\Request;


class LikeController extends Controller
{

    public function PostLike($id)
    {
        return(new LikeAction())->LikePost($id);
    }

    public function PostUnlike($id){
        return(new LikeAction())->UnLikePost($id);
    }



}
