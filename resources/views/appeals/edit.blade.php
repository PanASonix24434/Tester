@extends('layouts.app')

@section('content')
<style>
/* Hide navigation buttons only on edit page */
.navigation-buttons {
    display: none !important;
}

.appeal-form-container {
    max-width: 1000px;
    margin: 0 auto;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.appeal-header {
    background: #007BFF;
    color: white;
    padding: 20px;
    border-radius: 8px 8px 0 0;
    text-align: center;
    font-weight: bold;
    font-size: 18px;
}

.appeal-content {
    padding: 30px;
}

.section-title {
    color: #333;
    font-weight: bold;
    margin-bottom: 15px;
    font-size: 16px;
}

.officer-review-box {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}

.officer-info {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    font-weight: bold;
    color: #333;
}

.officer-info i {
    margin-right: 8px;
    color: #6c757d;
}

.officer-comment {
    color: #333;
    font-style: italic;
}

.appeal-textarea {
    min-height: 120px;
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 15px;
    font-size: 14px;
    resize: vertical;
}

.documents-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.documents-table th {
    background: #007BFF;
    color: white;
    padding: 12px;
    text-align: left;
    font-weight: bold;
}

.documents-table td {
    padding: 12px;
    border: 1px solid #ddd;
    vertical-align: middle;
}

.file-input-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.file-input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.file-upload-btn {
    background: #28a745;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.file-upload-btn:hover {
    background: #218838;
}

.delete-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
}

.delete-btn:hover {
    background: #c82333;
}

.add-document-btn {
    background: #17A2B8;
    color: #000;
    border: 1px solid #17A2B8;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    margin-bottom: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.add-document-btn:hover {
    background: #17A2B8;
    color: #000;
}

.file-restrictions {
    color: #6c757d;
    font-size: 12px;
    margin-top: 10px;
}

.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.back-btn {
    background: #282c34;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

.back-btn:hover {
    background: #1a1d23;
}

.submit-btn {
    background: #28a745;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

.submit-btn:hover {
    background: #218838;
}
</style>

<div id="app-content">
    <div class="app-content-area">
        <div class="container">
            <div class="appeal-form-container">
                <!-- Header -->
                <div class="appeal-header" style="background-color:#3C2387 ; color:#fff;">
                    Rayuan Permohonan
                </div>
                
                <!-- Content -->
                <div class="appeal-content">
                    <form method="POST" action="{{ route('appeals.update', $appeal->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Officer Review Section -->
                        <div class="section-title">Ulasan Pegawai</div>
                        <p style="color: #666; margin-bottom: 15px;">Semak ulasan pegawai dan nyatakan sebab rayuan anda.</p>
                        
                        <div class="officer-review-box">
                            <div class="officer-info">
                                <i class="fas fa-user"></i>
                                Pegawai A - {{ now()->format('d/m/Y H:i') }}
                            </div>
                            <div class="officer-comment">
                                {{ $perakuan->kcl_comments ?? $perakuan->ppl_comments ?? 'Sila kemukakan bukti pembelian yang jelas dan lengkap.' }}
                            </div>
                        </div>
                        
                        <!-- Appeal Review Section -->
                        <div class="section-title">Ulasan Rayuan <span style="color: red;">*</span></div>
                        <p style="color: #666; margin-bottom: 15px;">Nyatakan sebab rayuan anda.</p>
                        
                        <textarea name="justifikasi_pindaan" 
                                  id="justifikasi_pindaan" 
                                  class="form-control appeal-textarea" 
                                  placeholder="Ringkaskan sebab rayuan anda..."
                                  required>{{ old('justifikasi_pindaan', $perakuan->justifikasi_pindaan ?? '') }}</textarea>
                        @error('justifikasi_pindaan')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                        
                        <!-- Hidden fields -->
                        <input type="hidden" id="jenis_pindaan_syarat" name="jenis_pindaan_syarat" value="{{ $perakuan->jenis_pindaan_syarat }}">
                        <input type="hidden" id="jenis_perolehan" name="jenis_perolehan" value="{{ $perakuan->jenis_perolehan }}">
                        <input type="hidden" id="jenis_bahan_binaan_vesel" name="jenis_bahan_binaan_vesel" value="{{ $perakuan->jenis_bahan_binaan_vesel }}">
                        
                        <!-- Documents Section -->
                        <div class="section-title ">Dokumen</div>
                        
                        <table class="documents-table">
                            <thead>
                                <tr>
                                    <th style="width: 60px; background-color: #3C2387; color:#fff;">Bil</th>
                                    <th style="background-color: #3C2387; color:#fff;">Nama / Deskripsi Fail</th>
                                    <th style="width: 200px; background-color: #3C2387; color:#fff;">Muat Naik Fail</th>
                                    <th style="width: 80px; background-color: #3C2387; color:#fff;">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody id="documents-tbody">
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <input type="text" 
                                               class="form-control" 
                                               placeholder="Contoh: Fail Sokongan 1"
                                               name="document_names[]">
                                    </td>
                                    <td>
                                        <div class="file-input-group">
                                            <input type="file" 
                                                   class="file-input" 
                                                   name="documents[]"
                                                   accept=".pdf,.jpg,.jpeg,.png">
                                            <span style="font-size: 12px; color: #666;">No file selected</span>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="delete-btn" onclick="removeDocument(this)" title="Padam">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <button type="button" class="add-document-btn" style="background-color:#3cdccd; color:#000; border:1px solid #3cdccd; border-radius:8px;" onclick="addDocument()">
                            <i class="fas fa-plus" style="color: #000;"></i> Tambah Dokumen
                        </button>
                        
                        <div class="file-restrictions">
                            Format dibenarkan: PDF, JPG, JPEG, PNG. Saiz maksimum: 10MB setiap fail.
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('appeals.senarai_permohonan.index') }}" class="back-btn" style="background-color: #1E293B ; color:#fff; border:1px solid #1E293B ; border-radius:8px;">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-paper-plane"></i> Hantar Rayuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let documentCounter = 1;

