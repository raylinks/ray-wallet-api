<?php
namespace App\Http\Actions\Blog;

use App\Http\Requests\Blog\CommentRequest;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
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

    public function  postComment(CommentRequest $request)
    {
        $validation = new CommentRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        $post = Post::where('id', $request->post_id)->first();

        try {
            $user = Auth::user();
            $comment = Comment::create([
                'user_id' => $user->id,
                'comments' => $request->comment,
                'commentable_id' => $post->id,
                'commentable_type' => 'App\Models\Post'

            ]);
        }catch (\Exception $e){
            return $this->serverErrorAlert('someting  went  wrong', $e);
        }
        return $this->successResponse($comment);
    }
}
