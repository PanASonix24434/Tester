<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class darat_vessel_history extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_vessel_histories';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'vessel_id',
        'vessel_condition',
        'vessel_registration_number',
        'transportation',
        'is_approved',
        'is_active',
        'safety_jacket_status',
        'safety_jacket_quantity',
        'safety_jacket_condition',
        'safety_jacket_image_path',
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
}
