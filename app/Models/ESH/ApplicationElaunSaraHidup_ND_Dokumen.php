<?php

namespace App\Models\ESH;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ApplicationElaunSaraHidup_ND_Dokumen extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

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
        'application_esh_id',
        'file_type',
        'file_desc',
        'file_name',
        'file_path',
    ];

    public function profile()
    {
        return $this->belongsTo(ApplicationElaunSaraHidup_ND::class);
    }
}
