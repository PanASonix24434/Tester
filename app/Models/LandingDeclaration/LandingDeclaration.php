<?php

namespace App\Models\LandingDeclaration;
use App\Models;



use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\User;


use App\Traits\UuidKey;
use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class LandingDeclaration extends Model
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
        'used_in_monthly' => 'boolean',
   ];

    public static function getWeekDropdown(){
        App::setLocale('ms'); // use malay
        $week = collect();

        //last month;
        $carbon = Carbon::now()->subMonth();
        $year = $carbon->year;
        $month = $carbon->month;
        $monthText = Carbon::create($year, $month, 1)->isoFormat('MMMM');
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;

        $weekCount = 0;
        for ($i=$daysInMonth; $i > 0; $i-=7) {
            $startDay = 1 + $weekCount * 7;
            $endDay = 7 + $weekCount * 7;
            $week->push((object) [
                'year' => $year,
                'month' => $month,
                'monthTxt' => $monthText,
                'week' => ++$weekCount,
                'startDay' => $startDay,
                'endDay' => $endDay > $daysInMonth ? $daysInMonth : $endDay,
            ]);
        }

        //current month
        $carbon = Carbon::now();
        $year = $carbon->year;
        $month = $carbon->month;
        $monthText = Carbon::create($year, $month, 1)->isoFormat('MMMM');
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $curDay = $carbon->day;

        $weekCount = 0;
        for ($i=$daysInMonth; $i > 0; $i-=7) {
            $startDay = 1 + $weekCount * 7;
            $endDay = 7 + $weekCount * 7;

            if ($startDay > $curDay) continue; // skip future weeks

            $week->push((object) [
                'year' => $year,
                'month' => $month,
                'monthTxt' => $monthText,
                'week' => ++$weekCount,
                'startDay' => $startDay,
                'endDay' => $endDay > $daysInMonth ? $daysInMonth : $endDay,
            ]);
        }

        return $week->reverse(); //sort by newest first
    }

    public static function getNumberOfWeekInMonth($year,$month){
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $weekCount = 0;
        for ($i=$daysInMonth; $i > 0; $i-=7) {
            ++$weekCount;
        }
        return $weekCount;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function decisionMaker()
    {
        return $this->belongsTo(User::class, 'decision_by');
    }

    public function status()
    {
        return $this->belongsTo(CodeMaster::class, 'landing_status_id');
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // LandingDeclaration.php
    public function landingInfo()
    {
        return $this->hasOne(LandingInfo::class);
    }

    public function decisionBy()
    {
        return $this->belongsTo(User::class, 'decision_by');
    }
}
