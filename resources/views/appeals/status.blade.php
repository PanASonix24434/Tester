@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="bg-white border rounded-3 shadow-sm p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($appeal->created_at)->format('d M Y') }}</span>
                            <span class="text-muted small"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($appeal->created_at)->format('H:i') }}</span>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3 fw-bold">Nama</div>
                            <div class="col-md-9">: {{ $reviewerName }}</div>
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
                                    $statusColors = [
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'draft' => 'secondary',
                                        'submitted' => 'info',
                                        'ppl_review' => 'info',
                                        'ppl_incomplete' => 'warning',
                                        'kcl_review' => 'info',
                                        'kcl_incomplete' => 'warning',
                                        'pk_review' => 'info',
                                        'pk_incomplete' => 'warning',
                                        'kpp_decision' => 'primary',
                                    ];
                                    $status = $appeal->status;
                                    $label = $statusLabels[$status] ?? strtoupper(str_replace('_', ' ', $status));
                                    $color = $statusColors[$status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} fs-6 fw-bold text-uppercase px-3 py-2" style="font-size: 1rem;">
                                    {{ $label }}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3 fw-bold">Ulasan KPP</div>
                            <div class="col-md-9">:
                                <div class="mt-2 border rounded bg-light p-2" style="min-height: 60px;">
                                    {{ $appeal->kpp_comments ?? 'Tiada ulasan.' }}
                                </div>
                            </div>
                        </div>
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
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('appeals.amendment') }}" class="btn btn-secondary btn-lg px-5">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
@endsection
