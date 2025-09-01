<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Species extends Model
{
    use HasFactory, UuidKey, SoftDeletes;

    protected $table = 'species';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'common_name',
        'scientific_name',
        'family_name',
        'order_name',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
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

	public static function seed($cname, $sname, $family_name = null, $order_name = null)
    {
		$species = new Species();
		// $species->species_type_id = $stid;
		$species->common_name = $cname;
		$species->scientific_name = $sname;
		$species->family_name = $family_name;
		$species->order_name = $order_name;
		$species->created_by = \App\Models\User::getAdminUser()->id;
		$species->updated_by = \App\Models\User::getAdminUser()->id;
		$species->save();
    }
}
