<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_application_log extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_application_logs';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'application_id',
        'application_status_id',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
        'is_active',
        'review_flag',
        'support_flag',
        'decision_flag',
        'confirmation_flag',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'review_flag'       => 'integer',
        'support_flag'      => 'integer',
        'decision_flag'     => 'integer',
        'confirmation_flag' => 'integer',
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

    public function application()
    {
        return $this->belongsTo(darat_application::class, 'application_id', 'id');
    }

    public function applicationStatus()
    {
        return $this->belongsTo(CodeMaster::class, 'application_status_id', 'id');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
