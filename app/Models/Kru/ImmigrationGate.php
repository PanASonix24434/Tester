<?php

namespace App\Models\Kru;

use App\Models\CodeMaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ImmigrationGate extends Model
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
    ];

    /**
     * The sortable attributes.
     *
     * @var array
     */
    public $sortable = [
        'name',
    ];

	public static function seed($name, $gate_type = 'DARAT', $state)
    {
        $state_id = null;
        if (!empty($state)) {
            $items = json_decode($state);
            $parent_model = CodeMaster::where('type', $items->type)->where('name', $items->name)->first();
            if (!empty($parent_model)) {
                $state_id = $parent_model->id;
            }
        }

        $immigration_gate = new ImmigrationGate();
        $immigration_gate->name = $name;
        $immigration_gate->gate_type = $gate_type; //DARAT, UDARA, LAUT
        $immigration_gate->state_id = $state_id;
        $immigration_gate->created_by = \App\Models\User::getAdminUser()->id;
        $immigration_gate->updated_by = \App\Models\User::getAdminUser()->id;
        $immigration_gate->save();
    }
}