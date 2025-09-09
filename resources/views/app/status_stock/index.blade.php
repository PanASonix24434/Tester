@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var tambahItemModal = new bootstrap.Modal(document.getElementById('tambahItemModal'));
                        tambahItemModal.show();
                    });
                </script>
            @endif
            <div class="row">
                <div class="col-12">
                    <h2 class="mt-3 mb-4">Kemasukan Laporan</h2>
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #007bff;">
                            Kemaskini Status Semasa Stok
                        </div>
                        <div class="card-body">
                            <!-- Main form for Tahun and Dokumen Kelulusan KPP (no Hantar button here) -->
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto px-2 font-weight-bold" style="font-size: 1rem;">Maklumat Status Stok Semasa</legend>
                                <!-- Visible fields for layout (outside the form) -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tahun" class="form-label">Tahun:</label>
                                        <select class="form-control" id="tahun" required onchange="window.location.href='?tahun=' + this.value;">
                                            <option value="">-- Pilih Tahun --</option>
                                            @for ($y = date('Y'); $y >= 2010; $y--)
                                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dokumen_kpp_visible" class="form-label">Dokumen Kelulusan KPP: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="dokumen_kpp_visible" accept=".jpg,.jpeg,.png,.pdf" required>
                                            <button class="btn btn-outline-secondary" type="button">Pilih Fail</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <!-- Senarai Status as tab navigation -->
                            <ul class="nav nav-tabs mb-3" id="statusTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="senarai-status-tab" data-bs-toggle="tab" data-bs-target="#senarai-status" type="button" role="tab" aria-controls="senarai-status" aria-selected="true">Senarai Status</button>
                                </li>
                            </ul>
                            <div class="tab-content mb-3" id="statusTabContent">
                                <div class="tab-pane fade show active " id="senarai-status" role="tabpanel" aria-labelledby="senarai-status-tab">
                                    <!-- Content for Senarai Status tab (if any) -->
                                </div>
                            </div>
                            <div class="mb-2 fw-bold pb-1" style="color: #007bff; border-bottom: 3px solid #007bff;">
                                Senarai Status Stok Semasa
                            </div>
                            <div class="d-flex justify-content-end mb-2">
                                <button type="button" class="btn btn-primary" id="tambahItemBtn" style="background-color: #007bff;">
                                  <i class="fa fa-plus"></i> Tambah Item
                                </button>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const tambahItemBtn = document.getElementById('tambahItemBtn');
                                        
                                        if (tambahItemBtn) {
                                        tambahItemBtn.addEventListener('click', function() {
                                            const tahunSelect = document.getElementById('tahun');
                                            if (!tahunSelect.value) {
                                                alert('Sila pilih tahun terlebih dahulu sebelum menambah item.');
                                                tahunSelect.focus();
                                                return;
                                            }
                                            var tambahItemModal = new bootstrap.Modal(document.getElementById('tambahItemModal'));
                                            tambahItemModal.show();
                                            
                                            // Initialize Vesel/Zon functionality when modal opens
                                            setTimeout(function() {
                                                initializeVeselZon();
                                            }, 500);
                                        });
                                        }
                                    });
                                </script>
                            </div>
                            <div class="table-responsive">
                                <style>
                                    .grouped-table {
                                        border-collapse: collapse;
                                    }
                                    .grouped-table th {
                                        background-color: #007bff;
                                        color: white;
                                        text-align: center;
                                        padding: 12px 8px;
                                        font-weight: bold;
                                        border: 1.5px solid #e3e6f0;
                                    }
                                    .grouped-table td {
                                        padding: 12px 8px;
                                        vertical-align: middle;
                                        border: 1.5px solid #e3e6f0;
                                        background: #fff;
                                    }
                                    .fish-type-header {
                                        background-color: #f8f9fa;
                                        font-weight: bold;
                                        color: #1976d2;
                                    }
                                    .fma-cell {
                                        background-color: #f8f9fa;
                                        text-align: center;
                                        font-weight: bold;
                                        color: #424242;
                                    }
                                    .stock-cell {
                                        text-align: center;
                                        font-weight: 500;
                                        background-color: #f8f9fa;
                                    }
                                    .row-number {
                                        background-color: #e9ecef;
                                        text-align: center;
                                        font-weight: bold;
                                        color: #495057;
                                    }
                                    .grouped-table tbody tr:hover {
                                        background-color: #f5f5f5;
                                    }
                                    .grouped-table tbody tr:hover td {
                                        background-color: #f5f5f5;
                                    }
                                </style>
                                <table class="table table-bordered grouped-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px;">Bil</th>
                                            <th style="min-width: 180px;">Kumpulan Ikan</th>
                                            <th style="min-width: 100px;">FMA</th>
                                            <th style="min-width: 120px;">Jenis</th>
                                            <th style="min-width: 150px;">Butiran</th>
                                            <th style="min-width: 120px;">Jenis Sumber</th>
                                            <th style="min-width: 120px;">Bilangan Stok</th>
                                            <th style="min-width: 100px;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $rowNumber = 1; @endphp
                                        @forelse($groupedStatusStocks as $fishTypeId => $stocks)
                                            @php 
                                                $validStocks = $stocks->filter(function($stock) {
                                                    return $stock && $stock->fishType && $stock->fma;
                                                });
                                                $firstStock = $validStocks->first();
                                            @endphp
                                            @if($firstStock && $firstStock->fishType && $validStocks->count() > 0)
                                                @php $stockCount = $validStocks->count(); @endphp
                                                <!-- Debug: Fish Type {{ $firstStock->fishType->name }} (ID: {{ $fishTypeId }}) has {{ $stockCount }} records -->
                                                @foreach($validStocks as $index => $stock)
                                                    <tr>
                                                        @if($index === 0)
                                                            <td rowspan="{{ $stockCount }}" class="row-number">
                                                                {{ $rowNumber }}
                                                            </td>
                                                            <td rowspan="{{ $stockCount }}" class="fish-type-header">
                                                                <strong>{{ $stock->fishType->name ?? '-' }}</strong>
                                                            </td>
                                                        @endif
                                                        <td class="fma-cell">
                                                            {{ $stock->fma }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if($stock->selection_type === 'vesel')
                                                                Vesel
                                                            @elseif($stock->selection_type === 'zon')
                                                                Zon
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($stock->selection_type === 'vesel')
                                                                {{ $stock->vesel_type ?? '-' }}
                                                            @elseif($stock->selection_type === 'zon')
                                                                {{ $stock->zon_type ?? '-' }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $stock->jenis_sumber ?? '-' }}
                                                        </td>
                                                        <td class="stock-cell">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <span class="fw-bold me-1">{{ number_format($stock->bilangan_stok) }}</span>
                                                                <small class="text-muted">unit</small>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($stock->status === 'draft')
                                                                <span class="badge bg-warning text-dark">Draf</span>
                                                            @elseif($stock->status === 'submitted')
                                                                <span class="badge bg-info">Dihantar</span>
                                                            @elseif($stock->pengesahan_status === 'approved')
                                                                <span class="badge bg-success">Diluluskan</span>
                                                            @elseif($stock->pengesahan_status === 'rejected')
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @else
                                                                <span class="badge bg-secondary">Menunggu</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @php $rowNumber++; @endphp
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                                    <br>
                                                    <span class="text-muted">Tiada data untuk tahun ini.</span>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4 mb-3">
                                <button type="button" class="btn btn-white border border-primary fa fa-arrow-left me-2">Kembali</button>
                                <button type="button" class="btn btn-white border-primary fa fa-save me-2">Simpan</button>
                                <!-- Hantar form (hidden fields inside) -->
                                <form id="mainStatusStockForm" enctype="multipart/form-data" method="POST" action="{{ route('status-stock.store') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="tahun" id="hiddenTahun">
                                    <input type="file" name="dokumen_kpp" id="hiddenDokumenKpp" style="display:none;">
                                    <button type="submit" class="btn btn-primary" style="background-color: #007bff;"><i class="fa fa-paper-plane"></i> Hantar</button>
                                </form>
                            </div> 
                        </div> <!-- end card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Item Modal -->
