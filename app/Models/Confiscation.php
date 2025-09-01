<?php

namespace App\Models;

use App\Traits\UuidKey;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confiscation extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $table = 'confiscation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'fullname', 
    'icno', 
    'lucut_hak',
    'remark_fad',
    'update_by',
    'support_lucut',
    'remark_kdp',
    'support_by',
    'approve_lucut',
    'remark_fan',
    'status',
    'approve_by'];
}
