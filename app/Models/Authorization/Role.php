<?php

namespace App\Models\Authorization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Role extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

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

    protected $fillable = [
        'quota',
        'level',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * The sortable attributes.
     *
     * @var array
     */
    public $sortable = ['name'];

    /**
     * The users that belong to the role.
     * 
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_role');
    }

    /**
     * The modules that belong to the role.
     * 
     */
    public function modules()
    {
        return $this->belongsToMany('App\Models\Systems\Module', 'role_module');
    }

    /**
     * Check if role has module
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
}
