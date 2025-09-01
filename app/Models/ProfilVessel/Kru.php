<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vessel;

class Kru extends Model
{
    use HasFactory;

    protected $table = 'kru';

    protected $fillable = [
        'no_pendaftaran_kapal',
        'nama_kru',
        'no_kp_baru',
        'no_kp_lama',
        'no_passport',
        'no_kad',
        'jawatan',
        'tarikh_kemaskini_mykad',
        'status_kru',
        'no_sijil',
        'no_plks',
        'tarikh_tamat_plks',
        'negara',
        'warganegara'
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'no_pendaftaran_kapal', 'no_pendaftaran');
    }
}
