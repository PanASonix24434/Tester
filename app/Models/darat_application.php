<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_application extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_applications';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'application_type_id',
        'application_status_id',
        'inspection_date',
        'no_rujukan',
        'is_appeal',
        'is_approved',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
        'new_entity_id',
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

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applicationType()
    {
        return $this->belongsTo(CodeMaster::class, 'application_type_id');
    }

    public function applicationStatus()
    {
        return $this->belongsTo(CodeMaster::class, 'application_status_id');
    }

    public function vessel()
    {
        return $this->hasOne(darat_vessel::class, 'user_id', 'user_id')->where('is_active', true);
    }

    public function fetchPin()
    {
        return $this->hasOne(darat_temporary_pin::class, 'application_id');
    }
}
