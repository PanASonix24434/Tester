<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DokumenSokongan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'dokumen_sokongan';

    protected $fillable = [
        'id',
        'appeals_id',
        'ref_number',
        'user_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'mime_type',
        'upload_date'
    ];

    protected $casts = [
        'upload_date' => 'datetime',
        'file_size' => 'integer',
    ];

    // Relationships
    public function appeal()
    {
        return $this->belongsTo(Appeal::class, 'appeals_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function getFileSizeInKB()
    {
        return $this->file_size ? round($this->file_size / 1024, 2) : 0;
    }

    public function getFileSizeInMB()
    {
        return $this->file_size ? round($this->file_size / (1024 * 1024), 2) : 0;
    }

    public function getFileExtension()
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }

    public function isImage()
    {
        return in_array($this->mime_type, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']);
    }

    public function isPDF()
    {
        return $this->mime_type === 'application/pdf';
    }
}
