<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class CmEquipment extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;


    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    protected $primaryKey = 'id';

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
        'vessel_id',
        'equipment_name',
        'equipment_type',   //1 = komersial, 2 = tradisi
        'date_licensed',
        'fisherman_type',   //1 = marin, 2 = darat
        'entity_id',
        'quantity',
        'amount',
        'notes',
        'is_active',    //1 = active, 0 = inactive
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'vessel_id', 'no_pendaftaran');
    }
}
