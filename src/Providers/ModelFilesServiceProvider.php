<?php

namespace AKanaan\ModelFiles\Providers;

use Illuminate\Support\ServiceProvider;

class ModelFilesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // $this->publishes([
        //     __DIR__.'/../../config/model-files.php' => config_path('model-files.php')
        // ], 'model-files-config');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    public function register()
    {
    }
}
