<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_vessel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table     = 'darat_vessels';
    public $incrementing = false;
    protected $keyType   = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'vessel_condition',
        'vessel_registration_number',
        'transportation',
        'is_approved',
        'is_active',
        'own_vessel',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hull()
    {
        return $this->hasOne(darat_vessel_hull::class, 'vessel_id');
    }

    public function engine()
    {
        return $this->hasOne(darat_vessel_engine::class, 'vessel_id');
    }
}
