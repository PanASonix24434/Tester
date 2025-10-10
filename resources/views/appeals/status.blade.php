@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
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
                    <!-- Status Information Card -->
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
                                    // Determine the tindakan (action) based on appeal type
                                    // For appeals, it's always "Rayuan", for new applications it's "Permohonan"
                                    $tindakan = 'Rayuan'; // Since this is an appeals system
                                    
                                    // Determine the peringkat (level) based on current status
                                    $peringkat = '';
                                    $status = $appeal->status;
                                    
                                    switch ($status) {
                                        case 'submitted':
                                        case 'ppl_review':
                                        case 'ppl_incomplete':
                                            $peringkat = 'PPL';
                                            break;
                                        case 'kcl_review':
                                        case 'kcl_incomplete':
                                        case 'kcl_rejected':
                                            $peringkat = 'KCL';
                                            break;
                                        case 'pk_review':
                                        case 'pk_incomplete':
                                        case 'kpp_decision':
                                            $peringkat = 'PK';
                                            break;
                                        case 'approved':
                                        case 'rejected':
                                            $peringkat = 'KPP';
                                            break;
                                        default:
                                            $peringkat = 'SISTEM';
                                    }
                                    
                                    // Determine if it's a decision or review action
                                    $isDecision = in_array($status, ['approved', 'rejected', 'kpp_decision']);
                                    $actionType = $isDecision ? 'Keputusan' : 'Semakan';
                                    
                                    // For applicant view, show: "Pemohon → Rayuan Dihantar"
                                    $applicantStatus = "Pemohon → {$tindakan} Dihantar";
                                    
                                    // For officer view (if needed), show: "→ Semakan - PPL" or "→ Keputusan - PK"
                                    $officerStatus = "→ {$actionType} - {$peringkat}";
                                    
                                    // Status colors
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
                                    $color = $statusColors[$status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} fs-6 fw-bold text-uppercase px-3 py-2" style="font-size: 1rem;">
                                    {{ $applicantStatus }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Details Card -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-white"><i class="fas fa-file-alt me-2 text-white"></i>Butiran Permohonan</h5>
                        </div>
                        <div class="card-body">
                            <!-- Bootstrap Tab Navigation -->
                            <ul class="nav nav-tabs mb-4" id="statusTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="butiran-status-tab" data-bs-toggle="tab" data-bs-target="#butiran-status" type="button" role="tab" aria-controls="butiran-status" aria-selected="true">Butiran Permohonan</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="dokumen-status-tab" data-bs-toggle="tab" data-bs-target="#dokumen-status" type="button" role="tab" aria-controls="dokumen-status" aria-selected="false">Dokumen Permohonan</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="perakuan-status-tab" data-bs-toggle="tab" data-bs-target="#perakuan-status" type="button" role="tab" aria-controls="perakuan-status" aria-selected="false">Perakuan</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="statusTabContent">
                                <!-- Butiran Permohonan Tab -->
                                <div class="tab-pane fade show active" id="butiran-status" role="tabpanel" aria-labelledby="butiran-status-tab">
                                    @include('appeals.partials.status_butiran_permohon', ['perakuan' => $perakuan])
                                </div>

                                <!-- Dokumen Permohonan Tab -->
                                <div class="tab-pane fade" id="dokumen-status" role="tabpanel" aria-labelledby="dokumen-status-tab">
                                    @include('appeals.partials.status_dokumen_pemohon', ['appeal' => $appeal])
                                </div>

                                <!-- Perakuan Tab -->
                                <div class="tab-pane fade" id="perakuan-status" role="tabpanel" aria-labelledby="perakuan-status-tab">
                                    @include('appeals.partials.status_perakuan', ['perakuan' => $perakuan])
                                </div>
                            </div>
                        </div>
                    </div>

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

                    <!-- Navigation Buttons -->
                    <div class="text-center mt-4">
                        <!-- Show Edit button only if application is rejected or incomplete -->
                        @if(in_array($appeal->status, ['ppl_incomplete', 'kcl_incomplete', 'pk_incomplete', 'rejected']))
                            <a href="{{ route('appeals.edit', $appeal->id) }}" class="btn btn-warning btn-lg px-5 me-3">
                                <i class="fas fa-edit me-2"></i> Edit Permohonan
                            </a>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
@endsection
