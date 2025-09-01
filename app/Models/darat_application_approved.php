<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class darat_application_approved extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'darat_application_approveds';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id',
        'application_id',
        'certificate_number',
        'approved_by',
        'approved_at',
        'valid_duration_months',
        'expired_at',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relationships
    public function application()
    {
        return $this->belongsTo(darat_application::class, 'application_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
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

    // Helper: Check if expired
    public function isExpired()
    {
        return now()->greaterThan($this->expired_at);
    }

    // Helper: Days remaining
    public function daysRemaining()
    {
        return now()->diffInDays($this->expired_at, false);
    }
}
