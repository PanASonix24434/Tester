<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vessel;

class Kesalahan extends Model
{
    use HasFactory;

    protected $table = 'kesalahan';

    protected $fillable = [
        'no_pendaftaran_kapal',
        'pesalah',
        'no_ic_pesalah',
        'akta',
        'seksyen',
        'kesalahan',
        'tarikh',
        'keputusan'
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'no_pendaftaran_kapal', 'no_pendaftaran');
    }
}
