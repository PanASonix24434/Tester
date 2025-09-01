<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vessel;
use App\Traits\UuidKey;

class Kulit extends Model
{
    use HasFactory, UuidKey;

    protected $table = 'kulit';

    protected $fillable = [
        'no_pendaftaran_kapal',
        'no_rujukan_permohonan',
        'panjang',
        'lebar',
        'dalam',
        'jenis_kulit',
        'tarikh_kulit_dilesenkan',
        'status_kulit',
        'catatan',
        'is_active'
    ];

    protected $casts = [
        'tarikh_kulit_dilesenkan' => 'date',
        'is_active' => 'boolean'
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'no_pendaftaran_kapal', 'no_pendaftaran');
    }
}
