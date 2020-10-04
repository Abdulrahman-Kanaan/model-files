<?php

namespace AKanaan\ModelFiles\Observers;

class FilesObserver
{
    public function deleted($model)
    {
        $model->files()->delete();
    }
}
