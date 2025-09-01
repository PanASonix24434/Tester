<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vessel;

class Lesen extends Model
{
    use HasFactory;

    protected $table = 'lesen';

    protected $fillable = [
        'no_pendaftaran_kapal',
        'no_lesen',
        'tarikh_keluar',
        'tarikh_tamat',
        'kod_zon',
        'kawasan_perairan',
        'no_patil',
        'catatan',
        'status_lesen',
        'no_lesen_skl'
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'no_pendaftaran_kapal', 'no_pendaftaran');
    }
}
