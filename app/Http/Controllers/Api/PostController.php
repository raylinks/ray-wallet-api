<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Blog\PostAction;
use App\Http\Requests\Blog\PostRequest;
use App\Models\CvFormat;
use Illuminate\Http\Request;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use App\Traits\UploadImage;


class PostController extends Controller
{
    use HasApiResponses , UploadImage;

    public function submitPost(Request $request)
    {
        return(new PostAction())->execute(
            new PostRequest($request->all())
        );
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
