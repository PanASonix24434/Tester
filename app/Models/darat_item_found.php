<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_item_found extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_item_founds';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'inspection_id',
        'item',
        'quantity',
        'is_active',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'quantity'  => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // Relationship to inspection
    public function inspection()
    {
        return $this->belongsTo(darat_vessel_inspection::class, 'inspection_id');
    }

    // Relationship to equipment
    public function equipment()
    {
        return $this->belongsTo(darat_equipment::class, 'equipment_id');
    }

    // Creator
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Updater
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Deleter
    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