<div class="modal fade" id="tambahItemModal" tabindex="-1" aria-labelledby="tambahItemModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahItemModalLabel">Tambah Item Stok</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Modal form for adding item -->
        <form id="tambahItemForm" enctype="multipart/form-data" method="POST" action="{{ route('status-stock.add-item') }}">
            @csrf
            <input type="hidden" name="tahun" id="modalTahun">
            <input type="hidden" name="dokumen_kelulusan_kpp" id="modalDokumenKpp">
            <input type="hidden" name="uploadedDokumenKppPath" id="uploadedDokumenKppPath">
            <!-- Dokumen Kelulusan KPP input removed from modal -->
            <div class="mb-3">
                <label for="kumpulanIkan" class="form-label">Kumpulan Ikan <span class="text-danger">*</span></label>
                <select class="form-select" id="kumpulanIkan" name="kumpulanIkan" required>
                    <option value="">-- Pilih Kumpulan Ikan --</option>
                    @foreach($fishTypes as $fishType)
                            <option value="{{ $fishType->id }}">{{ $fishType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="fma" class="form-label">FMA <span class="text-danger">*</span></label>
                <select class="form-select" id="fma" name="fma" required>
                    <option value="">-- Pilih FMA --</option>
                    <option value="FMA01">FMA01 - Perlis, Kedah, Pulau Pinang, Perak & Selangor</option>
                    <option value="FMA02">FMA02 - Negeri Sembilan, Melaka & Johor Barat</option>
                    <option value="FMA03">FMA03 - Kelantan & Terengganu</option>
                    <option value="FMA04">FMA04 - Pahang & Johor Timur</option>
                    <option value="FMA05">FMA05 - Sarawak</option>
                    <option value="FMA06">FMA06 - Limbang Lawas</option>
                    <option value="FMA07">FMA07 - Labuan</option>
                </select>
            </div>
            
            <!-- Vesel/Zon Selection Section (Hidden initially) -->
            <div id="veselZonSection" class="mb-3" style="display: none;">
                <div class="mb-3">
                    <label class="form-label">Pilih Jenis: <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="selection_type" id="veselRadio" value="vesel" required>
                        <label class="form-check-label" for="veselRadio">
                            Vesel
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="selection_type" id="zonRadio" value="zon" required>
                        <label class="form-check-label" for="zonRadio">
                            Zon
                        </label>
                    </div>
                </div>
                
                <!-- Vesel Dropdown (Hidden initially) -->
                <div id="veselDropdown" class="mb-3" style="display: none;">
                    <label for="vesel_type" class="form-label">Jenis Vesel <span class="text-danger">*</span></label>
                    <select class="form-select" id="vesel_type" name="vesel_type" required>
                        <option value="">-- Pilih Jenis Vesel --</option>
                        <option value="Sampan">Sampan</option>
                        <option value="Jerut Bilis">Jerut Bilis</option>
                        <option value="PTMT">PTMT</option>
                        <option value="Kenka 2 bot">Kenka 2 bot</option>
                        <option value="Siput retak seribu">Siput retak seribu</option>
                    </select>
                </div>
                
                <!-- Zon Dropdown (Hidden initially) -->
                <div id="zonDropdown" class="mb-3" style="display: none;">
                    <label for="zon_type" class="form-label">Jenis Zon <span class="text-danger">*</span></label>
                    <select class="form-select" id="zon_type" name="zon_type" required>
                        <option value="">-- Pilih Jenis Zon --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="C2">C2</option>
                    </select>
                </div>
            </div>
            
            <!-- Jenis Sumber Dropdown -->
            <div class="mb-3">
                <label for="jenis_sumber" class="form-label">Jenis Sumber <span class="text-danger">*</span></label>
                <select class="form-select" id="jenis_sumber" name="jenis_sumber" required>
                    <option value="">-- Pilih Jenis Sumber --</option>
                    <option value="Pelagik">Pelagik</option>
                    <option value="Demersal">Demersal</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="bilanganStok" class="form-label">Bilangan Stok <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="bilanganStok" name="bilanganStok" required min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Masukkan nombor sahaja">
            </div>
            <div class="mb-2 fw-bold" style="color: #007bff;">Muat Naik Borang Excel</div>
            <hr style="border-top: 2px solid #007bff; margin-bottom: 1rem;">
            <div class="mb-3">
                <label for="dokumenSenaraiStok" class="form-label">Dokumen Senarai Stok Semasa <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="file" class="form-control" id="dokumenSenaraiStok" name="dokumenSenaraiStok" accept=".jpg,.jpeg,.png,.pdf" required>
                    <button class="btn btn-outline-secondary" type="button">Pilih Fail</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" style="background-color: #007bff;">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Hidden draft form for Simpan button -->
<form id="draftForm" enctype="multipart/form-data" method="POST" action="{{ route('status-stock.draft') }}" style="display:none;">
    @csrf
    <input type="hidden" name="tahun" id="draftTahun">
    <input type="file" name="dokumen_kpp" id="draftDokumenKpp" style="display:none;">
    <input type="hidden" name="kumpulanIkan" id="draftKumpulanIkan">
    <input type="hidden" name="fma" id="draftFma">
    <input type="hidden" name="bilanganStok" id="draftBilanganStok">
    <input type="file" name="dokumenSenaraiStok" id="draftDokumenSenaraiStok" style="display:none;">
</form>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="fas fa-check-circle"></i> Berjaya!
                </h5>
            </div>
            <div class="modal-body text-center">
                <div class="success-animation mb-4">
                    <div class="checkmark-circle">
                        <div class="checkmark draw"></div>
                    </div>
                </div>
                <h5 class="text-success mb-3">Data Status Stok Berjaya Dihantar!</h5>
                <p class="text-muted">
                    Semua data status stok telah dikemaskini dalam pangkalan data untuk tahun <span id="successYear"></span>.
                </p>
                <div class="mt-4">
                    <i class="fas fa-database text-primary me-2"></i>
                    <span class="text-muted small">Data telah disimpan dengan selamat</span>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" onclick="redirectToDashboard()">
                    <i class="fas fa-home"></i> Kembali ke Dashboard
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Success Animation CSS */
.success-animation {
    display: flex;
    justify-content: center;
    align-items: center;
}

.checkmark-circle {
    width: 80px;
    height: 80px;
    position: relative;
    background: #28a745;
    border-radius: 50%;
    box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.2);
    animation: scale-in 0.5s ease-in-out;
}

.checkmark {
    width: 40px;
    height: 20px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -60%) rotate(-45deg);
    border-left: 4px solid white;
    border-bottom: 4px solid white;
    opacity: 0;
    animation: checkmark-draw 0.8s ease-in-out 0.5s forwards;
}

