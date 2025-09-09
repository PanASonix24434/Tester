@extends('layouts.app')

@section('title', 'Pelupusan SSD - KDP')

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

                    <!-- Tarikh Pelupusan Stok SSD Section -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h4 class="card-title mb-0">Maklumat Pelupusan Stok SSD</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tarikh_pelupusan">Tarikh Pelupusan Stok SSD:</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="tarikh_pelupusan" name="tarikh_pelupusan" value="{{ date('Y-m-d') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Navigation -->
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="pelupusanTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="maklumat-tab" data-toggle="tab" href="#maklumat" role="tab" aria-controls="maklumat" aria-selected="true">
                                        Maklumat Permohonan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tindakan-tab" data-toggle="tab" href="#tindakan" role="tab" aria-controls="tindakan" aria-selected="false">
                                        Tindakan
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="pelupusanTabsContent">
                                <!-- Maklumat Permohonan Tab -->
                                <div class="tab-pane fade show active" id="maklumat" role="tabpanel" aria-labelledby="maklumat-tab">
                                    @include('app.ssd_stock.partials.pelupusan_maklumat')
                                </div>

                                <!-- Tindakan Tab -->
                                <div class="tab-pane fade" id="tindakan" role="tabpanel" aria-labelledby="tindakan-tab">
                                    @include('app.ssd_stock.partials.pelupusan_tindakan')
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
    // Handle tab switching
    $('#pelupusanTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    // Handle add item button
    $('#tambahItem').click(function() {
        console.log('Tambah item button clicked'); // Debug log
        $('#tambahItemModal').modal('show');
    });
    
    // Handle tambah item form submission
    $('#tambahItemBtn').click(function() {
        var jenisLesen = $('#jenis_lesen').val();
        var noSsd = $('#no_ssd_modal').val();
        var tarikhPelupusan = $('#tarikh_pelupusan_modal').val();
        
        if (!jenisLesen || !noSsd) {
            alert('Sila isi semua medan yang diperlukan!');
            return;
        }
        
        // Add logic to add new item to disposal list
        console.log('Adding new disposal item:', {
            jenisLesen: jenisLesen,
            noSsd: noSsd,
            tarikhPelupusan: tarikhPelupusan
        });
        
        // Close modal and reset form
        $('#tambahItemModal').modal('hide');
        $('#tambahItemForm')[0].reset();
        $('#tarikh_pelupusan_modal').val('Auto');
        
        alert('Item telah ditambah ke senarai pelupusan!');
    });
    
    // Handle modal close events
    $('#tambahItemModal').on('hidden.bs.modal', function () {
        // Reset form when modal is closed
        $('#tambahItemForm')[0].reset();
        $('#tarikh_pelupusan_modal').val('Auto');
    });
    
    // Handle Kembali button click
    $('.modal-footer .btn-secondary').click(function() {
        $('#tambahItemModal').modal('hide');
    });
    
    // Handle X close button click
    $('.modal-header .close').click(function() {
        $('#tambahItemModal').modal('hide');
    });
    
    // Handle modal backdrop click
    $('#tambahItemModal').on('click', function(e) {
        if (e.target === this) {
            $(this).modal('hide');
        }
    });
});
</script>
@endpush