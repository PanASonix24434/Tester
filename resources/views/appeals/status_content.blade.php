{{-- Status content for AJAX loading (no layout) --}}
<div class="container py-4">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body p-0">
                    <div class="bg-white border rounded-3 shadow-sm p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($appeal->created_at)->format('d M Y') }}</span>
                            <span class="text-muted small"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($appeal->created_at)->format('H:i') }}</span>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3 fw-bold">Nama</div>
                            <div class="col-md-9">: {{ $reviewerName ?? '-' }}</div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-3 fw-bold">Status</div>
                            <div class="col-md-9">
                                :
                                @php
                                    $statusLabels = [
                                        'submitted' => 'MENUNGGU SEMAKAN PEGAWAI PERIKANAN',
                                        'ppl_review' => 'DALAM SEMAKAN PEGAWAI PERIKANAN',
                                        'ppl_incomplete' => 'TIDAK LENGKAP (PEGAWAI PERIKANAN)',
                                        'kcl_review' => 'DALAM SEMAKAN KETUA CAWANGAN',
                                        'kcl_incomplete' => 'TIDAK LENGKAP (KETUA CAWANGAN)',
                                        'pk_review' => 'DALAM SEMAKAN PENGARAH KANAN',
                                        'pk_incomplete' => 'TIDAK LENGKAP (PENGARAH KANAN)',
                                        'kpp_decision' => 'MENUNGGU KEPUTUSAN KPP',
                                        'approved' => 'KEPUTUSAN PERMOHONAN - DILULUSKAN',
                                        'rejected' => 'KEPUTUSAN PERMOHONAN - TIDAK DILULUSKAN',
                                        'draft' => 'DRAFT',
                                    ];
                                    $currentStatus = $statusLabels[$appeal->status] ?? strtoupper($appeal->status);
                                    $statusClass = in_array($appeal->status, ['approved']) ? 'success' : 
                                                  (in_array($appeal->status, ['rejected', 'ppl_incomplete', 'kcl_incomplete', 'pk_incomplete']) ? 'danger' : 'primary');
                                @endphp
                                <span class="badge bg-{{ $statusClass }} text-white px-3 py-2 rounded-pill">
                                    {{ $currentStatus }}
                                </span>
                            </div>
                        </div>

                        <!-- Surat Kelulusan KPP -->
                        @if(!empty($appeal->surat_kelulusan_kpp) || !empty($appeal->kpp_ref_no))
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-3 fw-bold">Surat Kelulusan KPP</div>
                                <div class="col-md-9">:
                                    @if(!empty($appeal->surat_kelulusan_kpp))
                                        <a href="{{ route('appeals.viewSuratKelulusanKpp', $appeal->id) }}" target="_blank" class="btn btn-primary btn-sm mt-2">Lihat / Muat Turun</a>
                                    @else
                                        <span class="text-muted">Tiada dokumen dimuat naik.</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 fw-bold">No. Rujukan Surat Kelulusan KPP</div>
                                <div class="col-md-9">:
                                    <input type="text" class="form-control mt-2" value="{{ $appeal->kpp_ref_no ?? '-' }}" readonly>
                                </div>
                            </div>
                        @endif

                        <!-- Ulasan PPL - Only show if status requires comments -->
                        @if(!empty($appeal->ppl_comments) && $appeal->ppl_status === 'Tidak Lengkap')
                            <div class="row mb-2">
                                <div class="col-md-3 fw-bold">Ulasan Pegawai Perikanan Negeri</div>
                                <div class="col-md-9">:
                                    <div class="mt-2 border rounded bg-light p-2" style="min-height: 60px;">
                                        {{ $appeal->ppl_comments }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Ulasan KCL - Only show if status requires comments -->
                        @if(!empty($appeal->kcl_comments) && ($appeal->kcl_status === 'Tidak Disokong' || $appeal->kcl_status === 'Tidak Lengkap'))
                            <div class="row mb-2">
                                <div class="col-md-3 fw-bold">Ulasan Ketua Cawangan</div>
                                <div class="col-md-9">:
                                    <div class="mt-2 border rounded bg-light p-2" style="min-height: 60px;">
                                        {{ $appeal->kcl_comments }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Ulasan PK - Only show if status requires comments -->
                        @if(!empty($appeal->pk_comments) && $appeal->pk_status === 'Tidak Diluluskan')
                            <div class="row mb-2">
                                <div class="col-md-3 fw-bold">Ulasan Pengarah Kanan</div>
                                <div class="col-md-9">:
                                    <div class="mt-2 border rounded bg-light p-2" style="min-height: 60px;">
                                        {{ $appeal->pk_comments }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Ulasan KPP -->
                        @if(!empty($appeal->kpp_comments))
                            <div class="row mb-2">
                                <div class="col-md-3 fw-bold">Ulasan KPP</div>
                                <div class="col-md-9">:
                                    <div class="mt-2 border rounded bg-light p-2" style="min-height: 60px;">
                                        {{ $appeal->kpp_comments }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Tiada ulasan jika semua kosong -->
                        @if(empty($appeal->ppl_comments) && empty($appeal->kcl_comments) && empty($appeal->pk_comments) && empty($appeal->kpp_comments))
                            <div class="row mb-2">
                                <div class="col-md-3 fw-bold">Ulasan</div>
                                <div class="col-md-9">:
                                    <div class="mt-2 border rounded bg-light p-2" style="min-height: 60px;">
                                        Tiada ulasan.
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Show Edit button only if application is rejected or incomplete -->
                        @if(in_array($appeal->status, ['ppl_incomplete', 'kcl_incomplete', 'pk_incomplete', 'rejected']))
                            <div class="text-center mt-4">
                                <a href="{{ route('appeals.edit', $appeal->id) }}" class="btn btn-warning btn-lg px-5 me-3">
                                    <i class="fas fa-edit me-2"></i> Edit Permohonan
                                </a>
                            </div>
                        @endif
                        
                        <!-- Action Message -->
                        @if(in_array($appeal->status, ['ppl_incomplete', 'kcl_incomplete', 'pk_incomplete', 'rejected']))
                            <div class="alert alert-warning mt-4">
                                <h5><i class="fas fa-exclamation-triangle me-2"></i>Permohonan Memerlukan Tindakan</h5>
                                <p class="mb-0">
                                    Permohonan anda memerlukan tindakan selanjutnya. Sila edit permohonan berdasarkan ulasan yang diberikan dan submit semula.
                                </p>
                            </div>
                        @elseif(in_array($appeal->status, ['approved']))
                            <div class="alert alert-success mt-4">
                                <h5><i class="fas fa-check-circle me-2"></i>Permohonan Diluluskan</h5>
                                <p class="mb-0">
                                    Tahniah! Permohonan anda telah diluluskan. Surat kelulusan boleh dimuat turun di atas.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
