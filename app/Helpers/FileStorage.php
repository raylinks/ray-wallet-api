<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class FileStorage
{
    /**
     * Upload file to specified disks.
     *
     * @param $uploadedFile
     * @param $disk
     * @param string $filePrefix
     *
     * @return bool|string
     */
    public static function upload($uploadedFile, $disk, $filePrefix = '')
    {
        if (is_array($uploadedFile)) {
            foreach ($uploadedFile as $file) {
                $uploadedFiles = static::upload($file, $disk, $filePrefix);
            }

            return $uploadedFiles;
        }

        if (! $uploadedFile instanceof File) {
            return false;
        }
//dd($uploadedFile);
        $fileName = sprintf(
            '%s.%s',
            (is_string($filePrefix) && ! empty($filePrefix) ? $filePrefix : Str::random(10)) . '_' . time(),
            $uploadedFile->extension()
        );

        dd($fileName);

        return Storage::disk($disk)->putFileAs('/', $uploadedFile, $fileName) ? $fileName : false;
    }
}
