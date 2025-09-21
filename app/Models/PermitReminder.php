<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'permit_id',
        'user_id',
        'reminder_type',
        'reminder_date',
        'sent_date',
        'is_sent',
        'email_content',
        'email_status',
        'email_error',
    ];

    protected $casts = [
        'reminder_date' => 'date',
        'sent_date' => 'date',
        'is_sent' => 'boolean',
    ];

    /**
     * Get the permit that owns the reminder
     */
    public function permit()
    {
        return $this->belongsTo(Permit::class);
    }

    /**
     * Get the user that owns the reminder
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark reminder as sent
     */
    public function markAsSent($status = 'sent', $error = null)
    {
        $this->update([
            'is_sent' => true,
            'sent_date' => now(),
            'email_status' => $status,
            'email_error' => $error,
        ]);
    }
    
    /**
     * Mark email as failed
     */
    public function markAsFailed($error)
    {
        $this->update([
            'email_status' => 'failed',
            'email_error' => $error,
        ]);
    }
}
