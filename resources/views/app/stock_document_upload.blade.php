@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container py-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #0084ff; color: #fff; font-weight: 500;">
                    <h5 class="mb-0">
                        <i class="fas fa-upload me-2"></i>
                        Upload Dokumen Pengurusan Stok
                    </h5>
                </div>
                <div class="card-body">
                    
                    <!-- Success/Error Messages -->
                    <div id="alert-container"></div>
                    
                    <!-- Upload Form -->
                    <form id="documentUploadForm" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="document_type" class="form-label fw-bold">Jenis Dokumen <span class="text-danger">*</span></label>
                                    <select class="form-control" id="document_type" name="document_type" required>
                                        <option value="" selected disabled>Pilih Jenis Dokumen</option>
                                        <option value="fma_composition">Komposisi FMA (Fisheries Management Area)</option>
                                        <option value="licensing_quota">Kuota Pelesenan Mengikut FMA</option>
                                    </select>
                                    <small class="form-text text-muted">Pilih jenis dokumen yang akan diupload</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="year" class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                                    <select class="form-control" id="year" name="year" required>
                                        <option value="" selected disabled>Pilih Tahun</option>
                                        @for($i = date('Y'); $i >= 2020; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <small class="form-text text-muted">Pilih tahun untuk data yang akan diupload</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="document" class="form-label fw-bold">Dokumen <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="document" name="document" 
                                   accept=".xlsx,.xls,.csv" required>
                            <small class="form-text text-muted">
                                Format yang disokong: Excel (.xlsx, .xls) atau CSV (.csv). Saiz maksimum: 10MB
                            </small>
                        </div>
                        
                        <!-- Document Format Instructions -->
                        <div class="mb-4">
                            <div class="alert alert-info">
                                <h6 class="fw-bold mb-2">Format Dokumen Yang Disokong:</h6>
                                
                                <div id="fma-instructions" style="display: none;">
                                    <strong>Komposisi FMA:</strong>
                                    <ul class="mb-0 mt-1">
                                        <li>Kolumn 1: Nombor FMA (1, 2, 3, 4, 5, 6, 7)</li>
                                        <li>Kolumn 2: Negeri (Perlis, Kedah, Pulau Pinang, Perak & Selangor)</li>
                                        <li>Kolumn 3: Pengerusi (Perak)</li>
                                    </ul>
                                </div>
                                
                                <div id="quota-instructions" style="display: none;">
                                    <strong>Kuota Pelesenan:</strong>
                                    <ul class="mb-0 mt-1">
                                        <li>Kolumn 1: Kategori (Sampan, A, B Pelagik, B Demersal, C Pelagik, C Demersal, C2 Pelagik, C2 Demersal, Jerut Bilis, PTMT, Kenka 2 Bot, Siput Retak Seribu)</li>
                                        <li>Kolumn 2-8: Kuota untuk FMA 01, 02, 03, 04, 05, 06, 07</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" id="uploadBtn">
                                <i class="fas fa-upload me-2"></i>
                                Upload & Proses Dokumen
                            </button>
                        </div>
                    </form>
                    
                    <!-- Processing Status -->
                    <div id="processing-status" class="mt-4" style="display: none;">
                        <div class="alert alert-warning">
                            <div class="d-flex align-items-center">
                                <div class="spinner-border spinner-border-sm me-2" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span>Sedang memproses dokumen...</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Results Display -->
                    <div id="results-container" class="mt-4" style="display: none;">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Dokumen Berjaya Diproses
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="results-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sample Document Templates Modal -->
<div class="modal fade" id="templateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Template Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="template-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="download-template">Download Template</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('documentUploadForm');
    const documentTypeSelect = document.getElementById('document_type');
    const fmaInstructions = document.getElementById('fma-instructions');
    const quotaInstructions = document.getElementById('quota-instructions');
    
    // Show/hide instructions based on document type
    documentTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        
        // Hide all instructions
        fmaInstructions.style.display = 'none';
        quotaInstructions.style.display = 'none';
        
        // Show relevant instructions
        if (selectedType === 'fma_composition') {
            fmaInstructions.style.display = 'block';
        } else if (selectedType === 'licensing_quota') {
            quotaInstructions.style.display = 'block';
        }
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const uploadBtn = document.getElementById('uploadBtn');
        const processingStatus = document.getElementById('processing-status');
        const resultsContainer = document.getElementById('results-container');
        const alertContainer = document.getElementById('alert-container');
        
        // Show processing status
        uploadBtn.disabled = true;
        processingStatus.style.display = 'block';
        resultsContainer.style.display = 'none';
        
        // Clear previous alerts
        alertContainer.innerHTML = '';
        
        // Upload and process document
        fetch('{{ route("stock.process-document") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            processingStatus.style.display = 'none';
            uploadBtn.disabled = false;
            
            if (data.success) {
                // Show success message
                alertContainer.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                
                // Show results
                const resultsContent = document.getElementById('results-content');
                resultsContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Jenis Dokumen:</strong> ${data.data.type === 'fma_composition' ? 'Komposisi FMA' : 'Kuota Pelesenan'}</p>
                            <p><strong>Tahun:</strong> ${data.data.year}</p>
                            <p><strong>Rekod Diproses:</strong> ${data.data.records_processed}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fail:</strong> ${data.file_path}</p>
                            <p><strong>Masa Upload:</strong> ${new Date().toLocaleString('ms-MY')}</p>
                        </div>
                    </div>
                `;
                
                resultsContainer.style.display = 'block';
                
                // Reset form
                form.reset();
                fmaInstructions.style.display = 'none';
                quotaInstructions.style.display = 'none';
                
            } else {
                // Show error message
                alertContainer.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
            }
        })
        .catch(error => {
            processingStatus.style.display = 'none';
            uploadBtn.disabled = false;
            
            console.error('Error:', error);
            alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Ralat memproses dokumen. Sila cuba lagi.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        });
    });
});
</script>
@endsection
