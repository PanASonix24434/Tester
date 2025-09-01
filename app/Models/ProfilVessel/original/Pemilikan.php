<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vessel;
class Pemilikan extends Model
{
    use HasFactory;

    protected $table = 'pemilikan';

    protected $fillable = [
        'no_pendaftaran_kapal', 'nama_pemilik', 'jenis_pemilikan', 'negeri',
        'daerah', 'tarikh_aktif_pemilikan', 'status_pemilikan'
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'no_pendaftaran_kapal', 'no_pendaftaran');
    }
}
