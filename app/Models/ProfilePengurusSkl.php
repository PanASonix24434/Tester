<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Copy dari Model sedia ada
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ProfilePengurusSkl extends Model
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
    //Isikan column table di sini
    protected $fillable = [
        'user_id',
        'pemilik_vesel',
        'status_pengguna',
        'hubungan',
        'no_vesel',
        'surat_pelantikan_pentadbir',
        'dokumen_sokongan_1',
        'dokumen_sokongan_2',

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
   
    /**
     * The model's default values for attributes.
     *
     * @var array
     */


}
