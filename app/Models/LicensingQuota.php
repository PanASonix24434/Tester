<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicensingQuota extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'sub_category',
        'year',
        'fma_01',
        'fma_02',
        'fma_03',
        'fma_04',
        'fma_05',
        'fma_06',
        'fma_07',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'year' => 'integer',
        'fma_01' => 'integer',
        'fma_02' => 'integer',
        'fma_03' => 'integer',
        'fma_04' => 'integer',
        'fma_05' => 'integer',
        'fma_06' => 'integer',
        'fma_07' => 'integer',
        'is_active' => 'boolean'
    ];

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Boot method to automatically set audit fields
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }
}
