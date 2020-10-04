<?php

namespace AKanaan\ModelFiles\Helpers;

use Illuminate\Http\UploadedFile;
use Storage;
use Str;
class FileUploader {
    public static function uploadFile(UploadedFile $file, string $path = '/', string $disk = 'public') : array
    {
        $fname = Str::random(10) . time();
        $ext = $file->getClientOriginalExtension();
        $filename = $path . '/' . $fname . '.' . $ext;
        Storage::disk($disk)->put($filename, file_get_contents($file));
        return [
            'disk' => $disk,
            'path' => $path,
            'name' => $fname,
            'ext' => $ext
        ];
    }
}