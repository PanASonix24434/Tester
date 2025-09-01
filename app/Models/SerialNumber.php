<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerialNumber extends Model
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

    public function generateKPNRegistrationNumber($user_id)
    {
        $applicationType = 'kpn';
        $runningNumberInt = SerialNumber::where('application_type',$applicationType)->max('running_number') + 1;

        $sn = new SerialNumber();
        $sn->application_type = $applicationType;
        $sn->prefix = '';
        $sn->running_number = $runningNumberInt;
        $sn->suffix = '';
        $sn->created_by = $user_id;
        $sn->updated_by = $user_id;
        $sn->save();

        return str_pad($runningNumberInt, 7,'0',STR_PAD_LEFT);
    }

}
