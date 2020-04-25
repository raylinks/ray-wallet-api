<?php
namespace App\Http\Actions\Blog;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\HasApiResponses;
use Illuminate\Support\Facades\Auth;

class PostAction
{
    use HasApiResponses;

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
            'content' => $request->blog_content,
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

    public function showAllPostTOAdmin()
    {
        $post = Post::all();

        if(!$post)
        {
            return $this->notFoundAlert('No post was found.', []);
        }else{
            return $this->successResponse($post);
        }
    }

    public  function PublishPost(): JsonResponse
    {
        try {

        $toActive = Post::where('is_paid', 0)
            ->where('id', request()->id)
            ->update(['is_paid' => 1]);
        if(!$toActive){
            $fromActive = Post::where('is_paid', 1)
                ->where('id', request()->id)
                ->update(['is_paid' => 0]);
        }else{
            return $this->successResponse('Post has been publish');
        }

        return $this->successResponse('Post unpublish');
        } catch(\Exception $e)   {
            return $this->serverErrorAlert('sometin went  wron');
        }

    }

}
