<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vessel;

class Enjin extends Model
{
    use HasFactory;

    protected $table = 'enjin';

    protected $fillable = [
        'no_pendaftaran_kapal',
        'jenis_enjin', // 1 - Sangkut, 2 - Dalam
        'jenama',
        'kuasa_kuda',
        'no_enjin',
        'model',
        'tarikh_enjin_dilesenkan',
        'kategori_enjin',
        'status_enjin',
        'has_turbo',
        'bahan_api',
        'gambar_enjin',
        'gambar_no_enjin',
        'gambar_pev',
        'gambar_turbo',
        'gambar_generator'
    ];

    protected $casts = [
        'tarikh_enjin_dilesenkan' => 'date:d-m-Y',
        'has_turbo' => 'boolean',
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'no_pendaftaran_kapal', 'no_pendaftaran');
    }
}
