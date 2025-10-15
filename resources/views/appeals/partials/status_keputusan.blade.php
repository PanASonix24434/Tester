{{-- Keputusan Permohonan Section --}}
<div class="mb-4">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Keputusan Permohonan</h6>
    
    @php
        // Determine application type based on perakuan type
        $applicationType = '';
        if ($perakuan && $perakuan->type === 'kvp07') {
            $applicationType = 'Rayuan Pindaan Syarat';
        } elseif ($perakuan && $perakuan->type === 'kvp08') {
            $applicationType = 'Lanjutan Tempoh';
        } else {
            $applicationType = 'Permohonan Perolehan Lesen Vesel Dan Peralatan Menangkap Ikan C3';
        }
        
        // Determine status based on workflow stages for applicant role
        $currentStatus = $appeal->pemohon_status ?? 'Permohonan Dihantar';
        
        // Check decisions for more accurate status
        $pkSemakanStatus = $appeal->pk_semakan_status ?? '';
        $pkDecision = $appeal->pk_decision ?? '';
        $kclStatus = $appeal->kcl_status ?? '';
        $kclSupport = $appeal->kcl_support ?? '';
        $pplStatus = $appeal->ppl_status ?? '';
        
        // Priority order: Final decisions first, then current stage decisions, then workflow progress
        if ($pkDecision === 'Diluluskan') {
            $statusText = 'DILULUSKAN';
            $isApproved = true;
            $isRejected = false;
        } elseif ($pkDecision === 'Tidak Diluluskan') {
            $statusText = 'TIDAK LULUS';
            $isApproved = false;
            $isRejected = true;
        } elseif ($kclSupport === 'Tidak Sokong') {
            $statusText = 'TIDAK DISOKONG';
            $isApproved = false;
            $isRejected = true;
        } elseif ($pplStatus === 'Tidak Lengkap') {
            $statusText = 'TIDAK LENGKAP';
            $isApproved = false;
            $isRejected = true;
        } elseif (!empty($appeal->pk_submitted_at)) {
            // PK stage completed but no decision yet
            $statusText = 'DIPROSES NEGERI';
            $isApproved = false;
            $isRejected = false;
        } elseif (!empty($appeal->kcl_submitted_at)) {
            // KCL stage completed, now in PK stage
            $statusText = 'DIPROSES NEGERI';
            $isApproved = false;
            $isRejected = false;
        } elseif (!empty($appeal->ppl_submitted_at)) {
            // PPL stage completed, now in KCL stage
            $statusText = 'DIPROSES DAERAH';
            $isApproved = false;
            $isRejected = false;
        } elseif (!empty($appeal->submitted_at)) {
            // Application submitted, now in PPL stage
            $statusText = 'DIHANTAR';
            $isApproved = false;
            $isRejected = false;
        } else {
            // Default status
            $statusText = 'DIHANTAR';
            $isApproved = false;
            $isRejected = false;
        }
        
        // Lulus Hijau / Gagal Merah color scheme
        if ($isApproved) {
            // Lulus Hijau (Green)
            $statusColor = '#ffffff';
            $statusBgColor = '#28a745';
            $alertBgColor = '#d4edda';
            $alertTextColor = '#155724';
        } elseif ($isRejected) {
            // Gagal Merah (Red)
            $statusColor = '#ffffff';
            $statusBgColor = '#dc3545';
            $alertBgColor = '#f8d7da';
            $alertTextColor = '#721c24';
        } else {
            // Diproses (Blue)
            $statusColor = '#ffffff';
            $statusBgColor = '#007bff';
            $alertBgColor = '#d1ecf1';
            $alertTextColor = '#0c5460';
        }
        
        $messagePrefix = $isApproved ? 'Dengan sukacita dimaklumkan bahawa status permohonan anda bagi' : 
                        ($isRejected ? 'Dimaklumkan bahawa status permohonan anda bagi' : 'Status permohonan anda bagi');
        $messageSuffix = $isApproved ? 'mengikut syarat yang telah ditetapkan.' : 
                        ($isRejected ? 'telah ditolak.' : 'sedang diproses.');
    @endphp
    
    
        <p class="mb-3" style="color: #495057;">
            {{ $messagePrefix }} 
            @if($perakuan && $perakuan->type === 'kvp08')
                <span class="fw-bold" style="color: #1a1a1a;">
                    {{ $perakuan->no_pendaftaran_vesel ?? $applicationType }}
                </span>
            @else
                <span class="border border-primary rounded px-2 py-1 mx-1" style="background-color: #e3f2fd;">
                    {{ $perakuan->no_pendaftaran_vesel ?? $applicationType }}
                </span>
            @endif
            telah 
            <span class="rounded px-3 py-2 mx-1" style="background-color: {{ $statusBgColor }}; color: {{ $statusColor }}; font-weight: bold;">
                {{ $statusText }}
            </span>
            {{ $messageSuffix }}
        </p>
  
</div>

{{-- Surat Kelulusan KPP Section --}}
<div class="mb-4">
    
    <p class="mb-3" style="color: #495057;">Untuk butiran dan maklumat lanjut, sila rujuk:</p>
    
    <div class="row">
        <div class="col-md-12">
            
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">Surat Keputusan Permohonan</label>
                <div class="rounded p-3" style="min-height: 60px;">
                    @if(!empty($appeal->pk_submitted_at) && (!empty($appeal->surat_kelulusan_kpp) || !empty($appeal->kpp_ref_no)))
                        <div class="d-flex gap-2">
                            <a href="{{ route('appeals.print_letter', $appeal->id) }}" target="_blank" class="btn btn-sm" style="background-color: #5da5eb; color: #000; border: 1px solid #ddd; border-radius: 6px;">
                                <i class="fas fa-print me-1"></i> Cetak Surat
                            </a>
                            <a href="{{ route('appeals.download_letter_pdf', $appeal->id) }}" class="btn btn-sm" style="background-color: #3cdccd; color: #000; border: 1px solid #ddd; border-radius: 6px;">
                                <i class="fas fa-download me-1"></i> Muat Turun PDF
                            </a>
                        </div>
                    @else
                        <span class="text-muted">Surat kelulusan KPP belum tersedia</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Navigation Button -->
<div class="text-center mt-4">
    <button type="button" class="btn btn-sm me-3" style="background-color: #282c34; color: #fff; border: 1px solid #282c34; border-radius: 8px;" onclick="prevTab('perakuan-status-tab')">
        <i class="fas fa-arrow-left me-2" style="color: #fff;"></i> Kembali
    </button>
</div>

