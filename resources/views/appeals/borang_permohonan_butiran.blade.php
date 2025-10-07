@extends('layouts.app')

@section('styles')
<style>
    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
    
    .validation-error {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .form-control.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
</style>
@endsection

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container">
            <div class="card border-0 shadow-lg rounded-4 mt-5">
                <div class="card-header text-white fw-semibold rounded-top" style="background-color: #3C2387;">
                    Permohonan
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="POST" action="{{ route('appeals.savePerakuan') }}" enctype="multipart/form-data" id="butiran-form">
                        @csrf
                        <!-- Bootstrap Tab Navigation -->
                        <ul class="nav nav-tabs mb-4" id="permohonanTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="butiran-tab" data-bs-toggle="tab" data-bs-target="#butiran" type="button" role="tab" aria-controls="butiran" aria-selected="true">Butiran Permohonan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab" aria-controls="dokumen" aria-selected="false">Dokumen Permohonan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="perakuan-tab" data-bs-toggle="tab" data-bs-target="#perakuan" type="button" role="tab" aria-controls="perakuan" aria-selected="false">Perakuan</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="permohonanTabContent">
                            <div class="tab-pane fade show active" id="butiran" role="tabpanel" aria-labelledby="butiran-tab">
                                @include('appeals.partials.butiran_permohon', [
                                    'jenisPindaanOptions' => $jenisPindaanOptions,
                                    'jenisBahanBinaanOptions' => $jenisBahanBinaanOptions,
                                    'jenisPerolehanOptions' => $jenisPerolehanOptions
                                ])
                            </div>

                            <div class="tab-pane fade" id="dokumen" role="tabpanel" aria-labelledby="dokumen-tab">
                                @include('appeals.partials.dokumen_pemohon')
                            </div>

                            <div class="tab-pane fade" id="perakuan" role="tabpanel" aria-labelledby="perakuan-tab">
                                @include('appeals.partials.perakuan')
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-sm" style="background-color: #28a745; color: #fff; border: 1px solid #28a745; border-radius: 8px;" id="hantar-btn" disabled>
                                        <i class="fas fa-paper-plane me-2" style="color: #fff;"></i>Hantar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('butiran-form');
    var nextPerakuan = document.getElementById('hantar-btn');

    function checkPerakuanForm() {
        var perakuanCheckBox = document.getElementById('perakuan_checkbox');
        nextPerakuan.disabled = !perakuanCheckBox.checked;
    }

    // Listen for perakuan checkbox changes
    const perakuanCheckBox = document.getElementById('perakuan_checkbox');
    if (perakuanCheckBox) {
        perakuanCheckBox.addEventListener('change', checkPerakuanForm);
    }

    // Control document section visibility based on amendment type
    const jenisPindaanSelect = document.getElementById('jenis_pindaan_syarat');
    if (jenisPindaanSelect) {
        jenisPindaanSelect.addEventListener('change', function() {
            updateDocumentSectionVisibility(this.value);
        });
        
        // Initial call to set correct visibility
        updateDocumentSectionVisibility(this.value);
    }

    // Control document section visibility based on perolehan type
    const jenisPerolehanSelect = document.getElementById('jenis_perolehan');
    if (jenisPerolehanSelect) {
        jenisPerolehanSelect.addEventListener('change', function() {
            updatePerolehanDocumentSection(this.value);
        });
    }

    // Initial check
    checkPerakuanForm();

    // Handle kelulusan perolehan selection
    const kelulusanSelect = document.getElementById('kelulusan_perolehan_id');
    if (kelulusanSelect) {
        kelulusanSelect.addEventListener('change', function() {
            loadPermits(this.value);
        });
    }
    
    // Add real-time validation for required fields
    const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
    
    // Add real-time validation for required file inputs
    const requiredFileInputs = document.querySelectorAll('input[type="file"][required]');
    requiredFileInputs.forEach(fileInput => {
        fileInput.addEventListener('change', function() {
            validateFileField(this);
        });
    });
    
    // Add real-time validation for form fields that affect dokumen sokongan requirements
    const dokumenSokonganFields = [
        'pangkalan_asal', 'pangkalan_baru', 'justifikasi_pindaan',
        'jenis_bahan_binaan_vesel', 'nyatakan',
        'no_permit_peralatan', 'jenis_peralatan_asal', 'jenis_peralatan_baru', 'justifikasi_tukar_peralatan'
    ];
    
    // Add real-time validation for Jenis Perolehan fields
    const jenisPerolehanFields = [
        'nama_limbungan_baru', 'negeri_limbungan_baru', 'daerah_baru', 'alamat_baru', 'poskod_baru',
        'alamat_limbungan_luar_negara', 'negara_limbungan',
        'pernah_berdaftar', 'no_pendaftaran_vesel', 'negeri_asal_vesel', 'pelabuhan_pangkalan',
        'justifikasi_perolehan'
    ];
    
    dokumenSokonganFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                updateDokumenSokonganRequirements();
            });
            
            field.addEventListener('blur', function() {
                updateDokumenSokonganRequirements();
            });
        }
    });
    
    // Add event listeners for Jenis Perolehan fields
    jenisPerolehanFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                validateJenisPerolehanField(this);
            });
            
            field.addEventListener('blur', function() {
                validateJenisPerolehanField(this);
            });
        }
    });
    
    // Special handling for radio buttons
    const pernahBerdaftarRadios = document.querySelectorAll('input[name="pernah_berdaftar"]');
    pernahBerdaftarRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            validateJenisPerolehanField(this);
        });
    });
});

