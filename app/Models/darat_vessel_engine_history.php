<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class darat_vessel_engine_history extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_vessel_engine_histories';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'vessel_engine_id',
        'engine_model',
        'engine_brand',
        'engine_number',
        'engine_image_path',
        'engine_number_image_path',
        'horsepower',
        'is_active',
        'is_approved',
        'created_by',
        'updated_by',
        'deleted_by',
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

    public function vesselEngine()
    {
        return $this->belongsTo(darat_vessel_engine::class, 'vessel_engine_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
