<?php

namespace App\Models\SubsistenceAllowance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubsistenceListQuota extends Model
{
    
    use HasFactory, UuidKey, SoftDeletes, Sortable;

    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $table = 'subsistence_list_quota';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'generated_date', 'total_applicants', 'quota', 'status', 'entities_id','year','phase'
       
    ];
}
