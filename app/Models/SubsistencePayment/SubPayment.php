<?php

namespace App\Models\SubsistencePayment;


use App\Traits\UuidKey;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPayment extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $table = 'subsistence_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      //  'status_quota', 'batch_id', 'bank_id', 'no_account', 'state_bank_id'
    ];
	
    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [
      //   'is_approved_jkk' => 'boolean',
   ];
}
