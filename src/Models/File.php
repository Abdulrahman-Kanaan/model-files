<?php

namespace AKanaan\ModelFiles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $table = 'files';
    protected $guarded = [];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function url()
    {
        $fullPath = $this->path . DIRECTORY_SEPARATOR . $this->name . '.' . $this->ext;
        return Storage::disk($this->disk)->url($fullPath);
    }
}
