<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Appointment extends Model
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
        'id',
        'user_id',
        'username',
        'name',
        'icno',
        'level',
        'email',
        'role',
        'state',
        'district',
        'duty_office',
        'department',
        'report_date',
        'ic_file_path',
        'ic_file_name',
        'letter_file_path',
        'letter_file_name',
        'inactive_date',
        'inactive_note',
        'inactive_file_path',
        'inactive_file_name',
        'status_id',
        'created_by',
        'created_date',
        'updated_by',
        'updated_date'
       
    ];

    /**
     * The sortable attributes.
     *
     * @var array
     */
    public $sortable = [
        'name',
        'username',
        'state',
    ];
}
