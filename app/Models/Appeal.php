<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\Perakuan;

class Appeal extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ref_number',
        'applicant_id',
        'status',
        'ppl_status',
        'kcl_status',
        'pk_status',
        'ppl_comments',
        'kcl_comments',
        'pk_comments',
        'kpp_decision',
        'kpp_comments',
        'kpp_ref_no',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            
            // Generate reference number if not provided
            if (empty($model->ref_number)) {
                $count = static::count() + 1;
                $model->ref_number = 'APP-' . str_pad($count, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function perakuan()
    {
        return $this->hasOne(Perakuan::class, 'appeal_id');
    }

    public function applicant()
    {
        return $this->belongsTo(\App\Models\User::class, 'applicant_id');
    }

    public function dokumenSokongan()
    {
        return $this->hasMany(DokumenSokongan::class, 'appeals_id');
    }

    public function getDokumenSokonganByType($type)
    {
        return $this->dokumenSokongan()->where('file_type', $type)->get();
    }

    public function getDokumenSokonganCountByType($type)
    {
        return $this->dokumenSokongan()->where('file_type', $type)->count();
    }
}
