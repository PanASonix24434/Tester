<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use App\Models\User; 
class ProfileUsers extends Model
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
        'user_id',
        'name',
        'icno',
        'address1',
        'address2',
        'address3',
        'poskod',
        'district',
        'state',
        'parliament',
        'parliament_seat',
        'age',
        'gender',
        'user_type',
        'no_phone',
        'no_phone_office',
        'religion',
        'race',
        'wedding_status',
        'email',
        'salinan_ic',
        'no_vesel',
        'document',
        'is_active',
        'oku_status',
        'bumiputera_status',
        'created_by',
        'updated_by',
        'deleted_by',
        'verified_at',
        'verify_status',
        'verification_modal_shown',
        'ulasan',
        'type_id',
        'ref',
        'phone_code',
        'phone',
        'phone_office_code',
        'phone_office',
        'gender_id',
        'religion_id',
        'race_id',
        'marital_status_id',
        'status',
        'is_bumiputera',
        'is_active_ajim',
        'secondary_phone_number',
        'secondary_address_1',
        'secondary_address_2',
        'secondary_address_3',
        'secondary_postcode',
        'secondary_district',
        'secondary_state',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
   
    /**
     * The model's default values for attributes.
     *
     * @var array
     */

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function negeri()
   {
        return $this->belongsTo(CodeMaster::class, 'state');
   }

    public function daerah()
   {
        return $this->belongsTo(CodeMaster::class, 'district');
   }

  protected function getCodeMasterName($type, $value)
    {
        return CodeMaster::where('type', $type)
            ->where('id', $value)
            ->value('name'); // Change 'name' if your label column is different
    }

    public function getDistrictNameAttribute()
    {
        return $this->getCodeMasterName('district', $this->district);
    }

    public function getSecondaryDistrictNameAttribute()
    {
        return $this->getCodeMasterName('district', $this->secondary_district);
    }

    public function getStateNameAttribute()
    {
        return $this->getCodeMasterName('state', $this->state);
    }

    public function getSecondaryStateNameAttribute()
    {
        return $this->getCodeMasterName('state', $this->secondary_state);
    }



}