@keyframes scale-in {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes checkmark-draw {
    0% {
        opacity: 0;
        width: 0;
        height: 0;
    }
    50% {
        opacity: 1;
        width: 20px;
        height: 10px;
    }
    100% {
        opacity: 1;
        width: 40px;
        height: 20px;
    }
}

/* Modal animation enhancements */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
}

.modal.show .modal-dialog {
    transform: none;
}

.modal-content {
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}
</style>

<script>
function redirectToDashboard() {
    window.location.href = '{{ route("home") }}';
}

document.addEventListener('DOMContentLoaded', function() {
    // Integer validation for Bilangan Stok
    const bilanganStokInput = document.getElementById('bilanganStok');
    if (bilanganStokInput) {
        bilanganStokInput.addEventListener('input', function(e) {
            // Remove any non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Ensure it's not negative
            if (this.value < 0) {
                this.value = 0;
            }
        });
        
        bilanganStokInput.addEventListener('blur', function(e) {
            // Ensure it's a valid integer
            if (this.value && !Number.isInteger(Number(this.value))) {
                this.value = Math.floor(Number(this.value));
            }
        });
    }
    
    const hantarForm = document.getElementById('mainStatusStockForm');
    if (hantarForm) {
        hantarForm.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const tahun = document.getElementById('tahun').value;
            const dokumenKpp = document.getElementById('dokumen_kpp_visible').files.length;
            if (!tahun || !dokumenKpp) {
                alert('Sila isi Tahun dan muat naik Dokumen Kelulusan KPP sebelum menghantar!');
                return false;
            }
            
            // Set form values
            document.getElementById('hiddenTahun').value = tahun;
            const visibleFileInput = document.getElementById('dokumen_kpp_visible');
            const hiddenFileInput = document.getElementById('hiddenDokumenKpp');
            
            console.log('Visible file input files:', visibleFileInput.files);
            console.log('Visible file input files length:', visibleFileInput.files.length);
            
            if (visibleFileInput.files.length > 0) {
                console.log('File details:', {
                    name: visibleFileInput.files[0].name,
                    size: visibleFileInput.files[0].size,
                    type: visibleFileInput.files[0].type
                });
            hiddenFileInput.files = visibleFileInput.files;
                console.log('Copied files to hidden input');
            } else {
                console.log('No files in visible input');
            }
            
            // Create FormData
            const formData = new FormData(this);
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Show loading state
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghantar...';
            submitButton.disabled = true;
            
            console.log('Submitting main form data via AJAX:');
            for (let [key, value] of formData.entries()) {
                if (value instanceof File) {
                    console.log(key + ': [File] ' + value.name + ' (' + value.size + ' bytes)');
                } else {
                    console.log(key + ': ' + value);
                }
            }
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                
                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('CSRF token mismatch. Please refresh the page and try again.');
                    } else if (response.status === 422) {
                        return response.json().then(data => {
                            throw new Error('Validation error: ' + JSON.stringify(data.errors));
                        });
                    } else {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Show success modal
                    document.getElementById('successYear').textContent = tahun;
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                } else {
                    alert('Ralat! ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ralat semasa menghantar data: ' + error.message);
            })
            .finally(() => {
                // Restore button state
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
            
            return false;
        });
    }
    
    // Handle tambah item form submission via AJAX
    const tambahItemForm = document.getElementById('tambahItemForm');
    if (tambahItemForm) {
        console.log('Found tambahItemForm, setting up AJAX handler');

        // Prevent any default form submission
        tambahItemForm.addEventListener('submit', function(e) {
            console.log('Form submit event triggered');
            e.preventDefault();
            e.stopPropagation();

            try {
                // Check for duplicate before submitting
                const kumpulanIkan = document.getElementById('kumpulanIkan').value;
                const fma = document.getElementById('fma').value;
                const tahun = document.getElementById('tahun').value;
                
                if (kumpulanIkan && fma && tahun) {
                    // Check if this combination already exists in the table
                    const tableRows = document.querySelectorAll('.grouped-table tbody tr');
                    let isDuplicate = false;
                    let existingFishTypeName = '';
                    
                    tableRows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        if (cells.length >= 3) {
                            const fishTypeCell = cells[1]; // Fish type is in second column
                            const fmaCell = cells[2]; // FMA is in third column
                            
                            if (fishTypeCell && fmaCell) {
                                const fishTypeName = fishTypeCell.textContent.trim();
                                const fmaValue = fmaCell.textContent.trim();
                                
                                // Get the selected fish type name
                                const selectedOption = document.querySelector(`#kumpulanIkan option[value="${kumpulanIkan}"]`);
                                const selectedFishTypeName = selectedOption ? selectedOption.textContent.trim() : '';
                                
                                if (fishTypeName === selectedFishTypeName && fmaValue === fma) {
                                    isDuplicate = true;
                                    existingFishTypeName = fishTypeName;
                                }
                            }
                        }
                    });
                    
                    if (isDuplicate) {
                        alert(`Rekod untuk ${existingFishTypeName} dengan FMA ${fma} sudah wujud untuk tahun ${tahun}. Sila pilih kombinasi yang berbeza.`);
                        return false;
                    }
                }

                // Set modal values before submitting
                const tahunSelect = document.getElementById('tahun');
                const modalTahun = document.getElementById('modalTahun');
                if (tahunSelect && modalTahun) {
                    modalTahun.value = tahunSelect.value;
                }
                
                const uploadedDokumenKppPath = document.getElementById('uploadedDokumenKppPath');
                const modalDokumenKpp = document.getElementById('modalDokumenKpp');
                if (uploadedDokumenKppPath && modalDokumenKpp) {
                    modalDokumenKpp.value = uploadedDokumenKppPath.value;
                }
                
                const formData = new FormData(this);
                
                // Remove file field if no file is selected
                const fileInput = document.getElementById('dokumenSenaraiStok');
                console.log('File input files length:', fileInput.files.length);
                console.log('File input value:', fileInput.value);
                
                if (fileInput && fileInput.files.length === 0) {
                    formData.delete('dokumenSenaraiStok');
                    console.log('Removed dokumenSenaraiStok from FormData');
                } else if (fileInput && fileInput.files.length > 0) {
                    console.log('File selected:', fileInput.files[0].name);
                }
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Show loading state
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                submitButton.disabled = true;
                
                console.log('Submitting form data via AJAX:');
                for (let [key, value] of formData.entries()) {
                    if (value instanceof File) {
                        console.log(key + ': [File] ' + value.name + ' (' + value.size + ' bytes)');
                    } else {
                        console.log(key + ': ' + value);
                    }
                }
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    
                    if (!response.ok) {
                        if (response.status === 419) {
                            throw new Error('CSRF token mismatch. Please refresh the page and try again.');
                        } else if (response.status === 422) {
                            return response.json().then(data => {
                                if (data.isDuplicate) {
                                    throw new Error(data.message);
                                } else {
                                    throw new Error('Validation error: ' + JSON.stringify(data.errors));
                                }
                            });
                        } else {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        alert('Berjaya! ' + data.message);
                        // Close modal and refresh page
                        const modal = bootstrap.Modal.getInstance(document.getElementById('tambahItemModal'));
                        modal.hide();
                        window.location.reload();
                    } else {
                        alert('Ralat! ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ralat semasa menyimpan data: ' + error.message);
                })
                .finally(() => {
                    // Restore button state
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                });
                
            } catch (error) {
                console.error('JavaScript error:', error);
                alert('Ralat JavaScript: ' + error.message);
                // Restore button state
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.innerHTML = 'Simpan';
                submitButton.disabled = false;
            }
            
            return false; // Ensure form doesn't submit normally
        });
        
        // Also prevent submit button click from submitting normally
        const submitButton = tambahItemForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.addEventListener('click', function(e) {
                console.log('Submit button clicked');
                // Don't prevent default here, let the form submit event handle it
            });
        }
    } else {
        console.error('tambahItemForm not found!');
    }
});

