<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class CodeMaster extends Model
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
        'type', 'code', 'name', 'order',
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
        'type', 'code', 'name', 'name_ms',
    ];

    /**
     * Status sortable.
     *
     * @param $query
     * @param string $direction
     */
    public function statusSortable($query, $direction)
    {
        if ($direction == 'asc') {
            return $query->orderBy('is_active', 'DESC')->select('code_masters.*');
        }
        else {
            return $query->orderBy('is_active', 'ASC')->select('code_masters.*');
        }
    }

    public static function isOrder($code_master)
    {
        $rtn = false;
        foreach (CodeMaster::orderByOrder() as $item) {
            if (strcasecmp($code_master, $item) === 0) {
                $rtn = true;
                break;
            }
        }
        return $rtn;
    }

    public static function orderByOrder()
    {
        return array('races', 'citizenships', 'genders', 'academics');
    }

    public static function getCodeMasterIdByTypeName($type, $name)
    {
        return !empty(CodeMaster::where('type', $type)->where('name', $name)->first()) ? CodeMaster::where('type', $type)->where('name', $name)->first()->id : '';
    }

    public static function seed($type, $code, $name, $name_ms, $order = null, $parent = null, $parent_name = null)
    {
        $parent_id = null;

        if (!empty($parent)) {
            $items = json_decode($parent);
            $parent_model = CodeMaster::where('type', $items->type)->where('name', $items->name)->first();
            if (!empty($parent_model)) {
                $parent_id = $parent_model->id;
            }
        }

        if (!CodeMaster::seedExists($type, $name, $code, $parent_id)) {
            $code_master = new CodeMaster;
            $code_master->parent_id = $parent_id;
            $code_master->parent_name = $parent_name;
            $code_master->type = $type;
            $code_master->code = $code;
            $code_master->name = $name;
            $code_master->name_ms = $name_ms;
            $code_master->order = $order;
            $code_master->created_by = \App\Models\User::getAdminUser()->id;
            $code_master->updated_by = \App\Models\User::getAdminUser()->id;
            $code_master->save();
        }
    }

   
public static function seedExists($type, $name, $code = null, $parent_id = null)
{
    return false;
}


    // public static function seedExists($type, $name, $code = null, $parent_id = null)
    // {
    //     $code_master = CodeMaster::where('type', $type);

    //     if (!empty($code)) {
    //         $code_master->where(function ($query) use ($name, $code) {
    //                 $query->where('name', $name)
    //                     ->orWhere('code', $code);
    //             });
    //     }
    //     else {
    //         $code_master->where('name', $name);
    //     }

    //     if (!empty($parent_id)) {
    //         $code_master->where('parent_id', $parent_id);
    //     }

    //     return $code_master->get()->count() >= 1 ? true : false;
    // }

//     public static function seedExists($type, $name, $code = null, $parent_id = null)
// {
//     $code_master = CodeMaster::where('type', $type);

//     if (!empty($code)) {
//         // Check for exact match: same type, same name, and same code
//         $code_master->where('name', $name)->where('code', $code);
//     } else {
//         // Only check by name if code is not provided
//         $code_master->where('name', $name);
//     }

//     if (!empty($parent_id)) {
//         $code_master->where('parent_id', $parent_id);
//     }

//     return $code_master->exists();
// }

	
	/**
	* The application premises that belong to the premise details.
	* 
	*/
    public function application_premises()
    {
        return $this->belongsToMany('App\Models\ApplicationPremise', 'application_premise_details');
    }

    public static function getApplicationTypeByCode($code)
    {
        return self::where('type', 'application_type')
                    ->where('code', $code)
                    ->first(); 
    }
    
public function districts()
{
    return $this->hasMany(CodeMaster::class, 'parent_id')->where('type', 'district');
}

public function state()
{
    return $this->belongsTo(CodeMaster::class, 'parent_id')->where('type', 'state');
}

    

        public static function getApplicationStatusByCode($code)
    {
        return self::where('type', 'application_status')
            ->where('code', $code)
            ->first();
    }
}
