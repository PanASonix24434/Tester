<?php

namespace App\Models\LandingDeclaration;


use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingInfoActivity extends Model
{
    use HasFactory, UuidKey, SoftDeletes;

    protected $keyType = 'string';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'landing_info_activities';

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
	
    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [
      // 'time' => 'datetime:H:i:s',
   ];

    // Relationships
    public function landingInfo()
    {
        return $this->belongsTo(LandingInfo::class);
    }

    public function activityType()
    {
        return $this->belongsTo(LandingActivityType::class, 'landing_activity_type_id');
    }

    public function waterType()
    {
        return $this->belongsTo(LandingWaterType::class, 'landing_water_type_id');
    }

    public function state()
    {
        return $this->belongsTo(CodeMaster::class, 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(CodeMaster::class, 'district_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }


    public function landingActivitySpecies()
    {
        return $this->hasMany(LandingActivitySpecies::class, 'landing_info_activity_id');
    }
}
