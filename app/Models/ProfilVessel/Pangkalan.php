<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vessel;

class Pangkalan extends Model
{
    use HasFactory;

    protected $table = 'am_pangkalan';

    protected $fillable = [
        'no_rujukan_permohonan',
        'nama_pangkalan',
        'jenis_pangkalan',
        'daerah',
        'negeri',
        'tarikh_mula_beroperasi',
        'status',
    ];

    public function vessels()
    {
        return $this->hasMany(Vessel::class, 'pangkalan_id');
    }
}
