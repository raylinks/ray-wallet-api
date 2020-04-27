<?php

namespace App\Http\Controllers\Api;


use App\Http\Actions\Blog\CommentAction;
use App\Http\Requests\Blog\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function getCommentPost()
    {
        return(new CommentAction())->getPostRelation();
    }

    public function Commentable()
    {
        return(new CommentAction())->getCommentbyPos();
    }


    public function submitComment(Request $request)
    {
        return(new CommentAction())->postComment(
            new  CommentRequest($request->all())
        );
    }

}
