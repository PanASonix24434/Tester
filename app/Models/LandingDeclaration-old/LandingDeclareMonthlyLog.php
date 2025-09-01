<?php

namespace App\Models\LandingDeclaration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class LandingDeclareMonthlyLog extends Model
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
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_editing' => false,
    ];

    protected $casts = [
        'completed' => 'boolean', // lengkap / tak lengkap
        'supported' => 'boolean', // sokong / tak sokong
        'approved' => 'boolean', // lulus / tak lulus
        'is_editing' => 'boolean',
    ];
}
