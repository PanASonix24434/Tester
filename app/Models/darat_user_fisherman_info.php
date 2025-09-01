<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class darat_user_fisherman_info extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_user_fisherman_infos';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'year_become_fisherman',
        'becoming_fisherman_duration',
        'transportation',
        'working_days_fishing_per_month',
        'estimated_income_yearly_fishing',
        'estimated_income_other_job',
        'days_working_other_job_per_month',
        'receive_pension',
        'receive_financial_aid',
        'epf_contributor',
        'epf_type',
        'fisherman_type_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'is_active',
    ];

    protected $dates = ['deleted_at'];

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
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function aidAgencies()
    {
        return $this->hasMany(darat_help_agency_fisherman::class, 'fisherman_info_id');
    }

     public function fisherManType()
    {
        return $this->belongsTo(CodeMaster::class, 'fisherman_type_id');
    }
}
