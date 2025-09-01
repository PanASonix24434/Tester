<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;
use App\Models\Systems\Module;
use App\Models\Systems\AuditLog;
use App\Models\Helper;
use Illuminate\Database\Schema\Blueprint;

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

        Blueprint::macro('auditField', function ($deleted = true, $updated = true, $created = true) {
            if ($created) {
                $this->foreignUuid('created_by')->nullable()->constrained('users');
                if (!$updated) {
                    $this->timestamp('created_at')->nullable()->useCurrent();
                } else {
                    $this->timestamp('created_at')->nullable();
                }
            }
            if ($updated) {
                $this->foreignUuid('updated_by')->nullable()->constrained('users');
                $this->timestamp('updated_at')->nullable();
            }
            if ($deleted) {
                $this->foreignUuid('deleted_by')->nullable()->constrained('users');
                $this->softDeletes();
            }
        });

        Blueprint::macro('dropAuditField', function ($deleted = true, $updated = true, $created = true) {
            if ($created) {
                $this->dropForeign(['created_by']);
                $this->dropColumn(['created_by', 'created_at']);
            }
            if ($updated) {
                $this->dropForeign(['updated_by']);
                $this->dropColumn(['updated_by', 'updated_at']);
            }
            if ($deleted) {
                $this->dropForeign(['deleted_by']);
                $this->dropColumn('deleted_by');
                $this->dropSoftDeletes();
            }
        });
    }
}
