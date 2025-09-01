<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingPendaratan extends Model
{
    use HasFactory;
    
    protected $table = 'listing_pendaratan';

protected $fillable = [
    'pelayaran_no',
    'vessel_id',
    'bulan',
    'jumlah_hari_di_laut',
    'tarikh_masa_berlepas',
    'tarikh_masa_tiba',
    'purata_masa_memukat',
    'dokumen_nama',
    'dokumen_type',
    'dokumen',
];

}
