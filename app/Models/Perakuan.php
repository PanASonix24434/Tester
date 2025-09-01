<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Appeal;

class Perakuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'appeal_id',
        'perakuan',
        'type',
        'jenis_pindaan_syarat',
        'jenis_bahan_binaan_vesel',
        'nyatakan',
        'jenis_perolehan',
        'negeri_limbungan_baru',
        'nama_limbungan_baru',
        'daerah_baru',
        'alamat_baru',
        'poskod_baru',
        'pernah_berdaftar',
        'no_pendaftaran_vesel',
        'negeri_asal_vesel',
        'pelabuhan_pangkalan',
        'pangkalan_asal',
        'pangkalan_baru',
        'justifikasi_pindaan',
        'justifikasi_perolehan',
        'justifikasi_lanjutan_tempoh',
        'tarikh_mula_kelulusan',
        'tarikh_tamat_kelulusan',
        // New fields for Vesel Bina Baru Luar Negara
        'alamat_limbungan_luar_negara',
        'negara_limbungan',
        // New fields for equipment change
        'no_permit_peralatan',
        'jenis_peralatan_asal',
        'jenis_peralatan_baru',
        'justifikasi_tukar_peralatan',
        // New fields for company name change
        'no_pendaftaran_perniagaan',
        'tarikh_pendaftaran_syarikat',
        'tarikh_luput_pendaftaran',
        'status_perniagaan',
        'nama_syarikat_baru',
        'justifikasi_tukar_nama',
        'status',
        'surat_jual_beli_terpakai_path',
        'lesen_skl_terpakai_path',
        'dokumen_sokongan_terpakai_path',
        'akuan_sumpah_bina_baru_path',
        'lesen_skl_bina_baru_path',
        'dokumen_sokongan_bina_baru_path',
        'dokumen_sokongan_pangkalan_path',
        'dokumen_sokongan_bahan_binaan_path',
        'dokumen_sokongan_path',
        // New document fields for equipment change
        'dokumen_sokongan_tukar_peralatan_path',
        // New document fields for company name change
        'borang_e_kaedah_13_path',
        'profil_perniagaan_enterprise_path',
        'form_9_path',
        'form_24_path',
        'form_44_path',
        'form_49_path',
        'pendaftaran_persatuan_path',
        'profil_persatuan_path',
        'pendaftaran_koperasi_path',
        'profil_koperasi_path',
        // New fields for updated document structure
        'kertas_kerja_bina_baru_path',
        'kertas_kerja_bina_baru_luar_negara_path',
        'dokumen_sokongan_bina_baru_array',
        'dokumen_sokongan_bina_baru_luar_negara_array',
        // Additional dokumen sokongan array fields
        'dokumen_sokongan_terpakai_array',
        'dokumen_sokongan_pangkalan_array',
        'dokumen_sokongan_bahan_binaan_array',
        'dokumen_sokongan_tukar_peralatan_array',
        // New fields for kelulusan perolehan selection
        'kelulusan_perolehan_id',
        'selected_permits',
    ];

    protected $casts = [
        'perakuan' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            $userId = $model->user_id ?? auth()->id();
    
            if (empty($model->appeal_id) || $model->appeal_id == 0 || $model->appeal_id === '0') {
                // Find existing appeal by user
                $latestAppeal = \App\Models\Appeal::where('applicant_id', $userId)
                                                  ->orderByDesc('created_at')
                                                  ->first();
    
                if ($latestAppeal) {
                    $model->appeal_id = $latestAppeal->id;
                } else {
                    // If no appeal exists, create a new one
                    $newAppeal = \App\Models\Appeal::create([
                        'applicant_id' => $userId,
                        'status' => 'draft',
                    ]);
                    $model->appeal_id = $newAppeal->id;
                }
            }
        });
    }

    public function appeal()
    {
        return $this->belongsTo(Appeal::class, 'appeal_id');
    }

    public function kelulusanPerolehan()
    {
        return $this->belongsTo(KelulusanPerolehan::class);
    }
}
