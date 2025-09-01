<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpv08Application extends Model
{
    use HasFactory;

    protected $table = 'kvp08_applications';

    protected $fillable = [
        'appeal_id',
        'permit_id',
        'justifikasi',
        'extension_period',
        'new_expiry_date',
        'status',
        'pk_remarks',
        'is_approved_by_pk',
    ];

    protected $casts = [
        'new_expiry_date' => 'date',
        'is_approved_by_pk' => 'boolean',
    ];

    public function appeal()
    {
        return $this->belongsTo(Appeal::class);
    }

    public function permit()
    {
        return $this->belongsTo(Permit::class);
    }

    public function calculateNewExpiryDate()
    {
        $permit = $this->permit;
        $extensionMonths = $permit->getExtensionPeriod();
        
        return $permit->expiry_date->addMonths($extensionMonths);
    }

    public function approveByPK($remarks = null)
    {
        $this->update([
            'status' => 'approved',
            'pk_remarks' => $remarks,
            'is_approved_by_pk' => true,
        ]);

        // Update permit expiry date
        $this->permit->update([
            'expiry_date' => $this->new_expiry_date,
        ]);

        // Increment application count
        $this->permit->incrementApplicationCount();
    }

    public function rejectByPK($remarks = null)
    {
        $this->update([
            'status' => 'rejected',
            'pk_remarks' => $remarks,
        ]);
    }
}
