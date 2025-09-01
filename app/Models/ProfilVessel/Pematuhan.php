<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vessel;

class Pematuhan extends Model
{
    use HasFactory;

    protected $table = 'pematuhan';

    protected $fillable = [
        'no_pendaftaran_kapal',
        'tarikh_pemeriksaan_lpi',
        'sebab_pemeriksaan',
        'sebab_pematuhan',
        
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'no_pendaftaran_kapal', 'no_pendaftaran');
    }
}
