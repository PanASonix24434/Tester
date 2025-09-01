<?php

namespace App\Models\LandingDeclaration;


use App\Traits\UuidKey;
use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingDeclarationMonthly extends Model
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
      * The attributes that should be cast to native types.
     *
     * @var array
     */
     protected $casts = [
        'is_verified' => 'boolean',
        'used_in_payment' => 'boolean',
     ];
   
     public static function getNumberOfWeekInMonth($year,$month){
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $weekCount = 0;
        for ($i=$daysInMonth; $i > 0; $i-=7) {
            ++$weekCount;
        }
        return $weekCount;
     }
}