// Function to add new document row
function addDocument() {
    documentCounter++;
    const tbody = document.getElementById('documents-tbody');
    const newRow = document.createElement('tr');
    
    newRow.innerHTML = `
        <td>${documentCounter}</td>
        <td>
            <input type="text" 
                   class="form-control" 
                   placeholder="Contoh: Fail Sokongan ${documentCounter}"
                   name="document_names[]">
        </td>
        <td>
            <div class="file-input-group">
                <input type="file" 
                       class="file-input" 
                       name="documents[]"
                       accept=".pdf,.jpg,.jpeg,.png"
                       onchange="updateFileStatus(this)">
                <span class="file-status" style="font-size: 12px; color: #666;">No file selected</span>
            </div>
        </td>
        <td>
            <button type="button" class="delete-btn" onclick="removeDocument(this)" title="Padam">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    
    tbody.appendChild(newRow);
}

// Function to remove document row
function removeDocument(button) {
    const row = button.closest('tr');
    if (row) {
        row.remove();
        // Renumber remaining rows
        renumberRows();
    }
}

// Function to renumber rows after deletion
function renumberRows() {
    const rows = document.querySelectorAll('#documents-tbody tr');
    rows.forEach((row, index) => {
        row.cells[0].textContent = index + 1;
    });
    documentCounter = rows.length;
}

// Function to update file status display
function updateFileStatus(input) {
    const statusSpan = input.parentNode.querySelector('.file-status');
    if (input.files && input.files[0]) {
        statusSpan.textContent = input.files[0].name;
        statusSpan.style.color = '#28a745';
    } else {
        statusSpan.textContent = 'No file selected';
        statusSpan.style.color = '#666';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to existing file inputs
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            updateFileStatus(this);
        });
    });
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const textarea = document.getElementById('justifikasi_pindaan');
        if (!textarea.value.trim()) {
            e.preventDefault();
            alert('Sila isi ulasan rayuan anda.');
            textarea.focus();
            return false;
        }
    });
});
</script>
@endpush 