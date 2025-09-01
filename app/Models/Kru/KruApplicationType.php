<?php

namespace App\Models\Kru;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;

class KruApplicationType extends Model
{
    use HasFactory, UuidKey, SoftDeletes;
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
        'name',
    ];

	public static function seed($code, $name, $type)
    {
            $kru_application_type = new KruApplicationType();
            $kru_application_type->code = $code;
            $kru_application_type->name = $name;
            $kru_application_type->type = $type;
            $kru_application_type->created_by = \App\Models\User::getAdminUser()->id;
            $kru_application_type->updated_by = \App\Models\User::getAdminUser()->id;
            $kru_application_type->save();
    }
}