// Function to update document section visibility
function updateDocumentSectionVisibility(amendmentType) {
    // Hide all document sections first
    const documentSections = [
        'dokumen-terpakai',
        'dokumen-bina-baru', 
        'dokumen-pangkalan',
        'dokumen-bahan-binaan',
        'dokumen-tukar-peralatan',
        'dokumen-tukar-nama-syarikat'
    ];
    
    documentSections.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'none';
        }
    });

    // Show the appropriate section based on amendment type
    switch(amendmentType) {
        case 'Jenis bahan binaan vesel':
            showSection('dokumen-bahan-binaan');
            break;
        case 'Jenis perolehan':
            // This will be handled by the perolehan type selection
            // Check if there's a current selection and show appropriate section
            const jenisPerolehan = document.getElementById('jenis_perolehan');
            if (jenisPerolehan && jenisPerolehan.value) {
                updatePerolehanDocumentSection(jenisPerolehan.value);
            }
            break;
        case 'Pangkalan':
            showSection('dokumen-pangkalan');
            break;
        case 'Tukar Jenis Peralatan':
            showSection('dokumen-tukar-peralatan');
            break;
        case 'Tukar Nama Pendaftaran Syarikat':
            showSection('dokumen-tukar-nama-syarikat');
            break;
    }
}

// Function to show a specific document section
function showSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.style.display = 'block';
    }
}

// Function to update perolehan document sections
function updatePerolehanDocumentSection(perolehanType) {
    // Hide all perolehan-related document sections
    const perolehanSections = [
        'dokumen-terpakai',
        'dokumen-bina-baru',
        'dokumen-bina-baru-luar-negara'
    ];
    
    perolehanSections.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'none';
        }
    });

    // Show the appropriate section based on perolehan type
    switch(perolehanType) {
        case 'bina_baru_dalam_negara':
            showSection('dokumen-bina-baru');
            break;
        case 'bina_baru_luar_negara':
            showSection('dokumen-bina-baru-luar-negara');
            break;
        case 'terpakai_tempatan':
        case 'terpakai_luar_negara':
            showSection('dokumen-terpakai');
            break;
    }
}

// Tab Navigation Functions
function nextTab(tabId) {
    console.log('nextTab called with:', tabId);
    
    // Validate current tab before proceeding
    if (!validateCurrentTab()) {
        console.log('Validation failed, not proceeding to next tab');
        return false;
    }
    
    console.log('Validation passed, proceeding to next tab');
    
    // Find the tab button and click it
    const tabButton = document.querySelector(`#${tabId}`);
    if (tabButton) {
        const tab = new bootstrap.Tab(tabButton);
        tab.show();
    }
}

