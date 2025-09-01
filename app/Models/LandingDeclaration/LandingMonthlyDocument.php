<?php

namespace App\Models\LandingDeclaration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

//used for pengishtiharan pendaratan - reference landing_declarations
class LandingMonthlyDocument extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

    //tempatan
    const DOC_SALES_RECEIPT = 'RESIT JUALAN';
    const DOC_REASON = 'SURAT SEBAB';

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

}
