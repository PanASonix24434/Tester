<?php

namespace App\Models\LandingDeclaration;


use App\Traits\UuidKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingActivityType extends Model
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
	
    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [
        'has_landing' => 'boolean',
   ];

   public static function seed($name, $has_landing, $order)
   {
       if (!LandingActivityType::seedExists($name)) {
           $activity = new LandingActivityType();
           $activity->name = $name;
           $activity->has_landing = $has_landing;
           $activity->order = $order;
           $activity->created_by = \App\Models\User::getAdminUser()->id;
           $activity->updated_by = \App\Models\User::getAdminUser()->id;
           $activity->save();
       }
   }

   public static function seedExists($name)
   {
       $activity = LandingActivityType::where('name', $name);

       return $activity->get()->count() >= 1 ? true : false;
   }
}