// Function to validate current tab
function validateCurrentTab() {
    const activeTab = document.querySelector('.tab-pane.active');
    if (!activeTab) return true;
    
    const tabId = activeTab.id;
    console.log('Validating tab:', tabId);
    
    let isValid = true;
    let errorMessage = '';
    
    // Validate Butiran Permohonan tab
    if (tabId === 'butiran') {
        const requiredFields = activeTab.querySelectorAll('input[required], select[required], textarea[required]');
        const emptyFields = [];
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                emptyFields.push(field.name || field.id || 'Field');
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Special validation for Jenis Perolehan section
        const jenisPerolehan = document.getElementById('jenis_perolehan');
        if (jenisPerolehan && jenisPerolehan.value) {
            const missingPerolehanFields = validateJenisPerolehanFields(jenisPerolehan.value);
            if (missingPerolehanFields.length > 0) {
                emptyFields.push(...missingPerolehanFields);
            }
        }
        
        if (emptyFields.length > 0) {
            isValid = false;
            errorMessage = 'Sila isikan semua medan yang wajib: ' + emptyFields.join(', ');
        }
    }
    
    // Validate Dokumen Permohonan tab
    if (tabId === 'dokumen') {
        const visibleSection = activeTab.querySelector('[style*="display: block"]');
        if (visibleSection) {
            // First, check if form fields are filled for dokumen sokongan
            const missingFormFields = [];
            const missingFiles = [];
            
            // Check pangkalan fields if pangkalan section is visible
            if (visibleSection.id === 'dokumen-pangkalan') {
                const pangkalanAsal = document.getElementById('pangkalan_asal');
                const pangkalanBaru = document.getElementById('pangkalan_baru');
                const justifikasiPindaan = document.getElementById('justifikasi_pindaan');
                
                if (!pangkalanAsal || !pangkalanAsal.value.trim()) {
                    missingFormFields.push('Pangkalan Asal');
                }
                if (!pangkalanBaru || !pangkalanBaru.value.trim()) {
                    missingFormFields.push('Pangkalan Baru');
                }
                if (!justifikasiPindaan || !justifikasiPindaan.value.trim()) {
                    missingFormFields.push('Justifikasi Rayuan');
                }
            }
            
            // Check bahan binaan fields if bahan binaan section is visible
            if (visibleSection.id === 'dokumen-bahan-binaan') {
                const jenisBahanBinaan = document.getElementById('jenis_bahan_binaan_vesel');
                const nyatakan = document.getElementById('nyatakan');
                
                if (!jenisBahanBinaan || !jenisBahanBinaan.value.trim()) {
                    missingFormFields.push('Jenis Bahan Binaan Vesel');
                }
                if (!nyatakan || !nyatakan.value.trim()) {
                    missingFormFields.push('Justifikasi Rayuan');
                }
            }
            
            // Check tukar peralatan fields if tukar peralatan section is visible
            if (visibleSection.id === 'dokumen-tukar-peralatan') {
                const noPermitPeralatan = document.getElementById('no_permit_peralatan');
                const jenisPeralatanAsal = document.getElementById('jenis_peralatan_asal');
                const jenisPeralatanBaru = document.getElementById('jenis_peralatan_baru');
                const justifikasiTukarPeralatan = document.getElementById('justifikasi_tukar_peralatan');
                
                if (!noPermitPeralatan || !noPermitPeralatan.value.trim()) {
                    missingFormFields.push('No. Permit Peralatan');
                }
                if (!jenisPeralatanAsal || !jenisPeralatanAsal.value.trim()) {
                    missingFormFields.push('Jenis Peralatan Asal');
                }
                if (!jenisPeralatanBaru || !jenisPeralatanBaru.value.trim()) {
                    missingFormFields.push('Jenis Peralatan Baru');
                }
                if (!justifikasiTukarPeralatan || !justifikasiTukarPeralatan.value.trim()) {
                    missingFormFields.push('Justifikasi Tukar Peralatan');
                }
            }
            
            // If form fields are missing, show error
            if (missingFormFields.length > 0) {
                isValid = false;
                errorMessage = 'Sila isi maklumat yang berkaitan terlebih dahulu: ' + missingFormFields.join(', ');
                console.log('Missing form fields:', missingFormFields);
            } else {
                // If form fields are filled, check dokumen sokongan files
                const requiredFiles = visibleSection.querySelectorAll('input[type="file"][required]');
                console.log('Required files found:', requiredFiles.length);
                
                requiredFiles.forEach(fileInput => {
                    if (!fileInput.files || fileInput.files.length === 0) {
                        const displayName = getDokumenSokonganDisplayName(fileInput.name);
                        missingFiles.push(displayName);
                        fileInput.classList.add('is-invalid');
                        console.log('Missing file:', fileInput.name, 'Display name:', displayName);
                    } else {
                        fileInput.classList.remove('is-invalid');
                        console.log('File uploaded:', fileInput.name);
                    }
                });
                
                if (missingFiles.length > 0) {
                    isValid = false;
                    errorMessage = 'Sila upload dokumen sokongan: ' + missingFiles.join(', ');
                    console.log('Missing files:', missingFiles);
                }
            }
        }
    }
    
    // Show error message if validation fails
    if (!isValid) {
        // Remove existing error messages
        const existingErrors = document.querySelectorAll('.validation-error');
        existingErrors.forEach(error => error.remove());
        
        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger validation-error mt-3';
        errorDiv.textContent = errorMessage;
        activeTab.appendChild(errorDiv);
        
        // Auto-remove error message after 5 seconds
        setTimeout(() => {
            if (errorDiv.parentNode) {
                errorDiv.remove();
            }
        }, 5000);
        
        return false;
    }
    
    return true;
}