document.getElementById('simpanDraftBtn').addEventListener('click', function() {
    document.getElementById('draftTahun').value = document.getElementById('tahun').value;
    // For dokumen_kpp, file input cannot be set by JS for security reasons. User must select file again if needed.
    document.getElementById('draftKumpulanIkan').value = document.getElementById('kumpulanIkan').value;
    document.getElementById('draftFma').value = document.getElementById('fma').value;
    document.getElementById('draftBilanganStok').value = document.getElementById('bilanganStok').value;
    // For dokumenSenaraiStok, file input cannot be set by JS for security reasons. User must select file again if needed.
    document.getElementById('draftForm').submit();
});
// Copy Tahun and Dokumen Kelulusan KPP to hidden fields before submit
const hantarForm = document.getElementById('mainStatusStockForm');
if (hantarForm) {
    hantarForm.addEventListener('submit', function(e) {
        document.getElementById('hiddenTahun').value = document.getElementById('tahun').value;
        // For dokumen_kpp, file input cannot be set by JS for security reasons. User must select file again if needed.
        // If you want to require the user to select the file again, you can add a visible file input here.
    });
}

// Only open modal if Tahun and Dokumen Kelulusan KPP are filled
document.addEventListener('DOMContentLoaded', function() {
    // Only open modal if Tahun and Dokumen Kelulusan KPP are filled
    const tambahItemBtn = document.getElementById('tambahItemBtn');
    if (tambahItemBtn) {
        tambahItemBtn.addEventListener('click', function() {
            var tambahItemModal = new bootstrap.Modal(document.getElementById('tambahItemModal'));
            tambahItemModal.show();
        });
    }
});

