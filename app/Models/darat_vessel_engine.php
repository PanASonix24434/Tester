<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_vessel_engine extends Model
{
    use SoftDeletes;

    protected $table = 'darat_vessel_engines';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'vessel_id',
        'engine_model',
        'engine_brand',
        'horsepower',
        'engine_number',
        'engine_image_path',
        'engine_number_image_path',
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

    public function vessel()
    {
        return $this->belongsTo(darat_vessel::class, 'vessel_id');
    }
}
