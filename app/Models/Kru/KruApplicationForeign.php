<?php

namespace App\Models\Kru;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;

class KruApplicationForeign extends Model
{
    use HasFactory, UuidKey, SoftDeletes;

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

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'immigration_date' => 'date',
        // 'plks_end_date' => 'date',
        // 'supported' => 'boolean',
        // 'approved' => 'boolean',
    ];
}
