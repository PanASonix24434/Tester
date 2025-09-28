<?php

namespace App\Models\Kru;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class KruApplication extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

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
        'kru_application_type_id',
        'user_id',
        'applicant_type',
        'profile_user_id',
        'vessel_id',
        'reference_number',
        'kru_application_status_id',
        'entity_id',
        'submitted_at',
        'start_counting_at',
        'registration_number',
        'registration_start',
        'registration_end',
        'pin_number',
        'ssd_number',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
	
    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [
       'submitted_at' => 'datetime',
       'registration_start' => 'date',
       'registration_end' => 'date',
   ];

}
