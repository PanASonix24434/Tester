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
use App\Models\LandingDeclaration\LandingDeclarationMonthly;

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
        'user_type',
        'bumiputera_type',
        'address1',
        'address2',
        'address3',
        'postcode',
        'district',
        'state_id',
        'contact_number',
        'mobile_contact_number',
        'start_date',
        'end_date',
        'watikah_status',
        'entity_id',
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
        } else {
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
        } else {
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
        return Cache::has('user-is-online-' . $this->id);
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
        } else {
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

    public function profile()
    {
        return $this->hasOne(ProfileUsers::class, 'user_id');
    }

    public function vessels()
    {
        return $this->hasMany(Vessel::class, 'user_id');
    }

    public function profilePentadbirHartas()
    {
        return $this->hasMany(ProfilePentadbirHarta::class);
    }

    public function hasProfilePentadbirHarta()
    {
        return $this->profilePentadbirHartas()->exists();
    }

    public function company()
    {
        return $this->hasOne(MaklumatSyarikat::class, 'user_id');
    }

    // Faris===========================================================================================================

    public function userRoles()
    {
        return $this->belongsToMany('App\Models\Authorization\Role', 'user_role', 'user_id', 'role_id');
    }

    public function entityUser()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }

    public function userDetail()
    {
        return $this->hasOne(darat_user_detail::class, 'user_id', 'id');
    }

    public function baseJetty()
    {
        return $this->hasOne(darat_base_jetties::class, 'user_id', 'id');
    }

    public function fishermanInfo()
    {
        return $this->hasOne(darat_user_fisherman_info::class, 'user_id');
    }

    public static function hasMinimumLanding($userId)
    {

        $landingRequirementMet = LandingDeclarationMonthly::where('user_id',$userId)->get()->count() >= 3;
        // DB::table('landing_infos')
        //     ->join('landing_declarations', 'landing_infos.landing_declaration_id', '=', 'landing_declarations.id')
        //     ->where('landing_declarations.user_id', $userId)
        //     ->selectRaw('YEAR(landing_infos.landing_date) as landing_year, MONTH(landing_infos.landing_date) as landing_month, COUNT(DISTINCT landing_infos.landing_date) as total_days')
        //     ->groupByRaw('YEAR(landing_infos.landing_date), MONTH(landing_infos.landing_date)')
        //     ->having('total_days', '>', 25)
        //     ->get()
        //     ->count() >= 3;

        //  $landingRequirementMet = DB::table('landing_infos')
        // ->join('landing_declarations', 'landing_infos.landing_declaration_id', '=', 'landing_declarations.id')
        // ->where('landing_declarations.user_id', $userId)
        // ->selectRaw('YEAR(landing_infos.landing_date) as landing_year, MONTH(landing_infos.landing_date) as landing_month, COUNT(DISTINCT landing_infos.landing_date) as total_days')
        // ->groupByRaw('YEAR(landing_infos.landing_date), MONTH(landing_infos.landing_date)')
        // ->having('total_days', '>=', 1) // ? Minimum 1 day
        // ->get()
        // ->count() >= 1;

        return $landingRequirementMet;
    }

    public function vessel()
    {
        return $this->hasOne(darat_vessel::class, 'user_id');
    }

    public function hull()
    {
        return $this->hasOne( darat_vessel_hull::class, 'user_id', 'id');
    }

    public function engine()
    {
        return $this->hasOne( darat_vessel_engine::class, 'user_id', 'id');
    }
}
