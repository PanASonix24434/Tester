<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ParliamentSeat extends Model
{
    use HasFactory, UuidKey, SoftDeletes, Sortable;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parliament_id',
        'parliament_seat_code',
        'parliament_seat_name',
        
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    protected $attributes = [
        'is_deleted' => false,
    ];

    public static function seed($code, $name, $parliament = null)
    {
        $parliament_id = null;

        if (!empty($parliament)) {
            $items = json_decode($parliament);
            $parent_model = Parliament::where('parliament_code', $items->pCode)->first();
            if (!empty($parent_model)) {
                $parliament_id = $parent_model->id;
            }
        }

        if (!ParliamentSeat::seedExists($code, $name, $parliament_id)) {
            $parliamentSeat = new ParliamentSeat;
            $parliamentSeat->parliament_id = $parliament_id;
            $parliamentSeat->parliament_seat_code = $code;
            $parliamentSeat->parliament_seat_name = $name;           
            $parliamentSeat->created_by = \App\Models\User::getAdminUser()->id;
            $parliamentSeat->updated_by = \App\Models\User::getAdminUser()->id;
            $parliamentSeat->save();
        }
    }

    public static function seedExists($code, $name, $parliament_id = null)
    {
        $parliamentSeat = ParliamentSeat::where('parliament_seat_code', $code)
        ->where('parliament_seat_name', $name);

        if (!empty($parliament_id)) {
            $parliamentSeat->where('parliament_id', $parliament_id);
        }

        return $parliamentSeat->get()->count() >= 1 ? true : false;
    }
}
