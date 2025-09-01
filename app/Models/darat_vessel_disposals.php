<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_vessel_disposals extends Model
{
    use SoftDeletes;

    protected $table = 'darat_vessel_disposals';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'application_id',
        'user_id',
        'jenis_jualan',
        'owner_ic',
        'owner_name',
        'owner_phone',
        'owner_address',
        'resit_file_path',
        'document_description',

        'disposal_time',
        'disposal_location',
        'disposal_method',

        'before_disposal_image',
        'after_disposal_image',
        'attendance_form_image',

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

    // Relationships (optional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function application()
    {
        return $this->belongsTo(darat_application::class, 'application_id');
    }
}
