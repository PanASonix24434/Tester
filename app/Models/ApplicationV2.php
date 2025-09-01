<?php

namespace App\Models;

use App\Traits\HasAuditField;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationV2 extends Model
{
    use HasFactory, HasAuditField, SoftDeletes;

    const STATUS_SUBMITTED = 'submitted';
    const STATUS_VERIFIED = 'verified';
    const STATUS_UNVERIFIED = 'unverified';
    const STATUS_INACTIVE = 'inactive';

    protected $table = 'applications_v2';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function profileUsers()
    {
        return $this->belongsToMany(ProfileUser::class, 'application_v2_profile_user', 'application_id', 'profile_user_id');
    }

    public function vessels()
    {
        return $this->belongsToMany(Vessel::class, 'application_v2_vessel', 'application_id', 'vessel_id');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'object_id')
            ->where('object_type', 'application_v2');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'object_id')
            ->where('object_type', 'application_v2');
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

    public function suratWakilKuasaDaripadaPemilikKepadaPengurusVesel()
    {
        return $this->attachments()
            ->where('slug', 'surat-wakil-kuasa-daripada-pemilik-kepada-pengurus-vesel')
            ->first() ?? new Attachment;
    }

    public function suratWakilKuasaDaripadaPemilikKepadaPengurusVeselId(): Attribute
    {
        return Attribute::get(function () {
            return $this->suratWakilKuasaDaripadaPemilikKepadaPengurusVesel()->id ?? null;
        });
    }

    public function suratWakilKuasaDaripadaPemilikKepadaPengurusVeselUrl(): Attribute
    {
        return Attribute::get(function () {
            $surat_wakil_kuasa = $this->suratWakilKuasaDaripadaPemilikKepadaPengurusVesel();
            if ($surat_wakil_kuasa->path && $surat_wakil_kuasa->filename) {
                return asset('storage/'.$surat_wakil_kuasa->path.'/'.$surat_wakil_kuasa->filename);
            }
            return '';
        });
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

    public function isDeactivated()
    {
        return $this->status === self::STATUS_INACTIVE;
    }
}
