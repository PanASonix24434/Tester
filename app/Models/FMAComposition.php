<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FMAComposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'fma_number',
        'states',
        'chairman',
        'year',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'fma_number' => 'integer',
        'year' => 'integer',
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
