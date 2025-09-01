@php
    $selectedYear = request('tahun');
    $statusStocks = $selectedYear 
        ? \App\Models\StatusStock::with('fishType')->where('tahun', $selectedYear)->whereNotNull('fish_type_id')->get()
        : collect();
@endphp

<div class="mb-2" style="border-bottom: 3px solid #007bff; width: fit-content; margin-left:16px;">
    <span class="fw-bold" style="color:#007bff;">Dokumen Permohonan untuk Keputusan</span>
</div>

@if($selectedYear)
    <div style="padding-left:16px; padding-right:16px;">
        <!-- Document Review Section -->
        <div class="card mb-4" style="border:1.5px solid #e3e6f0;">
            <div class="card-header" style="background:#f8f9fa; border-bottom:1.5px solid #e3e6f0;">
                <h6 class="mb-0"><i class="fas fa-file-alt"></i> Dokumen yang Dihantar</h6>
            </div>
            <div class="card-body">
                @if(count($statusStocks) > 0)
                    @php
                        $firstStock = $statusStocks->first();
                        $hasDokumenSenaraiStok = $firstStock && $firstStock->dokumen_senarai_stok;
                        $hasDokumenKelulusanKpp = $firstStock && $firstStock->dokumen_kelulusan_kpp;
                        

                    @endphp
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Dokumen Senarai Stok:</label>
                                @if($hasDokumenSenaraiStok)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger me-2"></i>
                                        <a href="{{ route('keputusan-status.download-dokumen-senarai-stok', ['tahun' => $selectedYear]) }}" class="text-decoration-none me-2">
                                            Lihat Dokumen
                                        </a>
                                        <small class="text-muted">({{ basename($firstStock->dokumen_senarai_stok) }})</small>
                                    </div>
                                @else
                                    <span class="text-muted">Tiada dokumen</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Dokumen Kelulusan KPP:</label>
                                @if($hasDokumenKelulusanKpp)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger me-2"></i>
                                        <a href="{{ route('keputusan-status.download-dokumen-kelulusan-kpp', ['tahun' => $selectedYear]) }}" class="text-decoration-none me-2">
                                            Lihat Dokumen
                                        </a>
                                        <small class="text-muted">({{ basename($firstStock->dokumen_kelulusan_kpp) }})</small>
                                    </div>
                                @else
                                    <span class="text-muted">Tiada dokumen</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Tiada data untuk tahun {{ $selectedYear }}</p>
                    </div>
                @endif
            </div>
        </div>



        <!-- Current Status Summary -->
        <div class="card mb-4" style="border:1.5px solid #e3e6f0;">
            <div class="card-header" style="background:#f8f9fa; border-bottom:1.5px solid #e3e6f0;">
                <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Ringkasan Status Semasa</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-primary">{{ count($statusStocks) }}</h4>
                            <small class="text-muted">Jumlah Rekod</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-info">{{ $statusStocks->where('status', 'submitted')->count() }}</h4>
                            <small class="text-muted">Status Dihantar</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-success">{{ $statusStocks->where('pengesahan_status', 'approved')->count() }}</h4>
                            <small class="text-muted">Pengesahan Lulus</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-warning">{{ $statusStocks->where('semakan_status', 'disemak')->count() }}</h4>
                            <small class="text-muted">Semakan Selesai</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="d-flex justify-content-center align-items-center mt-4" style="padding-left:16px; padding-right:16px;">
        <div class="me-3">
            <button type="button" class="btn btn-outline-secondary" onclick="goBack()" style="background-color: white; color: #6c757d; border-color: #6c757d;">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
        </div>
        <div class="me-3">
            <button type="button" class="btn btn-outline-primary" onclick="saveApproval()" style="background-color: white; color: #007bff; border-color: #007bff;">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
        <div>
            <button type="button" class="btn btn-primary" onclick="goNext()" style="background-color: #007bff; color: white; border-color: #007bff;">
                Seterusnya <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>
@else
    <div class="text-center py-5" style="padding-left:16px; padding-right:16px;">
        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">Sila Pilih Tahun</h5>
        <p class="text-muted">Pilih tahun untuk melihat dokumen permohonan</p>
    </div>
@endif

<script>
function goBack() {
    const currentYear = '{{ $selectedYear }}';
    window.location.href = `?tab=senarai_status&tahun=${currentYear}`;
}

function saveApproval() {
    Swal.fire({
        icon: 'success',
        title: 'Berjaya!',
        text: 'Data telah berjaya disimpan.',
        confirmButtonText: 'OK'
    });
}

function goNext() {
    const currentYear = '{{ $selectedYear }}';
    if (currentYear) {
        window.location.href = `?tab=tindakan&tahun=${currentYear}`;
    } else {
        alert('Sila pilih tahun terlebih dahulu');
    }
}
</script> 