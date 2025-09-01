<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Entity extends Model
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id','entity_name','entity_level','state_code','entity_id',
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
    public $sortable = [
        'entity_level', 'entity_name',
    ];

    /**
     * Status sortable.
     *
     * @param $query
     * @param string $direction
     */

    public static function seed($parent_id, $entity_name, $entity_level, $state_code)
    {

        if (!empty($parent_id)) {
            $items = json_decode($parent_id);
            $parent_model = Entity::where('entity_name', $items->entity_name)->first();
            if (!empty($parent_model)) {
                $parent_id = $parent_model->id;
            }
        }

        if (!Entity::seedExists($entity_name, $parent_id)) {
            $entity = new Entity;
            $entity->parent_id = $parent_id;
            $entity->entity_name = $entity_name;
            $entity->entity_level = $entity_level;
            $entity->state_code = $state_code;

            $entity->created_by = \App\Models\User::getAdminUser()->id;
            $entity->updated_by = \App\Models\User::getAdminUser()->id;
            $entity->save();
        }
    }

    public static function seedExists($entity_name, $parent_id)
    {
        $entity = Entity::where('entity_name', $entity_name);

        if (!empty($parent_id)) {
            $entity->where('parent_id', $parent_id);
        }

        return $entity->get()->count() >= 1 ? true : false;
    }

    
    //////////Faris////////////

    public function parentEntity()
    {
        return $this->belongsTo(Entity::class, 'parent_entity_id');
    }

    public function getChildEntities()
    {
        return Entity::where('parent_id', $this->id)->pluck('id')->toArray();
    }

    public function entities()
    {
        return $this->belongsToMany(Entity::class, 'entity_location', 'location_nd_id', 'entity_id');
    }

    // In Entity.php model
    public function users()
    {
        return $this->hasMany(User::class, 'entity_id', 'id');
    }
    //////////////////Faris///////////////////
}
