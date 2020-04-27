<?php
namespace App\Http\Actions\Blog;

use App\Models\Like;

use App\Models\Post;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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


    public function UnLikePost($id)
    {
        $user = Auth::user();
        # Get all the post where the id is the same as the id being passed in the function
        $like = new Like();
        $post = Post::where('id', $id)->first();
        if(count($post))
        {

            Like::where('user_id',1)->delete();
        }
        # create an object of the like Model
        return $this->successResponse($post);
    }

}
