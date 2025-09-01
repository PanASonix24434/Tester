<?php

namespace App\Models\Kru;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class KruApplicationDocument extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

    const DOC_IC = 'SALINAN KAD PENGENALAN MAJIKAN';
    const DOC_PENDAFTARAN_SYARIKAT = 'SALINAN PENDAFTARAN SYARIKAT';
    const DOC_PENGGAJIAN = 'SALINAN KELULUSAN PENGGAJIAN PEKERJA ASING';
    const DOC_ALL = [
        self::DOC_IC,
        self::DOC_PENDAFTARAN_SYARIKAT,
        self::DOC_PENGGAJIAN,
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
