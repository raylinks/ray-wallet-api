<?php
namespace App\Http\Actions\Blog;
use App\Http\Requests\Blog\PostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

use Exception;
use App\Traits\HasApiResponses;
use Illuminate\Support\Facades\Auth;

class PostAction
{
    use HasApiResponses;

    public function  showPost($id)
    {
        $post = Post::where('id', $id)->withCount(['likes', 'comments'])->get();
        return $this->successResponse($post);
    }




    public function execute(PostRequest $request)
    {
        $validation = new PostRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
            return $this->formValidationErrorAlert($validation->errors());
        }
        $user = Auth::user();
        try{
        $post = Post::create([


            'user_id' => $user->id,
            'title' => $request->title,
            'body' => $request->body,
            'status' => false,
        ]);

        }catch(\Exception $e){
            return $this->serverErrorAlert($e);
        }
        $message = "You have created a post";
        return $this->successResponse($message);

    }

    public function showAllPostUser()
    {
        $post = Post::where('status', 1)->get();

        if(!$post)
        {
            return $this->notFoundAlert('No post was found.', []);
        }else{
            return $this->successResponse($post);
        }
    }

    public function showAllPostTOAdmin(): JsonResponse
    {
        $post = Post::all();

        if(!$post)
        {
            return $this->notFoundAlert('No post was found.', []);
        }else{
            return $this->successResponse($post);
        }
    }
    // PASS  the ID
    public  function PublishPost(): JsonResponse
    {
        try {
            // PASS  the ID

        $toActive = Post::where('status', 0)
            ->where('id', request()->id)
            ->update(['status' => 1]);
        if(!$toActive){
            $fromActive = Post::where('status', 1)
                ->where('id', request()->id)
                ->update(['status' => 0]);
        }else{
            return $this->successResponse('Post has been publish');
        }

        return $this->successResponse('Post unpublish');
        } catch (Exception $e) {
            return $this->serverErrorAlert( $e);
        }

    }

}
