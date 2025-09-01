<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ProfileCompany extends Model
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
        'company_name',
        'company_reg_no',
        'company_reg_date',
        'lhdn_account_no',
        'current_address1',
        'current_address2',
        'current_address3',
        'current_postcode',
        'current_district',
        'current_state_id',
        'letter_address1',
        'letter_address2',
        'letter_address3',
        'letter_postcode',
        'letter_district',
        'letter_state_id',
        'phone_no',
        'fax_no',
        'email',
        'company_sec',
        'ownership',
        'bumiputera_status',
        'company_status',
        'modal_allow',
        'modal_paid',
        'company_business',
        'company_exp_fish',
        'company_exp_other',
        'user_id',

    ];
}
