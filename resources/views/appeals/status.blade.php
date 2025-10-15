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
            
            <div class="row">
                <div class="col-12">

                    <!-- Form Details Card -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-white"><i class="fas fa-file-alt me-2 text-white"></i>Maklumat Permohonan</h5>
                        </div>
                        <div class="card-body">
                            <!-- Bootstrap Tab Navigation -->
                            <ul class="nav nav-tabs mb-4" id="statusTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pemohon-status-tab" data-bs-toggle="tab" data-bs-target="#pemohon-status" type="button" role="tab" aria-controls="pemohon-status" aria-selected="true">Maklumat Pemohon</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="butiran-status-tab" data-bs-toggle="tab" data-bs-target="#butiran-status" type="button" role="tab" aria-controls="butiran-status" aria-selected="false">Maklumat Permohonan</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="dokumen-status-tab" data-bs-toggle="tab" data-bs-target="#dokumen-status" type="button" role="tab" aria-controls="dokumen-status" aria-selected="false">Dokumen Permohonan</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="perakuan-status-tab" data-bs-toggle="tab" data-bs-target="#perakuan-status" type="button" role="tab" aria-controls="perakuan-status" aria-selected="false">Perakuan</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="keputusan-status-tab" data-bs-toggle="tab" data-bs-target="#keputusan-status" type="button" role="tab" aria-controls="keputusan-status" aria-selected="false">Keputusan</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="statusTabContent">
                                <!-- Maklumat Pemohon Tab -->
                                <div class="tab-pane fade show active" id="pemohon-status" role="tabpanel" aria-labelledby="pemohon-status-tab">
                                    @include('appeals.partials.status_maklumat_pemohon', ['applicant' => $applicant])
                                </div>

                                <!-- Maklumat Permohonan Tab -->
                                <div class="tab-pane fade" id="butiran-status" role="tabpanel" aria-labelledby="butiran-status-tab">
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

                                <!-- Keputusan Tab -->
                                <div class="tab-pane fade" id="keputusan-status" role="tabpanel" aria-labelledby="keputusan-status-tab">
                                    @include('appeals.partials.status_keputusan', ['appeal' => $appeal, 'perakuan' => $perakuan])
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

<script>
// Tab Navigation Functions
function nextTab(tabId) {
    const tabButton = document.querySelector(`#${tabId}`);
    if (tabButton) {
        const tab = new bootstrap.Tab(tabButton);
        tab.show();
    }
}

function prevTab(tabId) {
    const tabButton = document.querySelector(`#${tabId}`);
    if (tabButton) {
        const tab = new bootstrap.Tab(tabButton);
        tab.show();
    }
}
</script>

@endsection
