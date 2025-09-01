<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Kru\ForeignCrew;
use App\Models\Kru\NelayanMarin;

class Vessel extends Model
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

    //calculation based on buku dasar page 180
    public function maximumKru()
    {
        //check equipment and grt exist
        $peralatan_utama = CodeMaster::withTrashed()->find($this->peralatan_utama);
        $grt = $this->grt;
        if ($peralatan_utama == null || $grt == null) return null;

        $maximumKru = 0;
        if($peralatan_utama->name_ms=='PUKAT TUNDA'){
            if ($grt < 40)      $maximumKru = 4;
            elseif ($grt < 70)  $maximumKru = 7;
            elseif ($grt < 100) $maximumKru = 10;
            elseif ($grt < 150) $maximumKru = 12;
            else                $maximumKru = 14;
        }
        else if($peralatan_utama->name_ms=='PUKAT JERUT') {
            if ($grt < 40)      $maximumKru = 15;
            elseif ($grt < 70)  $maximumKru = 30;
            elseif ($grt < 100) $maximumKru = 35;
            elseif ($grt < 150) $maximumKru = 40;
            else                $maximumKru = 45;
        }
        else{
            if ($grt < 40)      $maximumKru = 3;
            elseif ($grt < 70)  $maximumKru = 10;
            elseif ($grt < 100) $maximumKru = 15;
            elseif ($grt < 150) $maximumKru = 20;
            else                $maximumKru = 25;
        }
        return $maximumKru;
    }

    //calculation based on buku dasar page 180
    public function maximumForeignKru()
    {
        //check equipment and zon exist
        $maximumKruInVessel = $this->maximumKru();
        $zon = $this->zon;
        if ($maximumKruInVessel == null || $zon == null) return null;

        $maximumForeignKru = 0;
        if( $zon=='C2' || $zon=='C3' ){
            $maximumForeignKru = $maximumKruInVessel;
        }
        else{
            $maximumForeignKru = (int) ($maximumKruInVessel * 0.8);
        }
        return $maximumForeignKru;
    }

    //total nelayan tempatan / pemastatutin
    public function totalLocalKru()
    {
        return NelayanMarin::where('vessel_id',$this->id)->get()->count();
    }

    //total kru bukan warganegara
    public function totalForeignKru()
    {
        return ForeignCrew::where('vessel_id',$this->id)->get()->count();
    }

    //total all kru
    public function totalKru()
    {
        return $this->totalLocalKru() + $this->totalForeignKru();
    }

    //total kru bukan warganegara
    public function totalLocalKruQuotaLeft()
    {
        $maximumKru = $this->maximumKru();
        $totalLocal = $this->totalLocalKru();
        $totalForeign = $this->totalForeignKru();
        return $maximumKru != null ? $maximumKru - $totalLocal - $totalForeign : 0;
    }
    
    //total kru bukan warganegara
    public function totalForeignKruQuotaLeft()
    {
        $maximumKru = $this->maximumKru();
        $maximumForeignKru = $this->maximumForeignKru();
        if( $maximumKru == null || $maximumForeignKru == null ) return 0;

        $totalLocal = $this->totalLocalKru();
        $totalForeign = $this->totalForeignKru();

        $maxLocalBeforeExcess = $maximumKru - $maximumForeignKru;
        $excessLocal = $totalLocal - $maxLocalBeforeExcess;

        if( $excessLocal>0 ){
            return $maximumForeignKru - $totalForeign - $excessLocal;
        }
        else{
            return $maximumForeignKru - $totalForeign;
        }
    }

    //hasQuota
    public function hasLocalQuota()
    {
        return $this->totalLocalKruQuotaLeft() > 0;
    }

    //hasQuota
    public function hasForeignQuota()
    {
        return $this->totalForeignKruQuotaLeft() > 0;
    }

    //Ajim
    public function applicationsV2()
    {
        return $this->belongsToMany(ApplicationV2::class, 'application_v2_vessel', 'vessel_id', 'application_id');
    }

    public function profileUsers()
    {
        return $this->belongsToMany(ProfileUser::class, 'profile_user_vessel')
            ->withPivot('role', 'status');
    }

    public function owners()
    {
        return $this->profileUsers()
            ->wherePivot('role', 'owner')
            ->wherePivot('status', 'verified');
    }

    public function managers()
    {
        return $this->profileUsers()
            ->wherePivot('role', 'manager')
            ->wherePivot('status', 'verified');
    }

    public function addOwner($profile_user_id, $status = 'verified')
    {
        return $this->profileUsers()
            ->attach($profile_user_id, [
                'role' => 'owner',
                'status' => $status,
            ]);
    }

    public function addManager($profile_user_id, $status = 'verified')
    {
        return $this->profileUsers()
            ->attach($profile_user_id, [
                'role' => 'manager',
                'status' => $status,
            ]);
    }

    public function removeManager($profile_user_id = null, $status = null)
    {
        $query = $this->profileUsers()->wherePivot('role', 'manager');

        if ($profile_user_id) {
            $query->where('profile_user_id', $profile_user_id);
        }
        if ($status) {
            $query->wherePivot('status', $status);
        }

        $ids = $query->pluck('profile_user_id')->toArray();

        return $this->profileUsers()->detach($ids);
    }

    public function updateManagerStatus($profile_user_id, $status)
    {
        return $this->profileUsers()
            ->updateExistingPivot($profile_user_id, [
                'status' => $status,
            ]);
    }

    public function isQuotaFull($exclude_profile_user_id = null)
    {
        $query = $this->managers();
        if ($exclude_profile_user_id) {
            $query->where('id', '<>', $exclude_profile_user_id);
        }
        return $query->exists();
    }

    public function pentadbirHartaProfiles()
    {
    return $this->belongsToMany(ProfilePentadbirHarta::class, 'profile_pentadbir_harta_vessel');
    }

}
