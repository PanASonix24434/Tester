<?php

namespace App\Models\ProfilVessel;

use App\Models\CodeMaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vessel;
use App\Models\ProfilVessel\Pangkalan;

class AmVessel extends Model
{
    use HasFactory;

    protected $table = 'am_vessel';

    protected $fillable = [
        'no_pendaftaran_kapal',
        'no_tetap',
        'no_geran',
        'no_patil_kekal',
        'tarikh_daftar',
        'indikator_kapal',
        'bahan_api',
        'status_usaha_kapal',
        'tempasal_kapal',
        'negara',
        'kebenaran_memancing',
        'pemasangan_vtu',
        'no_pendaftaran_mtu',
        'kod_rfid',
        'kod_qr',
        'hak_milik',
        'status_iuu',

    ];

    protected $casts = [
        'tarikh_daftar' => 'date',
        'status_iuu' => 'boolean',
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'no_pendaftaran_kapal', 'no_pendaftaran');
    }
}
