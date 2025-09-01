<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait HasAuditField
{
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->getKeyType() == 'string' && !$model->getIncrementing()) {
                $model->{$model->getKeyName()} = static::generateUuid();
            }

            if (auth()->check()) {
                if (Schema::hasColumn($model->getTable(), 'created_by')) {
                    $model->created_by = auth()->id();
                }
                if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                    $model->updated_by = auth()->id();
                }
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                    $model->updated_by = auth()->id();
                }
            }
        });

        static::deleting(function ($model) {
            if (auth()->check()) {
                if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
                    $model->deleted_by = auth()->id();
                    $model->save();
                }
            }
        });
    }

    private static function generateUuid()
    {
        $instance = new static;

        do {
            $uuid = (string) Str::uuid();
        } while ($instance->where($instance->getKeyName(), $uuid)->exists());

        return $uuid;
    }
}
