<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;
use App\Models\Systems\Module;
use App\Models\Systems\AuditLog;
use App\Models\Helper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $this->app->bind('Module', function($app) {
            return new Module;
        });

        $this->app->bind('Audit', function($app) {
            return new AuditLog;
        });

        $this->app->bind('Helper', function($app) {
            return new Helper;
        });
    }
}
