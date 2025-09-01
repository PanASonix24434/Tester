<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_user_equipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_user_equipments';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'equipment_set_id',
        'name',
        'quantity',
        'type',
        'condition',
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

    public function set()
    {
        return $this->belongsTo(darat_equipment_set::class, 'equipment_set_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