// Function to validate individual field
function validateField(field) {
    if (!field.value.trim()) {
        field.classList.add('is-invalid');
        return false;
    } else {
        field.classList.remove('is-invalid');
        return true;
    }
}

// Function to validate file field
function validateFileField(fileInput) {
    // Check if dokumen sokongan is required based on form fields
    if (isDokumenSokonganRequired(fileInput.name)) {
        if (!fileInput.files || fileInput.files.length === 0) {
            fileInput.classList.add('is-invalid');
            return false;
        } else {
            fileInput.classList.remove('is-invalid');
            return true;
        }
    } else {
        // Remove required attribute if form fields not filled
        fileInput.removeAttribute('required');
        fileInput.classList.remove('is-invalid');
        return true;
    }
}

// Function to check if dokumen sokongan is required based on form fields
function isDokumenSokonganRequired(fileInputName) {
    switch (fileInputName) {
        case 'dokumen_sokongan_pangkalan[]':
            // Check if pangkalan fields are filled
            const pangkalanAsal = document.getElementById('pangkalan_asal');
            const pangkalanBaru = document.getElementById('pangkalan_baru');
            const justifikasiPindaan = document.getElementById('justifikasi_pindaan');
            return pangkalanAsal && pangkalanAsal.value.trim() && 
                   pangkalanBaru && pangkalanBaru.value.trim() && 
                   justifikasiPindaan && justifikasiPindaan.value.trim();
            
        case 'dokumen_sokongan_bahan_binaan[]':
            // Check if bahan binaan fields are filled
            const jenisBahanBinaan = document.getElementById('jenis_bahan_binaan_vesel');
            const nyatakan = document.getElementById('nyatakan');
            return jenisBahanBinaan && jenisBahanBinaan.value.trim() && 
                   nyatakan && nyatakan.value.trim();
            
        case 'dokumen_sokongan_tukar_peralatan[]':
            // Check if tukar peralatan fields are filled
            const noPermitPeralatan = document.getElementById('no_permit_peralatan');
            const jenisPeralatanAsal = document.getElementById('jenis_peralatan_asal');
            const jenisPeralatanBaru = document.getElementById('jenis_peralatan_baru');
            const justifikasiTukarPeralatan = document.getElementById('justifikasi_tukar_peralatan');
            return noPermitPeralatan && noPermitPeralatan.value.trim() && 
                   jenisPeralatanAsal && jenisPeralatanAsal.value.trim() && 
                   jenisPeralatanBaru && jenisPeralatanBaru.value.trim() && 
                   justifikasiTukarPeralatan && justifikasiTukarPeralatan.value.trim();
            
        default:
            return true; // Other files are always required if marked as required
    }
}

