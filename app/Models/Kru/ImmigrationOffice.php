<?php

namespace App\Models\Kru;

use App\Models\CodeMaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ImmigrationOffice extends Model
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

	public static function seed($name,$address1,$address2,$address3,$postcode,$city,$state,$office_number,$office_fax)
    {
        $state_id = null;
        if (!empty($state)) {
            $items = json_decode($state);
            $parent_model = CodeMaster::where('type', $items->type)->where('name', $items->name)->first();
            if (!empty($parent_model)) {
                $state_id = $parent_model->id;
            }
        }

        $immigration_office = new ImmigrationOffice();
        $immigration_office->name = $name;
        $immigration_office->address1 = $address1;
        $immigration_office->address2 = $address2;
        $immigration_office->address3 = $address3;
        $immigration_office->postcode = $postcode;
        $immigration_office->city = $city;
        // $immigration_office->district_id = $district_id;
        $immigration_office->state_id = $state_id;
        $immigration_office->office_number = $office_number;
        // $immigration_office->office_email = $office_email;
        $immigration_office->office_fax = $office_fax;
        $immigration_office->created_by = \App\Models\User::getAdminUser()->id;
        $immigration_office->updated_by = \App\Models\User::getAdminUser()->id;
        $immigration_office->save();
    }
}