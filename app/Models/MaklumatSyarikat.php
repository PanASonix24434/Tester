<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class MaklumatSyarikat extends Model
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
        'user_id',
        'company_name',
        'address1',
        'address2',
        'address3',
        'poskod',
        'district',
        'state',
        'ownership',
        'bumiputera_status',
        'no_phone',
        'no_phone_office',
        'no_fax',
        'email',
        'company_status',
        

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pendaftaranPerniagaan()
    {
        return $this->hasOne(PendaftaranPerniagaan::class, 'company_id', 'id');
    }


    public function involvement()
    {
        return $this->hasOne(PenglibatanSyarikat::class, 'company_id');
    }
}
