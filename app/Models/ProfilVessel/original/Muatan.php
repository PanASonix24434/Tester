<?php

namespace App\Models\ProfilVessel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muatan extends Model
{
    use HasFactory;

    protected $table = 'muatan';

    protected $fillable = [
        'kulit_id',
        'gt_1',
        'gt_2',
        'grt_1',
        'grt_2',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function kulit()
    {
        return $this->belongsTo(Kulit::class, 'no_rujukan_permohonan', 'no_rujukan_permohonan');
    }
}
