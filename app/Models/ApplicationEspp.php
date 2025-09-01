<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationEspp extends Model
{
    use HasFactory;

    protected $table = 'application_espps';
    
    protected $fillable = [
        'applicant_icno',
        'applicant_name',
        // Add other fields as needed
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
} 