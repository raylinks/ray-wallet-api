<?php

namespace App\Http\Controllers\Api;


use App\Http\Actions\Blog\CommentAction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Helpers\FileStorage;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Facades\Validator;

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


}
