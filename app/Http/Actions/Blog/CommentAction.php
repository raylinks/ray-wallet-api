<?php
namespace App\Http\Actions\Blog;

use App\Http\Requests\Blog\CommentRequest;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\HasApiResponses;
use Illuminate\Support\Facades\Auth;

class CommentAction
{
    use HasApiResponses;

    public function getPostRelation()
    {
        $post = Post::find(1);

        foreach ($post->comments as $comment) {
            dd($comment);
            //
        }
    }

    public function getCommentbyPos()
    {
        $comment = Comment::find(2);

        $commentable = $comment->commentable;
        dd($commentable);
    }
}