// AJAX upload for Dokumen Kelulusan KPP
const dokumenKppInput = document.getElementById('dokumen_kpp_visible');
dokumenKppInput.addEventListener('change', function(e) {
    const file = dokumenKppInput.files[0];
    if (!file) return;
    const formData = new FormData();
    formData.append('dokumen_kpp', file);
    formData.append('_token', '{{ csrf_token() }}');
    fetch('{{ route('status-stock.upload') }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.path) {
            document.getElementById('uploadedDokumenKppPath').value = data.path;
        } else {
            alert('Gagal muat naik dokumen.');
        }
    })
    .catch(() => alert('Ralat muat naik dokumen.'));
});

document.addEventListener('DOMContentLoaded', function() {
    const tahunSelect = document.getElementById('tahun');
    if (tahunSelect) {
        tahunSelect.addEventListener('change', function() {
            const tahun = this.value;
            fetch(`/status_stok/ajax-status?tahun=${tahun}`)
                .then(response => response.text())
                .then(html => {
                    document.querySelector('table.table-bordered tbody').innerHTML = html;
                });
        });
    }
});

// Vesel/Zon Dynamic Functionality
function initializeVeselZon() {
    const fmaSelect = document.getElementById('fma');
    const veselZonSection = document.getElementById('veselZonSection');
    const veselRadio = document.getElementById('veselRadio');
    const zonRadio = document.getElementById('zonRadio');
    const veselDropdown = document.getElementById('veselDropdown');
    const zonDropdown = document.getElementById('zonDropdown');
    const veselTypeSelect = document.getElementById('vesel_type');
    const zonTypeSelect = document.getElementById('zon_type');

    // Show Vesel/Zon section when FMA is selected
    if (fmaSelect) {
        // Remove any existing event listeners
        fmaSelect.removeEventListener('change', handleFmaChange);
        fmaSelect.addEventListener('change', handleFmaChange);
    }

    // Show Vesel dropdown when Vesel radio is selected
    if (veselRadio) {
        veselRadio.removeEventListener('change', handleVeselChange);
        veselRadio.addEventListener('change', handleVeselChange);
    }

    // Show Zon dropdown when Zon radio is selected
    if (zonRadio) {
        zonRadio.removeEventListener('change', handleZonChange);
        zonRadio.addEventListener('change', handleZonChange);
    }
}

