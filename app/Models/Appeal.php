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
        'pemohon_status',
        'pegawai_status',
        'ppl_status',
        'kcl_status',
        'kcl_support',
        'pk_status',
        'pk_semakan_status',
        'pk_decision',
        'ppl_comments',
        'kcl_comments',
        'pk_comments',
        'ppl_reviewer_id',
        'ppl_submitted_at',
        'kcl_reviewer_id',
        'kcl_submitted_at',
        'pk_reviewer_id',
        'pk_submitted_at',
        'kpp_reviewer_id',
        'kpp_decision',
        'kpp_comments',
        'kpp_ref_no',
        'no_siri',
        'zon',
        'surat_kelulusan_kpp',
    ];

    protected $casts = [
        'ppl_submitted_at' => 'datetime',
        'kcl_submitted_at' => 'datetime',
        'pk_submitted_at' => 'datetime',
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
            
            // Set default zone to C2 if not provided
            if (empty($model->zon)) {
                $model->zon = 'C2';
            }
        });

        static::saving(function ($model) {
            // Validate zone field - only allow C1 and C2
            if (!empty($model->zon) && !in_array($model->zon, ['C1', 'C2'])) {
                throw new \InvalidArgumentException('Zone must be either C1 or C2 only.');
            }
        });

        static::updating(function ($model) {
            // Validate zone field - only allow C1 and C2
            if (!empty($model->zon) && !in_array($model->zon, ['C1', 'C2'])) {
                throw new \InvalidArgumentException('Zone must be either C1 or C2 only.');
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

    public function pplReviewer()
    {
        return $this->belongsTo(\App\Models\User::class, 'ppl_reviewer_id');
    }

    public function kclReviewer()
    {
        return $this->belongsTo(\App\Models\User::class, 'kcl_reviewer_id');
    }

    public function pkReviewer()
    {
        return $this->belongsTo(\App\Models\User::class, 'pk_reviewer_id');
    }

    public function kppReviewer()
    {
        return $this->belongsTo(\App\Models\User::class, 'kpp_reviewer_id');
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
