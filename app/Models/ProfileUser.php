<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//Copy dari Model sedia ada
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ProfileUser extends Model
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
        'name',
        'icno',
        'address1',
        'address2',
        'address3',
        'poskod',
        'district',
        'state',
        'age',
        'gender',
        'user_type',
        'no_phone',
        'no_phone_office',
        'religion',
        'race',
        'wedding_status',
        'oku_status',
        'email',
        'is_active',
        'bumiputera_status',
	'is_active',
    ];

   /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_bumiputera' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applicationsV2()
    {
        return $this->belongsToMany(ApplicationV2::class, 'application_v2_profile_user', 'profile_user_id', 'application_id');
    }

    public function vessels()
    {
        return $this->belongsToMany(Vessel::class, 'profile_user_vessel')
            ->withPivot('role', 'status');
    }

    public function ownedVessels()
    {
        return $this->vessels()
           // ->wherePivot('role', 'owner')
            ->orderBy('vessels.vessel_no');
    }

    public function managedVessels()
    {
        return $this->vessels()
            ->wherePivot('role', 'manager')
            ->orderBy('vessels.vessel_no');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'object_id')
            ->where('object_type', 'profile_user');
    }

    public function icCopy()
    {
        return $this->attachments()
            ->where('slug', 'salinan-kad-pengenalan')
            ->first() ?? new Attachment;
    }

    public function icCopyUrl(): Attribute
    {
        return Attribute::get(function () {
            $ic_copy = $this->icCopy();
            if ($ic_copy->path && $ic_copy->filename) {
                return asset('storage/'.$ic_copy->path.'/'.$ic_copy->filename);
            }
            return '';
        });
    }

    public function icCopyName(): Attribute
    {
        return Attribute::get(function () {
            return $this->icCopy()->filename;
        });
    }

}
