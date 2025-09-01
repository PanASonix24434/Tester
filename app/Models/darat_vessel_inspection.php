<?php

namespace App\Models;
use App\Models\NelayanDarat\darat_inspection_equipment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class darat_vessel_inspection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_vessel_inspections';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [

        'vessel_id',
        'application_id',
        'user_id',
        'inspection_date',
        'valid_date',
        'inspection_location',
        'inspected_by',
        'is_support',
        'inspection_summary',
        'vessel_registration_number',
        'vessel_condition',
        'vessel_origin',
        'hull_type',
        'drilled',
        'brightly_painted',
        'vessel_registration_remarks',
        'length',
        'width',
        'depth',
        'engine_model',
        'engine_brand',
        'horsepower',
        'engine_number',
        'safety_jacket_status',
        'safety_jacket_quantity',
        'safety_jacket_condition',
        'attendance_form_path',
        'vessel_image_path',
        'inspector_owner_image_path',
        'overall_image_path',
        'safety_jacket_image_path',
        'engine_image_path',
        'engine_number_image_path',
        'is_approved',
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
    }

    public function vessel()
    {
        return $this->belongsTo(darat_vessel::class, 'vessel_id');
    }

    public function application()
    {
        return $this->belongsTo(darat_application::class, 'application_id');
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspected_by', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(darat_user_detail::class, 'created_by','user_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

       public function inspection_equipments()
{
    return $this->hasMany(darat_inspection_equipment::class, 'inspection_id', 'id');
}

   public function foundItem()
    {
        return $this->hasMany(darat_item_found::class, 'inspection_id', 'id');
    }
}
