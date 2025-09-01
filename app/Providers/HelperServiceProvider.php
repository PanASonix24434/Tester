<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $path = app_path('Helpers');
        if (File::exists($path)) {
            $files = File::files($path);
            foreach ($files as $file) {
                if (File::exists($file)) {
                    require_once($file);
                }
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
