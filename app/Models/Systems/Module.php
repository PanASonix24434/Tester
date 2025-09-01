<?php

namespace App\Models\Systems;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\UuidKey;
use Auth;

class Module extends Model
{
    use HasFactory, UuidKey;

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
        'is_active' => 'boolean',
        'is_menu' => 'boolean',
        'is_parent_menu' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
        'is_menu' => true,
        'is_parent_menu' => false,
    ];

    /**
     * Module has many childs.
     */
    public function childs()
    {
        return $this->hasMany('Module', 'parent_id');
    }

    /**
     * The roles that belong to the module.
     * 
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Authorization\Role', 'role_module');
    }

    /**
     * The users that belong to the module.
     * 
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_module');
    }

    /**
     * Get menus
     *
     * @param uuid $parent_id
     * @param bool $is_active
     * @param bool $is_menu
     */
    public function getMenus($parent_id = null, $is_active = true, $is_menu = true)
    {
        $menu = null;
        
        if (Auth::user()->hasSpecialPermission()) {
            $menu = $this->join('user_module', 'modules.id', '=', 'user_module.module_id')
                ->where('user_module.user_id', Auth::id());
        }
        else {
            $menu = $this->join('role_module', 'modules.id', '=', 'role_module.module_id')
                ->join('user_role', 'role_module.role_id', '=', 'user_role.role_id')->where('user_role.user_id', Auth::id())
                ->join('roles', 'user_role.role_id', '=', 'roles.id');
        }

        if ($menu != null) {
            if (!empty($parent_id)) {
                $menu->where('modules.parent_id', $parent_id);
            }
            else {
                $menu->whereNull('modules.parent_id');
            }

            if (!empty($is_active)) {
                $menu->where('modules.is_active', $is_active);
            }

            if (!empty($is_menu)) {
                $menu->where('modules.is_menu', $is_menu);
            }

            return $menu->select('modules.*')->orderBy('modules.order')->distinct()->get();
        }

        return $menu;
    }

    /**
     * Get all modules
     *
     * @param bool $is_active
     */
    public function getAll($is_active)
    {
        if (!empty($is_active)) {
            return $this->where('is_active', $is_active)
                ->orderBy('order', 'ASC')
                ->get();
        }
        return $this->where('is_active', $is_active)
            ->orderBy('order', 'ASC')
            ->get();
    }

    /**
     * Get modules
     *
     * @param uuid $parent_id
     * @param bool $is_active
     */
    public function getModules($parent_id = null, $is_active = true)
    {
        $modules = null;

        if (!empty($parent_id)) {
            $modules = $this->where('parent_id', $parent_id);
        }
        else {
            $modules = $this->whereNull('parent_id');
        }

        if (!empty($is_active) && !empty($modules)) {
            $modules->where('is_active', $is_active);
        }

        return !empty($modules) ? $modules->orderBy('order')->get() : null;
    }

    /**
     * Get module by name
     *
     * @param string $name
     */
    public static function getModuleByName($name)
    {
        return Module::where('name', $name)->first();
    }

    /**
     * Get module by url
     *
     * @param array $url
     */
    protected function getModuleByUrl($url)
    {
        $array = array();
        $url = strcmp($url[0], '/') === 0 ? ltrim($url, '/') : $url;
        $segments = explode('/', $url);
        foreach ($segments as $segment) {
            if (Str::isUuid($segment) || is_numeric($segment)) {
                $array[] = '{id}';
            }
            else {
                $array[] = $segment;
            }
        }
        $newUrl = '/'.implode('/', $array);

        $module = $this->where('url', $newUrl)->first();
        if (empty($module)) {
            $module = $this->where('url', 'like', $newUrl.'?%')->first();
        }
        
        return $module;
    }

    /**
     * Get module by id, name, slug, or url
     *
     * @param string $param
     */
    public function get($param)
    {
        $module = $this->where('name', $param)
            ->orWhere('slug', $param)
            ->orWhere('url', $param)
            ->first();
        if (empty($module)) {
            if (Str::isUuid($param)) {
                $module = $this->find($param);
            }
            else {
                $module = $this->getModuleByUrl($param);
            }
        }
        return $module;
    }

    /**
     * Return true if module has child
     *
     * @param uuid $id
     * @param bool $is_active
     */
    public function hasChild($id, $is_active = true)
    {
        if (!empty($this->where('parent_id', $id)->where('is_active', $is_active)->first())) {
            return true;
        }
        return false;
    }

    /**
     * Get list of childs
     *
     * @param uuid $id
     * @param bool $is_active
     */
    public function getChilds($id, $is_active = true)
    {
        return $this->where('parent_id', $id)
            ->where('is_active', $is_active)
            ->orderBy('order')
            ->get();
    }

    /**
     * Check if module has parent
     *
     * @param uuid $id
     */
    public function hasParent($id)
    {
        if (!empty($this->whereNotNull('parent_id')->where('id', $id)->first())) {
            return true;
        }
        return false;
    }

    /**
     * Get parent of a module
     *
     * @param uuid $param
     */
    public function getParent($param)
    {
        $module = $this->get($param);
        return !empty($module) ? $this->find($module->parent_id) : null;
    }

    /**
     * Get parent url of a module
     *
     * @param string $param
     */
    public function getParentUrl($param)
    {
        if (!empty($this->getParent($param))) {
            if ($this->getParent($param)->is_parent_menu) {
                return '#';
            }
            else return $this->getParent($param)->url;
        }
        else return '#';
    }

    /**
     * Check if module has grandparent
     *
     * @param uuid $id
     */
    public function hasGrandParent($id)
    {
        $module = $this->find($id);
        $parent = !empty($module) ? $this->find($module->parent_id) : null;
        if (!empty($parent) && !empty($parent->parent_id)) {
            return true;
        }
        return false;
    }

    /**
     * Get grandparent of a module
     *
     * @param uuid $param
     */
    public function getGrandParent($param)
    {
        $module = !empty($this->getParent($param)) ? $this->find($this->getParent($param)->id) : '';
        return !empty($module) ? $this->find($module->parent_id) : null;
    }

    /**
     * Get grandparent url of a module
     *
     * @param string $param
     */
    public function getGrandParentUrl($param)
    {
        return !empty($this->getGrandParent($param)) ? 
            $this->getGrandParent($param)->is_parent_menu ? 
            '#' : 
            $this->getGrandParent($param)->url : '#';
    }

    /**
     * Localize the module name
     *
     * @param string $name
     */
    public function localize($name)
    {
        //$name = strtolower(str_replace(' ', '_', $name));
        $localeName = $name;
        foreach (__('module') as $key => $value) {
            if ($key == $name) {
                $localeName = $value;
                break;
            }
        }
        //Disable CamelCase
        //return ucwords(str_replace('_', ' ', $localeName));
        return str_replace('_', ' ', $localeName);
    }


    /************************* Start: Function used for seeder *************************/
    public static function seed($name, $name_eng, $slug, $url, $icon, $order, $is_parent_menu = false, $is_menu = true, $parent_name = null)
    {
        if (empty(Module::where('name', $name)->first())) {
            $module = new Module;
            $module->parent_id = !empty($parent_name) ? Module::getModuleByName($parent_name)->id : null;
            $module->name = $name;
            $module->name_eng = $name_eng;      //Asyraf 20220905
            $module->slug = $slug;
            $module->url = $url;
            $module->icon = $icon;
            $module->order = $order;
            $module->is_menu = $is_menu;
            $module->is_parent_menu = $is_parent_menu;
            $module->created_by = \App\Models\User::getAdminUser()->id;
            $module->save();
            $module->users()->attach(\App\Models\User::getAdminUser());
        }
    }

    public static function seedChild($name, $name_eng, $slug, $url, $order, $parent_name, $is_menu = true, $icon = 'fas fa-arrow-circle-right') //Arifah 20220904
    {

        $module = new Module;
        $module->parent_id = Module::getModuleByName($parent_name)->id;
        $module->name = $name;
        $module->name_eng = $name_eng;
        $module->slug = $slug;
        $module->url = $url;
        $module->icon = $icon;
        $module->order = $order;
        $module->is_menu = $is_menu;
        $module->created_by = \App\Models\User::getAdminUser()->id;
        $module->save();
        $module->users()->attach(\App\Models\User::getAdminUser());
    }
    /************************* End: Function used for seeder *************************/
}
