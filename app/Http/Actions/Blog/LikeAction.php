<?php
namespace App\Http\Actions\Blog;

use App\Http\Requests\Blog\UnlikeRequest;
use App\Http\Requests\RoleRequest;
use App\Models\Like;

use App\Models\Post;
use App\Traits\HasApiResponses;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LikeAction
{
    use HasApiResponses;


    public function LikePost($id): JsonResponse
    {
        $user = Auth::user();
        # Get all the post where the id is the same as the id being passed in the function
        $post = Post::where('id', $id)->first();
        # create an object of the like Model
        $like = new Like();
        $like->user_id =1;
        $like->post_id = $post->id;
        $post->likes()->save($like);
        return $this->successResponse($post);
    }


    public function UnLikePost(UnlikeRequest $id)
    {
        $validation = new UnlikeRequest(request()->all());
        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());
        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        # Get all the post where the id is the same as the id being passed in the function
        $like = new Like();
        $post = Post::where('id', $id)->first();
        if(count(array($post)))
        {
           $unlike = Like::where('user_id',request()->user_id)->delete();
        }
        # create an object of the like Model
        return $this->successResponse($unlike);
    }

}
