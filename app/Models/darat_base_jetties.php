<?php

namespace App\Models;

use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use App\Models\CodeMaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_base_jetties extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_base_jetties';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'jetty_id',
        'state_id',
        'district_id',
        'river_id',
        'entity_id',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Auto-generate UUID.
     */
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
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(CodeMaster::class, 'state_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(CodeMaster::class, 'district_id', 'id');
    }

    public function jetty()
    {
        return $this->belongsTo(Jetty::class, 'jetty_id', 'id');
    }

    public function river()
    {
        return $this->belongsTo(River::class, 'river_id', 'id');
    }

    // Accessors
    protected $appends = ['state_name', 'district_name', 'jetty_name', 'river_name'];

    public function getStateNameAttribute()
    {
        return $this->state?->name ?? '-';
    }

    public function getDistrictNameAttribute()
    {
        return $this->district?->name ?? '-';
    }

    public function getJettyNameAttribute()
    {
        return $this->jetty?->name ?? '-';
    }

    public function getRiverNameAttribute()
    {
        return $this->river?->name ?? '-';
    }
}
