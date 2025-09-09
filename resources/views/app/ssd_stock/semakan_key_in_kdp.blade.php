@extends('layouts.app')

@section('title', 'Semakan Key In - KDP')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title text-white">
                                <i class="fas fa-boxes"></i>
                                Pengurusan Stok SSD
                            </h3>
                        </div>
                    </div>

                    <!-- Maklumat Permohonan Stok SSD -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h4 class="card-title mb-0">Maklumat Permohonan Stok SSD</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tarikh_permohonan">Tarikh Permohonan Stok SSD:</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="tarikh_permohonan" name="tarikh_permohonan" value="{{ date('Y-m-d') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="negeri">Negeri:</label>
                                        <input type="text" class="form-control" id="negeri" name="negeri" placeholder="Enter...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="daerah">Daerah:</label>
                                        <input type="text" class="form-control" id="daerah" name="daerah" placeholder="Enter...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Navigation -->
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="semakanTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="maklumat-tab" data-toggle="tab" href="#maklumat" role="tab" aria-controls="maklumat" aria-selected="true">
                                        Maklumat Permohonan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="status-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false">
                                        Status Permohonan
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="semakanTabsContent">
                                <!-- Maklumat Permohonan Tab -->
                                <div class="tab-pane fade show active" id="maklumat" role="tabpanel" aria-labelledby="maklumat-tab">
                                    @include('app.ssd_stock.partials.kdp_maklumat_permohonan')
                                </div>

                                <!-- Status Permohonan Tab -->
                                <div class="tab-pane fade" id="status" role="tabpanel" aria-labelledby="status-tab">
                                    @include('app.ssd_stock.partials.kdp_status_permohonan')
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back()">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </button>
                                    <button type="button" class="btn btn-success mr-2">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-arrow-right"></i> Hantar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Set current date
    $('#tarikh_permohonan').val('{{ date("Y-m-d") }}');
    
    // Handle tab switching
    $('#semakanTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    // Handle approval/rejection buttons
    $('.btn-approve').click(function() {
        var row = $(this).closest('tr');
        var license = row.find('td:eq(1)').text();
        console.log('Approved:', license);
        // Add approval logic here
    });
    
    $('.btn-reject').click(function() {
        var row = $(this).closest('tr');
        var license = row.find('td:eq(1)').text();
        console.log('Rejected:', license);
        // Add rejection logic here
    });
});
</script>
@endpush
