<?php

namespace App\Models\Kru;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

//used for kru tempatan kru01-kru04 - reference kru_application_krus
class KruDocument extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

    //tempatan
    const DOC_PIC = 'GAMBAR KRU';
    const DOC_IC = 'SALINAN KAD PENGENALAN';
    const DOC_PKN = 'PEMERIKSAAN KESIHATAN NELAYAN';
    const DOC_KWSP = 'PENYATA KWSP';

    const DOC_POLICE_REPORT = 'LAPORAN POLIS';
    const DOC_KPN_PIC = 'GAMBAR KAD PENDAFTARAN NELAYAN';

    //pegawai kru 01
    const DOC_SIASATAN = 'SIASATAN';

    const DOC_ALL = [
        self::DOC_PIC,
        self::DOC_IC,
        self::DOC_PKN,
        self::DOC_KWSP,
        self::DOC_POLICE_REPORT,
        self::DOC_KPN_PIC,
        self::DOC_SIASATAN
    ];

    const DOC_PEGAWAI = [
        self::DOC_SIASATAN
    ];

    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

}