// Function to get display name for dokumen sokongan
function getDokumenSokonganDisplayName(fileInputName) {
    switch (fileInputName) {
        // Single file inputs
        case 'kertas_kerja_bina_baru':
            return 'Kertas Kerja';
        case 'kertas_kerja_bina_baru_luar_negara':
            return 'Kertas Kerja';
        case 'surat_jual_beli_terpakai':
            return 'Surat Jual Beli Vesel Terpakai';
        case 'lesen_skl_terpakai':
            return 'Salinan Lesen SKL';
        case 'lesen_skl_bina_baru':
            return 'Salinan Lesen SKL';
        case 'borang_e_kaedah_13':
            return 'Borang E - Kaedah 13';
        case 'profil_perniagaan_enterprise':
            return 'Salinan Profil Perniagaan';
        case 'form_9':
            return 'Form 9';
        case 'form_24':
            return 'Form 24';
        case 'form_44':
            return 'Form 44';
        case 'form_49':
            return 'Form 49';
        case 'pendaftaran_persatuan':
            return 'Pendaftaran Persatuan';
        case 'profil_persatuan':
            return 'Profil Persatuan';
        case 'pendaftaran_koperasi':
            return 'Pendaftaran Koperasi';
        case 'profil_koperasi':
            return 'Profil Koperasi';
            
        // Array file inputs (dokumen sokongan)
        case 'dokumen_sokongan_pangkalan[]':
            return 'Dokumen Sokongan Pangkalan';
        case 'dokumen_sokongan_bahan_binaan[]':
            return 'Dokumen Sokongan Bahan Binaan';
        case 'dokumen_sokongan_tukar_peralatan[]':
            return 'Dokumen Sokongan Tukar Peralatan';
        case 'dokumen_sokongan_terpakai[]':
            return 'Dokumen Sokongan Vesel Terpakai';
        case 'dokumen_sokongan_bina_baru[]':
            return 'Dokumen Sokongan Bina Baru';
        case 'dokumen_sokongan_bina_baru_luar_negara[]':
            return 'Dokumen Sokongan Bina Baru Luar Negara';
            
        default:
            // Convert field name to readable format
            return fileInputName
                .replace(/_/g, ' ')
                .replace(/\b\w/g, l => l.toUpperCase())
                .replace(/\[]/g, '');
    }
}

