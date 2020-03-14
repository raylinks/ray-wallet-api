<?php

namespace App\Http\Actions;


use App\Http\Requests\RegisterRequest;
use App\Jobs\EmailVerification;
use App\Mail\ConfirmEmail;
use App\User;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;



class AuthenticationAction
{
    use HasApiResponses;

    public function execute(RegisterRequest $request)
    {

        $validation = new RegisterRequest($request->all());

        $validation = Validator::make($validation->all(), $validation->rules(), $validation->messages());

        if ($validation->fails()) {
         return $this->formValidationErrorAlert($validation->errors());
        }


        $url = config('app.url');
        $callback_url = $request->callback_url;
        $user = new User;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_token = $this->random_str(6);
        $user->save();


        $call_back_url = base64_encode($callback_url);
        $user_id = base64_encode($user->id);
        $url .= "/verify?redirect_callback=" . $call_back_url . "&email_token=$user->email_token" . "&user_id=$user_id";


        $data = [];
        if ($user) {
            $user->assignRole('writer');
            $user->givePermissionTo('edit articles');
            $data['email_token'] = $user->email_token;
            $data['url'] = $url;
            $data['email'] =$user->email ;

        }
        // Send Confirm Email Notification to User
        try {
            dispatch(new  EmailVerification([
                'user' => $data
            ]));
            // Notification::send($user, new WelcomeNotify($data));
        } catch (Exception $e) {
        }


        return JSON(200, $user->toArray(), 'A confirmation mail has been sent to youe email, please check to confirm');

    }

    private function random_str($length, $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }

        return $str;
    }


    public function imageUpload(Request $request): JsonResponse
    {
        $user = Auth::user();
        $ext = "only supported jpeg files";
        $extension = $request->file('avatar')->extension();
        $os = array("jpeg", "png");
        if (!in_array("ooo", $os))
       {
           return $this->formValidationErrorAlert(ooo);
       }

        // store file locally
        Storage::disk('local')->put('file.txt', 'Contents');

        Storage::disk('s3')->put('avatars/1', $fileContents);
        $path = Storage::putFile('avatars', $request->file('avatar'));

        $path = $request->file('avatar')->store('avatars');
       $fileee =  $request->file('avatar')->store::putFileAs('ray_image_bucket', 'gcp',$user->id);
        $path = Storage::putFile('avatars', $request->file('avatar'));
        return $fileee;
    }


    public function updateProfileImage(Request $request): JsonResponse
    {
        if (!isset($_FILES['file']['name'])) {
            return JSON(400, ['fail' => true, 'message' => 'No image selected'], 'error');
        }//$request->file('name');

        $user = User::whereUuid($request->user_uuid)->first();
        $fail = false;
        $message = 'success';
        $file = $_FILES['file'];
        $extension = $this->getFileExtension($file['name']);
        $fileName = str_shuffle(md5(time() . $user->uuid)) . ".{$extension}";
        $bucketUrl = Storage::disk('profile_pictures')->url('');

        try {
            $uploadDirectory = storage_path('app/public/profile_pictures');

            if (!file_exists($uploadDirectory) && !mkdir($uploadDirectory) && !is_dir($uploadDirectory)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $uploadDirectory));
            }

            if (move_uploaded_file($file['tmp_name'], "{$uploadDirectory}/{$fileName}")) {
                $contents = Storage::disk('local_profile_pics')->get($fileName);

                $s3FileName = $user->profile_pic !== 'user_default.png'
                    ? str_replace($bucketUrl, '', $user->profile_pic)
                    : '';

                if (Storage::disk('profile_pictures')->put($fileName, $contents)) {
                    Storage::disk('profile_pictures')->delete($s3FileName);
                    $user->profile_pic = $fileName;
                    $user->save();

                    $fail = false;

                    Storage::disk('local_profile_pics')->delete($fileName);
                }
            }

            return JSON(200, [
                'fail' => $fail,
                'storage' => $bucketUrl . $user->profile_pic,
                'image' => $user->profile_pic,
                'status' => $message,
            ], $message);
        } catch (Exception $exception) {
            Storage::disk('local_profile_pics')->delete($fileName);

            return JSON(200, ['fail' => true], $exception->getMessage());
        }
    }

}
