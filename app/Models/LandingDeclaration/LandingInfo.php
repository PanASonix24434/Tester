<?php

namespace App\Models\LandingDeclaration;


use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingInfo extends Model
{
    use HasFactory, UuidKey, SoftDeletes;

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
    
    protected $table = 'landing_infos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'landing_declaration_id',
        'landing_date',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
	
    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [
        'landing_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
   ];

    // Relationships

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

    public function landingInfoActivities()
    {
        return $this->hasMany(LandingInfoActivity::class, 'landing_info_id');
    }

    public function landingDeclaration()
    {
        return $this->belongsTo(LandingDeclaration::class, 'landing_declaration_id');
    }
}
