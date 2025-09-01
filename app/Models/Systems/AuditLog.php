<?php

namespace App\Models\Systems;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Kyslik\ColumnSortable\Sortable;
use Auth;
use Browser;
use Carbon\Carbon;

class AuditLog extends Model
{
    use HasFactory, UuidKey, Sortable;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the default timestamps are used.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'array',
        'is_bot' => 'boolean',
        'is_in_app' => 'boolean',
        'created_at' => 'datetime',
    ];
    
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_bot' => false,
        'is_in_app' => false,
    ];

    /**
     * The sortable attributes.
     *
     * @var array
     */
    public $sortable = ['source', 'action', 'created_at'];

    /**
     * Create new audit log
     *
     * @param string $source
     * @param string $action
     * @param json $details
     * @param text $exception
     * @param uuid $table_id
     * @param bool $servertime
     */
    public function log($source, $action, $details = null, $exception = null, $table_id = null, $servertime = false)
    {
        //if (config('app.audit_log')) {
            $device_type = null;
            /*if (Browser::isMobile()) {
                $device_type = 'mobile';
            }
            else if (Browser::isTablet()) {
                $device_type = 'tablet';
            }
            else if (Browser::isDesktop()) {
                $device_type = 'desktop';
            }*/

            $audit = new AuditLog;
            $audit->table_id = $table_id;
            $audit->source = $source;
            $audit->action = $action;
            $audit->details = $details;
            $audit->exception = $exception;
            $audit->ip_address = \Request::ip();

            /*$audit->browser = Browser::browserName();
            $audit->browser_family = Browser::browserFamily();
            $audit->browser_version = Browser::browserVersion();
            $audit->browser_engine = Browser::browserEngine();

            $audit->platform = Browser::platformName();
            $audit->platform_family = Browser::platformFamily();
            $audit->platform_version = Browser::platformVersion();

            $audit->device_type = $device_type;
            $audit->device_family = Browser::deviceFamily();
            $audit->device_model = Browser::deviceModel();

            $audit->mobile_grade = Browser::mobileGrade();

            $audit->is_bot = Browser::isBot();
            $audit->is_in_app = Browser::isInApp();*/

            $audit->created_by = Auth::id();

            if (!$servertime) {
                $audit->created_at = Carbon::now();
            }

            $audit->save();
        //}
    }
}
