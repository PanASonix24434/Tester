<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vessel;

class PendaftaranAntarabangsa extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_antarabangsa';

    protected $fillable = [
        'vessel_id',
        'no_pendaftaran_vesel',
        'no_ircs',
        'no_rfmo',
        'no_imo',
        'kawasan_penangkapan',
        'spesis_sasaran'
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }
}
