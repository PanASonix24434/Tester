<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_user_equipment_history extends Model
{
    use SoftDeletes;

    protected $table = 'darat_user_equipment_histories';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'equipment_id',
        'equipment_set_id',
        'name',
        'quantity',
        'type',
        'is_active',
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

    public function equipment()
    {
        return $this->belongsTo(DaratUserEquipment::class, 'equipment_id');
    }

    public function set()
    {
        return $this->belongsTo(DaratEquipmentSet::class, 'equipment_set_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
