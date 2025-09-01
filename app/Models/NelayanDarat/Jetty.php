<?php

namespace App\Models\NelayanDarat;

use App\Models\CodeMaster;
use App\Models\Parliament;
use App\Models\ParliamentSeat;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Jetty extends Model
{
    use SoftDeletes;

    protected $table = 'jetties';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'district_id',
        'parliament_id',
        'parliament_seat_id',
        'state_id',
        'name',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::creating(function ($jetty) {
            $exists = Jetty::where('name', $jetty->name)
                ->where('district_id', $jetty->district_id)
                ->exists();

            if ($exists) {
                throw new \Exception('Maklumat jeti ini telah wujud dalam daerah yang sama.');
            }
        });
    }

    // Relationships

    public function district()
    {
        return $this->belongsTo(CodeMaster::class, 'district_id');
    }

    public function state()
    {
        return $this->belongsTo(CodeMaster::class, 'state_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function parliament()
    {
        return $this->belongsTo(Parliament::class, 'parliament_id');
    }

    public function dun()
    {
        return $this->belongsTo(ParliamentSeat::class, 'parliament_seat_id');
    }
}