// Function to validate Jenis Perolehan fields based on selected type
function validateJenisPerolehanFields(jenisPerolehanValue) {
    const missingFields = [];
    
    switch (jenisPerolehanValue) {
        case 'bina_baru_dalam_negara':
            // Check Vesel Bina Baru Dalam Negara fields
            const namaLimbunganBaru = document.getElementById('nama_limbungan_baru');
            const negeriLimbunganBaru = document.getElementById('negeri_limbungan_baru');
            const daerahBaru = document.getElementById('daerah_baru');
            const alamatBaru = document.getElementById('alamat_baru');
            const poskodBaru = document.getElementById('poskod_baru');
            const justifikasiPerolehan = document.getElementById('justifikasi_perolehan');
            
            if (!namaLimbunganBaru || !namaLimbunganBaru.value.trim()) {
                missingFields.push('Nama Limbungan');
                namaLimbunganBaru?.classList.add('is-invalid');
            } else {
                namaLimbunganBaru.classList.remove('is-invalid');
            }
            
            if (!negeriLimbunganBaru || !negeriLimbunganBaru.value.trim()) {
                missingFields.push('Negeri Limbungan');
                negeriLimbunganBaru?.classList.add('is-invalid');
            } else {
                negeriLimbunganBaru.classList.remove('is-invalid');
            }
            
            if (!daerahBaru || !daerahBaru.value.trim()) {
                missingFields.push('Daerah');
                daerahBaru?.classList.add('is-invalid');
            } else {
                daerahBaru.classList.remove('is-invalid');
            }
            
            if (!alamatBaru || !alamatBaru.value.trim()) {
                missingFields.push('Alamat Limbungan');
                alamatBaru?.classList.add('is-invalid');
            } else {
                alamatBaru.classList.remove('is-invalid');
            }
            
            if (!poskodBaru || !poskodBaru.value.trim()) {
                missingFields.push('Poskod');
                poskodBaru?.classList.add('is-invalid');
            } else {
                poskodBaru.classList.remove('is-invalid');
            }
            
            if (!justifikasiPerolehan || !justifikasiPerolehan.value.trim()) {
                missingFields.push('Justifikasi Rayuan');
                justifikasiPerolehan?.classList.add('is-invalid');
            } else {
                justifikasiPerolehan.classList.remove('is-invalid');
            }
            break;
            
        case 'bina_baru_luar_negara':
            // Check Vesel Bina Baru Luar Negara fields
            const alamatLimbunganLuarNegara = document.getElementById('alamat_limbungan_luar_negara');
            const negaraLimbungan = document.getElementById('negara_limbungan');
            const justifikasiPerolehan2 = document.getElementById('justifikasi_perolehan');
            
            if (!alamatLimbunganLuarNegara || !alamatLimbunganLuarNegara.value.trim()) {
                missingFields.push('Alamat Limbungan');
                alamatLimbunganLuarNegara?.classList.add('is-invalid');
            } else {
                alamatLimbunganLuarNegara.classList.remove('is-invalid');
            }
            
            if (!negaraLimbungan || !negaraLimbungan.value.trim()) {
                missingFields.push('Negara');
                negaraLimbungan?.classList.add('is-invalid');
            } else {
                negaraLimbungan.classList.remove('is-invalid');
            }
            
            if (!justifikasiPerolehan2 || !justifikasiPerolehan2.value.trim()) {
                missingFields.push('Justifikasi Rayuan');
                justifikasiPerolehan2?.classList.add('is-invalid');
            } else {
                justifikasiPerolehan2.classList.remove('is-invalid');
            }
            break;
            
        case 'terpakai_tempatan':
        case 'terpakai_luar_negara':
            // Check Vesel Terpakai fields
            const pernahBerdaftar = document.querySelector('input[name="pernah_berdaftar"]:checked');
            const noPendaftaranVesel = document.getElementById('no_pendaftaran_vesel');
            const negeriAsalVesel = document.getElementById('negeri_asal_vesel');
            const pelabuhanPangkalan = document.getElementById('pelabuhan_pangkalan');
            const justifikasiPerolehan3 = document.getElementById('justifikasi_perolehan');
            
            if (!pernahBerdaftar) {
                missingFields.push('Vesel Pernah Berdaftar');
                // Add visual indicator for radio buttons
                const radioButtons = document.querySelectorAll('input[name="pernah_berdaftar"]');
                radioButtons.forEach(radio => radio.classList.add('is-invalid'));
            } else {
                const radioButtons = document.querySelectorAll('input[name="pernah_berdaftar"]');
                radioButtons.forEach(radio => radio.classList.remove('is-invalid'));
            }
            
            if (!noPendaftaranVesel || !noPendaftaranVesel.value.trim()) {
                missingFields.push('No. Pendaftaran Vesel');
                noPendaftaranVesel?.classList.add('is-invalid');
            } else {
                noPendaftaranVesel.classList.remove('is-invalid');
            }
            
            if (!negeriAsalVesel || !negeriAsalVesel.value.trim()) {
                missingFields.push('Negeri Asal Vesel');
                negeriAsalVesel?.classList.add('is-invalid');
            } else {
                negeriAsalVesel.classList.remove('is-invalid');
            }
            
            if (!pelabuhanPangkalan || !pelabuhanPangkalan.value.trim()) {
                missingFields.push('Pelabuhan/Pangkalan');
                pelabuhanPangkalan?.classList.add('is-invalid');
            } else {
                pelabuhanPangkalan.classList.remove('is-invalid');
            }
            
            if (!justifikasiPerolehan3 || !justifikasiPerolehan3.value.trim()) {
                missingFields.push('Justifikasi Rayuan');
                justifikasiPerolehan3?.classList.add('is-invalid');
            } else {
                justifikasiPerolehan3.classList.remove('is-invalid');
            }
            break;
    }
    
    return missingFields;
}

// Function to validate individual Jenis Perolehan field
function validateJenisPerolehanField(field) {
    const jenisPerolehan = document.getElementById('jenis_perolehan');
    if (!jenisPerolehan || !jenisPerolehan.value) return;
    
    // Validate the specific field based on current jenis perolehan selection
    const missingFields = validateJenisPerolehanFields(jenisPerolehan.value);
    
    // Remove validation error if field is now valid
    if (!missingFields.includes(field.name || field.id)) {
        field.classList.remove('is-invalid');
    }
}

