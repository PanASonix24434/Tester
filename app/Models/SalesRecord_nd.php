<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SalesRecord_nd extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sales_record_nds';  
    protected $primaryKey = 'sales_record_id'; 
    public $incrementing = false;  
    protected $keyType = 'string'; 

    protected $fillable = [
        'sales_record_id', 
        'fish_landing_id', 
        'fish_species_id',
        'sold_weight_kg', 
        'price_per_kg', 
        'total_sale_amount',
        'created_by', 
        'updated_by', 
        'deleted_by', 
        'is_active'
    ];

    /**
     * Automatically generate a UUID for sales_record_id when creating a new record.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->sales_record_id)) {
                $model->sales_record_id = Str::uuid();
            }
        });
    }

    /**
     * Relationship: A sales record belongs to a fish landing.
     */
    public function fishLanding()
    {
        return $this->belongsTo(FishLandingNd::class, 'fish_landing_id', 'fish_landing_id');
    }

    /**
     * Relationship: A sales record belongs to a fish species.
     */
    public function fishSpecies()
    {
        return $this->belongsTo(FishSpeciesNd::class, 'fish_species_id', 'fish_species_id');
    }

    /**
     * Relationship: Created by user.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Relationship: Updated by user.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * Relationship: Deleted by user.
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public static function getSalesData($fishLandings)
    {
        return self::whereIn('fish_landing_id', $fishLandings->pluck('fish_landing_id'))
            ->join('fish_species_nds', 'sales_record_nds.fish_species_id', '=', 'fish_species_nds.fish_species_id')
            ->select(
                'fish_species_nds.species_name',
                DB::raw('SUM(sales_record_nds.sold_weight_kg) as total_sold_weight'),
                DB::raw('AVG(sales_record_nds.price_per_kg) as avg_price_per_kg'),
                DB::raw('SUM(sales_record_nds.total_sale_amount) as total_sales')
            )
            ->groupBy('fish_species_nds.species_name')
            ->get();
    }
}