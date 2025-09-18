@extends('layouts.app')

@section('content')
<style>
/* Hide navigation buttons only on edit page */
.navigation-buttons {
    display: none !important;
}
</style>
<div id="app-content">
    <div class="app-content-area">
        <div class="container">
            <h3>Edit & Resubmit Permohonan</h3>
            <form method="POST" action="{{ route('appeals.update', $appeal->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="justifikasi_pindaan" class="form-label">Justifikasi Pindaan</label>
                    <textarea name="justifikasi_pindaan" id="justifikasi_pindaan" class="form-control" required>{{ old('justifikasi_pindaan', $perakuan->justifikasi_pindaan ?? '') }}</textarea>
                    @error('justifikasi_pindaan')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" id="jenis_pindaan_syarat" name="jenis_pindaan_syarat" value="{{ $perakuan->jenis_pindaan_syarat }}">
                <input type="hidden" id="jenis_perolehan" name="jenis_perolehan" value="{{ $perakuan->jenis_perolehan }}">
                <input type="hidden" id="jenis_bahan_binaan_vesel" name="jenis_bahan_binaan_vesel" value="{{ $perakuan->jenis_bahan_binaan_vesel }}">
                 @include('appeals.partials.dokumen_pemohon')
                 
                 <!-- Action Buttons -->
                 <div class="text-center mt-4">
                     <button type="submit" class="btn btn-primary me-3">Hantar Semula</button>
                     <a href="{{ route('appeals.status', $appeal->id) }}" class="btn btn-secondary">Batal</a>
                 </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

// Function to add dokumen sokongan
function addDokumenSokongan(containerId, fieldName) {
    var container = document.getElementById(containerId);
    if (!container) return;
    
    var newItem = document.createElement('div');
    newItem.className = 'dokumen-sokongan-item mb-2';
    newItem.innerHTML = `
        <div class="input-group">
            <input type="file" class="form-control dokumen-sokongan-input" name="${fieldName}" accept=".pdf,.png,.jpg,.jpeg">
            <button type="button" class="btn btn-outline-danger btn-remove-dokumen" onclick="removeDokumenSokongan(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
    `;
    
    container.appendChild(newItem);
}

// Function to remove dokumen sokongan
function removeDokumenSokongan(button) {
    var item = button.closest('.dokumen-sokongan-item');
    if (item) {
        item.remove();
    }
}

// Initialize document sections on page load
document.addEventListener('DOMContentLoaded', function () {
    var jenisPerolehan = document.getElementById('jenis_perolehan');
    var jenisPindaan = document.getElementById('jenis_pindaan_syarat');

    // Function to show document sections based on selection
    function showDokumenSection() {
        var jpValue = jenisPindaan ? jenisPindaan.value : '';
        var jprValue = jenisPerolehan ? jenisPerolehan.value : '';

        // Hide all document sections initially
        document.getElementById('dokumen-terpakai').style.display = 'none';
        document.getElementById('dokumen-bina-baru').style.display = 'none';
        document.getElementById('dokumen-bina-baru-luar-negara').style.display = 'none';
        document.getElementById('dokumen-pangkalan').style.display = 'none';
        document.getElementById('dokumen-bahan-binaan').style.display = 'none';
        document.getElementById('dokumen-tukar-peralatan').style.display = 'none';
        document.getElementById('dokumen-tukar-nama-syarikat').style.display = 'none';

        // Show the correct section based on selection
        if (jpValue === 'Jenis perolehan') {
            // Handle perolehan sub-sections
            if (jenisPerolehan && jenisPerolehan.value === 'bina_baru_dalam_negara') {
                document.getElementById('dokumen-bina-baru').style.display = 'block';
            } else if (jenisPerolehan && jenisPerolehan.value === 'bina_baru_luar_negara') {
                document.getElementById('dokumen-bina-baru-luar-negara').style.display = 'block';
            } else if (jenisPerolehan && (jenisPerolehan.value === 'terpakai_tempatan' || jenisPerolehan.value === 'terpakai_luar_negara')) {
                document.getElementById('dokumen-terpakai').style.display = 'block';
            }
        } else if (jpValue === 'Pangkalan') {
            document.getElementById('dokumen-pangkalan').style.display = 'block';
        } else if (jpValue === 'Jenis bahan binaan vesel') {
            document.getElementById('dokumen-bahan-binaan').style.display = 'block';
        } else if (jpValue === 'Tukar Jenis Peralatan') {
            document.getElementById('dokumen-tukar-peralatan').style.display = 'block';
        } else if (jpValue === 'Tukar Nama Pendaftaran Syarikat') {
            document.getElementById('dokumen-tukar-nama-syarikat').style.display = 'block';
        }
    }

    // Initially call the function to show the appropriate sections
    showDokumenSection();
});
</script>
@endpush 