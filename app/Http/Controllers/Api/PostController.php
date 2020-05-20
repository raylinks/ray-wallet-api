<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Blog\PostAction;
use App\Http\Requests\Blog\PostRequest;
use App\Models\CvFormat;
use Illuminate\Http\Request;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Traits\UploadLocalImage;
use App\Traits\UploadImage;


class PostController extends Controller
{
    use HasApiResponses , UploadImage,UploadLocalImage;

    // public function submitPost(Request $request)
    // {
    //     return(new PostAction())->execute(
    //         new PostRequest($request->all())
    //     );
    // }

    public function submitPost(Request $request)
    {
         $validation = new PostRequest($request->all());

         $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

         if ($validation->fails()) {
             return $this->formValidationErrorAlert($validation->errors());
         }
//        $this->validate($request, [
//            'title' => 'required|string',
//            'image[]' => 'image|nullable|mimes:jpeg,jpg,png,gif',
//            'body' => 'required|string'
//
//        ]);
        $user = Auth::user();
        try{

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImages($request->file('image'));
              
                if (! $imagePath) {
                    $this->badRequestAlert('Image not uploadable');
                }
    
            }
        $post = Post::create([


            'user_id' =>1,
            'title' => $request->title,
            'body' => $request->body,
            'picture' => $imagePath,
            'status' => false,
        ]);

        }catch(\Exception $e){
            return $this->serverErrorAlert($e);
        }
        $message = "You have created a post";
        return $this->successResponse($message);

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

    public function photo(Request $request): JsonResponse
    {
        $cv_format  = CvFormat::where('id', $request->id);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image'), 'cards', 'public');
            if (! $imagePath) {
                $this->badRequestAlert('Image not uploadable');
            }
            dd($imagePath);
        }
        return $this->successResponse('Success,Your Image has been successful');

    }

    public function UpdatePost(Request $request ,$id): JsonResponse
    {
        return(new PostAction())->updatePost($request ,$id);
    }






}
