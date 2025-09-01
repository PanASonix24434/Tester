<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelulusanPerolehan extends Model
{
    use HasFactory;

    protected $table = 'kelulusan_perolehan';

    protected $fillable = [
        'no_rujukan',
        'jenis_permohonan',
        'status',
        'tarikh_kelulusan',
        'tarikh_tamat',
        'user_id',
    ];

    protected $casts = [
        'tarikh_kelulusan' => 'date',
        'tarikh_tamat' => 'date',
    ];

    public function permits()
    {
        return $this->hasMany(Permit::class, 'kelulusan_perolehan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function activePermits()
    {
        return $this->permits()->where('is_active', true);
    }

    public function isExpired()
    {
        return $this->tarikh_tamat->isPast();
    }

    public function isActive()
    {
        return $this->status === 'active' && !$this->isExpired();
    }
}