function handleFmaChange() {
    const fmaSelect = document.getElementById('fma');
    const veselZonSection = document.getElementById('veselZonSection');
    const veselRadio = document.getElementById('veselRadio');
    const zonRadio = document.getElementById('zonRadio');
    const veselDropdown = document.getElementById('veselDropdown');
    const zonDropdown = document.getElementById('zonDropdown');
    const veselTypeSelect = document.getElementById('vesel_type');
    const zonTypeSelect = document.getElementById('zon_type');
    
    if (fmaSelect.value) {
        veselZonSection.style.display = 'block';
    } else {
        veselZonSection.style.display = 'none';
        // Reset selections and remove required attributes
        if (veselRadio) veselRadio.checked = false;
        if (zonRadio) zonRadio.checked = false;
        if (veselDropdown) {
            veselDropdown.style.display = 'none';
            veselTypeSelect.required = false;
        }
        if (zonDropdown) {
            zonDropdown.style.display = 'none';
            zonTypeSelect.required = false;
        }
        if (veselTypeSelect) veselTypeSelect.value = '';
        if (zonTypeSelect) zonTypeSelect.value = '';
    }
}

function handleVeselChange() {
    const veselDropdown = document.getElementById('veselDropdown');
    const zonDropdown = document.getElementById('zonDropdown');
    const veselTypeSelect = document.getElementById('vesel_type');
    const zonTypeSelect = document.getElementById('zon_type');
    
    if (this.checked) {
        veselDropdown.style.display = 'block';
        veselTypeSelect.required = true;
        zonDropdown.style.display = 'none';
        zonTypeSelect.required = false;
        if (zonTypeSelect) zonTypeSelect.value = ''; // Clear zon selection
    }
}

function handleZonChange() {
    const veselDropdown = document.getElementById('veselDropdown');
    const zonDropdown = document.getElementById('zonDropdown');
    const veselTypeSelect = document.getElementById('vesel_type');
    const zonTypeSelect = document.getElementById('zon_type');
    
    if (this.checked) {
        zonDropdown.style.display = 'block';
        zonTypeSelect.required = true;
        veselDropdown.style.display = 'none';
        veselTypeSelect.required = false;
        if (veselTypeSelect) veselTypeSelect.value = ''; // Clear vesel selection
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initializeVeselZon();
});
</script>
@endsection 