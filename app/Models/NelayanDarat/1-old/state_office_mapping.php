<?php

namespace App\Models\NelayanDarat;

use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class state_office_mapping extends Model
{
    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'state_office_mappings';

    protected $fillable = [
        'id',
        'state_id',
        'district_id',
        'parent_id',
        'office_id',
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

    // Relationships
    public function state()
    {
        return $this->belongsTo(CodeMaster::class, 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(CodeMaster::class, 'district_id');
    }

    public function office()
    {
        return $this->belongsTo(Entity::class, 'office_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
