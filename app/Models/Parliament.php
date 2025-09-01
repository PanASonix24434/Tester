<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Parliament extends Model
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
        'parliament_code',
        'parliament_name',
        'state_id',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    protected $attributes = [
        'is_deleted' => false,
    ];

    public static function seed($code, $name, $state = null)
    {
        $state_id = null;

        if (!empty($state)) {
            $items = json_decode($state);
            $parent_model = CodeMaster::where('type', $items->type)->where('name', $items->name)->first();
            if (!empty($parent_model)) {
                $state_id = $parent_model->id;
            }
        }

        if (!Parliament::seedExists($code, $name, $state_id)) {
            $parliament = new Parliament;
            $parliament->parliament_code = $code;
            $parliament->parliament_name = $name;
            $parliament->state_id = $state_id;
            $parliament->created_by = \App\Models\User::getAdminUser()->id;
            $parliament->updated_by = \App\Models\User::getAdminUser()->id;
            $parliament->save();
        }
    }

    public static function seedExists($code, $name, $state_id = null)
    {
        $parliament = Parliament::where('parliament_code', $code)
        ->where('parliament_name', $name);

        if (!empty($state_id)) {
            $parliament->where('state_id', $state_id);
        }

        return $parliament->get()->count() >= 1 ? true : false;
    }



   public function seats()
   {
       return $this->hasMany(ParliamentSeat::class, 'parliament_id', 'id');
   }


}
