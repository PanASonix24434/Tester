<?php

namespace App\Models\LandingDeclaration;
use App\Models;
use App\Models\Species;
use App\Models\User;


use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingActivitySpecies extends Model
{
    use HasFactory, UuidKey;

    protected $keyType = 'string';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'landing_activity_species';

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
   ];

    // Relationships
    public function activity()
    {
        return $this->belongsTo(LandingInfoActivity::class, 'landing_info_activity_id');
    }

    public function species()
    {
        return $this->belongsTo(Species::class, 'species_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
