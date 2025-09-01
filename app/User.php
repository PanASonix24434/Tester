<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use DB;
use Cache;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, UuidKey, SoftDeletes, Sortable;

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'contact_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_online_at' => 'datetime',
        'is_active' => 'boolean',
        'is_admin' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
        'is_admin' => false,
    ];

    /**
     * The sortable attributes.
     *
     * @var array
     */
    public $sortable = [
        'name',
        'username',
        'email',
    ];

    /**
     * Last online at sortable.
     *
     * @param $query
     * @param string $direction
     */
    public function lastOnlineSortable($query, $direction)
    {
        if ($direction == 'asc') {
            return $query->orderBy('last_online_at', 'DESC')->select('users.*');
        }
        else {
            return $query->orderBy('last_online_at')->select('users.*');
        }
    }

    /**
     * Status sortable.
     *
     * @param $query
     * @param string $direction
     */
    public function statusSortable($query, $direction)
    {
        if ($direction == 'asc') {
            return $query->orderBy('is_active', 'DESC')->select('users.*');
        }
        else {
            return $query->orderBy('is_active')->select('users.*');
        }
    }

    /**
     * Get admin user
     *
     */
    public static function getAdminUser()
    {
        return User::where('is_admin', true)->first();
    }

    /**
     * Check if user is online
     *
     */
    public function isOnline()
    {
        return Cache::has('user-is-online-'.$this->id);
    }

    /**
     * The roles that belong to the user.
     * 
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Authorization\Role', 'user_role');
    }

    /**
     * The modules that belong to the user.
     * 
     */
    public function modules()
    {
        return $this->belongsToMany('App\Models\Systems\Module', 'user_module');
    }

    /**
     * Check if user has role
     *
     * @param string $role
     */
    public function hasRole($role)
    {
        if ($this->roles->contains('id', $role) || $this->roles->contains('name', $role)) {
            return true;
        }
        return false;
    }

    /**
     * Check if user has module
     *
     * @param string $module
     */
    public function hasModule($module)
    {
        if ($this->modules->contains('id', $module) || $this->modules->contains('name', $module)) {
            return true;
        }
        return false;
    }

    /**
     * Check if user has permission through role
     *
     * @param string $module_id
     */
    public function hasPermissionByRole($module_id)
    {
        foreach ($this->roles as $role) {
            if ($role->modules->contains('module_id', $module_id)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has special permission
     *
     */
    public function hasSpecialPermission()
    {
        if (!empty(DB::table('user_module')->where('user_id', $this->id)->first())) {
            return true;
        }
        return false;
    }

    /**
     * Get all modules which user can access
     *
     */
    public function getAccess()
    {
        if ($this->hasSpecialPermission()) {
            return DB::table('modules')
                ->join('user_module', 'user_module.module_id', '=', 'modules.id')
                ->select('modules.*')
                ->distinct()
                ->get();
        }
        else {
            return DB::table('modules')
                ->join('role_module', 'role_module.module_id', '=', 'modules.id')
                ->join('user_role', 'user_role.role_id', '=', 'role_module.role_id')->where('user_role.user_id', $this->id)
                ->join('roles', 'roles.id', '=', 'user_role.role_id')
                ->select('modules.*')
                ->distinct()
                ->get();
        }
    }

    /**
     * Check if user has access to the module
     *
     * @param string $module
     */
    public function hasAccess($module)
    {
        $hasAccess = false;
        $modules = $this->getAccess();

        foreach ($modules as $m) {
            if (strcmp($m->name, $module) === 0 || strcmp($m->slug, $module) === 0 || strcmp($m->url, $module) === 0) {
                $hasAccess = true;
                break;
            }
        }
        return $hasAccess;
    }

    /**
     * Check if user is authorize to access the module / page
     *
     * @param string $module
     */
    public function isAuthorize($module)
    {
        if (!$this->hasAccess($module)) {
            return abort(401);
        }
    }
}