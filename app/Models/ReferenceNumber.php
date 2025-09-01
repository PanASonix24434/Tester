<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferenceNumber extends Model
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

    public function generateReferenceNumber($user_id)
    {
        $runningNumberInt = ReferenceNumber::max('running_number') + 1;

        $ref = new ReferenceNumber();
        $ref->prefix = '';
        $ref->running_number = $runningNumberInt;
        $ref->suffix = '';
        $ref->created_by = $user_id;
        $ref->updated_by = $user_id;
        $ref->save();

        return str_pad($runningNumberInt, 7,'0',STR_PAD_LEFT);
    }

}
