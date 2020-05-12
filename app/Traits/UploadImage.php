<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadImage
{
    public function uploadFile(UploadedFile $file, $folder, $disk)
    {
        if (!$file instanceof  UploadedFile) {
            return false;
        }

        return $file->store($folder, $disk);
    }

    public function deleteFile($path = null, $disk = 'public')
    {
        Storage::disk($disk)->delete($path);
    }
}
