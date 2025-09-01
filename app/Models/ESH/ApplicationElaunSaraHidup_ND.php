<?php

namespace App\Models\ESH;

use App\Models\User;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ApplicationElaunSaraHidup_ND extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

    /*
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
        'user_id',
        'bank_name',
        'bank_account_no',
        'bank_branch',
        'income_fishing',
        'income_other',
        'children_count',
        'other_dependents',
        'education_level',
        'agreement',
        'entity_id',
        'current_status',
    ];

    protected $casts = [
        'income_fishing' => 'decimal:2',
        'income_other' => 'decimal:2',
        'agreement' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(ApplicationElaunSaraHidup_ND_Dokumen::class);
    }
}
