<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//Copy dari Model sedia ada
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ProfilePentadbirHarta extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

    const STATUS_SUBMITTED = 'submitted';
    const STATUS_VERIFIED = 'verified';
    const STATUS_UNVERIFIED = 'unverified';
    const STATUS_INACTIVE = 'inactive';

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

      public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vessel()
    {
        return $this->belongsTo(Vessel::class)->withDefault();
    }

    public function vessels()
    {
    return $this->belongsToMany(Vessel::class, 'profile_pentadbir_harta_vessel');
    }


    public function vesselOwner()
    {
        return $this->belongsTo(ProfileUser::class)->withDefault();
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'object_id')
            ->where('object_type', 'profile_pentadbir_harta');
    }

    public function isSubmitted()
    {
        return $this->status === self::STATUS_SUBMITTED;
    }

    public function isVerified()
    {
        return $this->status === self::STATUS_VERIFIED;
    }

    public function isUnverified()
    {
        return $this->status === self::STATUS_UNVERIFIED;
    }


}
