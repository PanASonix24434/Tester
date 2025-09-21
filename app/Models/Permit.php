<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;
    
    protected $table = 'permits_new';

    protected $fillable = [
        'no_permit',
        'kelulusan_perolehan_id',
        'jenis_peralatan',
        'status',
        'is_active',
        'application_count',
        'last_extension_date',
        'expiry_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_extension_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    public function kelulusanPerolehan()
    {
        return $this->belongsTo(KelulusanPerolehan::class, 'kelulusan_perolehan_id');
    }

    public function kvp08Applications()
    {
        return $this->hasMany(Kpv08Application::class, 'permit_id');
    }

    public function getStatusText()
    {
        return $this->status === 'ada_kemajuan' ? 'Ada kemajuan' : 'Tiada kemajuan';
    }

    public function getStatusClass()
    {
        return $this->status === 'ada_kemajuan' ? 'success' : 'warning';
    }

    /**
     * Check if permit can apply for extension based on business rules
     */
    public function canApplyForExtension()
    {
        // Get the number of existing applications for this permit
        $existingApplications = $this->kvp08Applications()->count();
        
        // If permit has progress, allow unlimited applications
        if ($this->status === 'ada_kemajuan') {
            return true;
        }
        
        // If permit has no progress, only allow up to 3 applications
        // 4th application will automatically cancel the permit
        return $existingApplications < 3;
    }

    /**
     * Get extension period based on zone
     */
    public function getExtensionPeriod()
    {
        // This should be based on the permit's zone
        // For now, using default values as per business requirements
        // C3 zone = 12 months, other zones = 6 months
        
        // You might need to add a 'zone' field to the permits table
        // For now, returning 6 months as default
        return 6;
    }

    /**
     * Get expiry date (you might need to add this field to the permits table)
     */
    public function getExpiryDateAttribute()
    {
        // This should return the actual expiry date from the database
        // For now, returning a default date
        return now()->addMonths(6);
    }

    /**
     * Get the next application count for this permit
     */
    public function getNextApplicationCount()
    {
        return $this->application_count + 1;
    }

    /**
     * Get application count text for display
     */
    public function getApplicationCountText()
    {
        $count = $this->getNextApplicationCount();
        
        switch ($count) {
            case 1:
                return 'Kali Pertama';
            case 2:
                return 'Kali Kedua';
            case 3:
                return 'Kali Ketiga';
            case 4:
                return 'Kali Keempat';
            default:
                return "Kali Ke-{$count}";
        }
    }

    /**
     * Increment application count when extension is approved
     */
    public function incrementApplicationCount()
    {
        $this->update([
            'application_count' => $this->application_count + 1,
            'last_extension_date' => now(),
        ]);
        
        // Create reminder for 3 months later
        $this->createExtensionReminder();
    }
    
    /**
     * Create reminder for extension after 3 months
     */
    public function createExtensionReminder()
    {
        $reminderDate = now()->addMonths(3);
        
        // Get user from company profile (simplified for testing)
        $user = User::first(); // Use first available user for testing
        
        if ($user) {
            PermitReminder::create([
                'permit_id' => $this->id,
                'user_id' => $user->id,
                'reminder_type' => 'extension_reminder',
                'reminder_date' => $reminderDate,
                'is_sent' => false,
            ]);
        }
    }

}
