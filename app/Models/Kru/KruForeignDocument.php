<?php

namespace App\Models\Kru;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

//used for kru bukan warganegara kru05-kru08 - reference kru_application_foreign_krus
class KruForeignDocument extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;
    
    //asing
    const DOC_PASSPORT = 'SALINAN PASPORT KRU';
    const DOC_PASSPORT_PLKS = 'SALINAN PASPORT KRU PLKS';

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
