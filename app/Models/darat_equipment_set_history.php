<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class darat_equipment_set_history extends Model
{

    use HasFactory, SoftDeletes;
    
    protected $table = 'darat_equipment_set_histories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'equipment_set_id',
        'user_id',
        'photo',
        'is_approved',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function equipmentSet()
    {
        return $this->belongsTo(darat_equipment_set::class, 'equipment_set_id');
    }
}
