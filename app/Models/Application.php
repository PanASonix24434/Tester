<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Application extends Model
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
        'individual_type_id',
        'rate_type_id',
        'applicant_type_id',
        'fullname',
        'icno',
        'ic_no',
        'full_name',
        'home_address1',
        'home_address2',
        'home_address3',
        'home_postcode',
        'home_city',
        'home_state_id',
        'no_years_stayed',
        'type_of_residence_id',
        'marital_status_id',
        'no_of_children',
        'education_level_id',
        'phone_no',
        'mobile_phone_no',
        'emergency_contact_name',
        'emergency_contact_no',
        'emergency_contact_relationship',
        'email',
        'date_of_birth',
        'citizenship',
        'bumiputera_status',
        'length_of_service_years',
        'length_of_service_months',
        'employment_category_id',
        'designation',
        'occupation',
        'monthly_income',
        'annual_sales_turnover',
        'source_of_fund',
        'source_of_wealth',
        'type_of_entity_id',
        'nature_of_business',
        'no_fulltime_employee',
        'name_of_employer',
        'office_address1',
        'office_address2',
        'office_address3',
        'office_postcode',
        'office_city',
        'office_state_id',
        'office_phone_no',
        'application_status_id',
        'dealer_code',
        'previous_company_name',
        'previous_length_of_service',
    ];

}
