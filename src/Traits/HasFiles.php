<?php

namespace AKanaan\ModelFiles\Traits;

use AKanaan\ModelFiles\Exceptions\FileLabelIsNotDefinedException;
use AKanaan\ModelFiles\Helpers\FileUploader;
use AKanaan\ModelFiles\Models\File;
use AKanaan\ModelFiles\Observers\FilesObserver;
use Illuminate\Http\UploadedFile;
use Storage;

trait HasFiles
{
    /*
    |--------------------------------------------------------------------------
    | Files of the model
    |--------------------------------------------------------------------------
    |
    | this array contains many sub-arrays that should have the following keys
    | type => "single" | "array" // default is single
    | disk => // choose disk from available disks, default is "public"
    | path => // path in the disk, default is root folder of the disk "/" 
    |
    */
    // public $attaches = [];

    public static function bootHasFiles()
    {
        static::observe(FilesObserver::class);
    }

    public function attachFile(string $label, UploadedFile $uploadedFile)
    {
        return $this->attachFiles($label, [$uploadedFile]);
    }

    public function detachFile(string $label)
    {
        return $this->detachFile($label);
    }

    public function retrieveFile(string $label)
    {
        return $this->retrieveFiles($label)->first();
    }

    public function attachFiles(string $label, array $files = [])
    {
        if (isset($this->attaches[$label])) {
            $settings = $this->attaches[$label];
        } else {
            throw new FileLabelIsNotDefinedException($label);
        }
        foreach ($files as $file) {
            $data = array_merge(
                FileUploader::uploadFile($file, $settings['path'], $settings['disk']),
                ['label' => $label]
            );
            $this->files()->save(new File($data));
        }
        return $this->files()->get();
    }

    public function detachFiles(string $label, array $ids = null)
    {
        $files = $this->files($label)->when($ids, function ($query) use ($ids) {
            return $query->whereIn('id', $ids);
        })->get();
        $files->map(function ($item) {
            Storage::disk($item->disk)->delete($this->path . DIRECTORY_SEPARATOR . $this->name . '.' . $this->ext);
        });
        File::destroy($files->pluck('id'));
        return $this->files()->get();
    }

    public function retrieveFiles(string $label)
    {
        $files = $this->files($label)->get();
        return $files;
    }

    public function files($label = null)
    {
        return $this->morphMany(File::class, 'fileable')
            ->when($label, function ($query) use ($label) {
                return $query->where('label', $label);
            });
    }
}
