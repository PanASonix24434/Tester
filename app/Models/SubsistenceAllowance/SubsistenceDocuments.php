<?php

namespace App\Models\SubsistenceAllowance;


use App\Traits\UuidKey;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsistenceDocuments extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $table = 'subsistence_doc';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_path', 'file_detail', 'updated_by'
       
    ];
}
