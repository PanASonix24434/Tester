<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_vessel_hull extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_vessel_hulls';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'vessel_id',
        'hull_type',
        'drilled',
        'brightly_painted',
        'vessel_registration_remarks',
        'length',
        'width',
        'depth',
        'overall_image_path',
        'right_side_image_path',
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
