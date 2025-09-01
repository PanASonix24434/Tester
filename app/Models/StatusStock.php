<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tahun',
        'dokumen_kelulusan_kpp',
        'fish_type_id',
        'fma',
        'bilangan_stok',
        'dokumen_senarai_stok',
        'status',
        'pengesahan_status',
        'semakan_status',
        'final_decision',
        'final_decision_by',
        'final_decision_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
        'final_decision_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
        'deleted_by' => 'string',
        'final_decision_by' => 'string',
    ];

    public function fishType()
    {
        return $this->belongsTo(FishType::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function finalDecisionByUser()
    {
        return $this->belongsTo(User::class, 'final_decision_by');
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

        static::deleting(function ($model) {
            if (auth()->check()) {
                $model->deleted_by = auth()->id();
                $model->save();
            }
        });
    }
} 