// Function to update dokumen sokongan requirements based on form fields
function updateDokumenSokonganRequirements() {
    const dokumenSokonganInputs = [
        'dokumen_sokongan_pangkalan[]',
        'dokumen_sokongan_bahan_binaan[]',
        'dokumen_sokongan_tukar_peralatan[]'
    ];
    
    dokumenSokonganInputs.forEach(inputName => {
        const inputs = document.querySelectorAll(`input[name="${inputName}"]`);
        inputs.forEach(input => {
            if (isDokumenSokonganRequired(inputName)) {
                input.setAttribute('required', 'required');
                // Add visual indicator that it's now required
                const container = input.closest('.dokumen-sokongan-item');
                if (container) {
                    const label = container.querySelector('.form-text');
                    if (label && !label.textContent.includes('*')) {
                        label.innerHTML += ' <span class="text-danger">*</span>';
                    }
                }
            } else {
                input.removeAttribute('required');
                input.classList.remove('is-invalid');
                // Remove visual indicator
                const container = input.closest('.dokumen-sokongan-item');
                if (container) {
                    const label = container.querySelector('.form-text');
                    if (label) {
                        label.innerHTML = label.innerHTML.replace(' <span class="text-danger">*</span>', '');
                    }
                }
            }
        });
    });
}

function previousTab(tabId) {
    // Find the tab button and click it
    const tabButton = document.querySelector(`#${tabId}`);
    if (tabButton) {
        const tab = new bootstrap.Tab(tabButton);
        tab.show();
    }
}

// Function to add new dokumen sokongan field
function addDokumenSokongan(containerId, fieldName) {
    const container = document.getElementById(containerId);
    if (!container) {
        console.error('Container not found:', containerId);
        return;
    }
    
    const newItem = document.createElement('div');
    newItem.className = 'dokumen-sokongan-item mb-2';
    newItem.innerHTML = `
        <div class="input-group">
            <input type="file" class="form-control dokumen-sokongan-input" name="${fieldName}" accept=".pdf,.png,.jpg,.jpeg">
            <button type="button" class="btn btn-remove-dokumen" style="background-color: #dc3545; color: #fff; border: 1px solid #dc3545;" onclick="removeDokumenSokongan(this)" title="Padam">
                <i class="fas fa-trash-alt" style="color: #fff;"></i>
            </button>
        </div>
        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 10MB.</small>
    `;
    container.appendChild(newItem);
}

// Function to remove dokumen sokongan field
function removeDokumenSokongan(button) {
    const item = button.closest('.dokumen-sokongan-item');
    if (item) {
        item.remove();
    }
}

// Function to update requirements summary (placeholder - can be customized as needed)
function updateRequirementsSummary(amendmentType, perolehanType) {
    // This function can be used to show/hide requirement information
    // For now, it's a placeholder to prevent errors
    console.log('Requirements updated:', { amendmentType, perolehanType });
}

// Function to load permits for selected kelulusan perolehan
function loadPermits(kelulusanId) {
    if (!kelulusanId) {
        document.getElementById('permit-selection-section').style.display = 'none';
        return;
    }

    // Show the permit selection section
    document.getElementById('permit-selection-section').style.display = 'block';

    // Fetch permits via AJAX
    console.log('Fetching permits for kelulusan ID:', kelulusanId);
    fetch(`{{ url('/appeals/get-permits') }}/${kelulusanId}`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const permitCheckboxes = document.getElementById('permit-checkboxes');
            permitCheckboxes.innerHTML = '';

            if (data.permits && data.permits.length > 0) {
                data.permits.forEach(permit => {
                    const permitDiv = document.createElement('div');
                    permitDiv.className = 'form-check mb-2';
                    permitDiv.innerHTML = `
                        <input class="form-check-input" type="checkbox" name="selected_permits[]" 
                               value="${permit.id}" id="permit_${permit.id}">
                        <label class="form-check-label" for="permit_${permit.id}">
                            <strong>${permit.no_permit}</strong> - ${permit.jenis_peralatan} 
                            <span class="badge bg-${permit.status === 'ada_kemajuan' ? 'success' : 'warning'}">
                                ${permit.status === 'ada_kemajuan' ? 'Ada kemajuan' : 'Tiada kemajuan'}
                            </span>
                        </label>
                    `;
                    permitCheckboxes.appendChild(permitDiv);
                });
            } else {
                permitCheckboxes.innerHTML = '<p class="text-muted">Tiada permit dijumpai untuk kelulusan ini.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading permits:', error);
            document.getElementById('permit-checkboxes').innerHTML = '<p class="text-danger">Ralat memuatkan permit.</p>';
        });
}
</script>
@endsection
