<div class="mb-2" style="border-bottom: 3px solid #007bff; width: fit-content; margin-left:16px;">
    <span class="fw-bold" style="color:#007bff;">Senarai Dokumen Yang Perlu Dimuatnaik</span>
</div>

@if($selectedYear)
<div class="table-responsive" style="padding-left:16px; padding-right:16px;">
    <form id="dokumenForm" action="{{ route('semakan-stok.store-draft') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tahun" value="{{ request('tahun', $selectedYear ?? date('Y')) }}">
        <input type="hidden" name="fish_type_id" value="{{ \App\Models\FishType::first()->id ?? 1 }}">
        <input type="hidden" name="fma" value="FMA 1">
        <input type="hidden" name="bilangan_stok" value="1000">
        <table class="table table-bordered" style="background:#fff; border:1.5px solid #e3e6f0;">
            <thead class="table-light">
                <tr>
                    <th style="border:1.5px solid #e3e6f0; width:40px;">Bil</th>
                    <th style="border:1.5px solid #e3e6f0;">Nama Dokumen</th>
                    <th style="border:1.5px solid #e3e6f0;">Dokumen Dimuatnaik</th>
                    <th style="border:1.5px solid #e3e6f0; width:120px;">Pengesahan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border:1.5px solid #e3e6f0;">1</td>
                    <td style="border:1.5px solid #e3e6f0;">
                        <span>Surat Kelulusan KPP <span style="color:red;">*</span></span><br>
                        <a href="{{ route('semakan-stok.download-dokumen-kpp', ['tahun' => request('tahun', $selectedYear ?? date('Y'))]) }}" style="color:#0056d6; font-size:15px;"><i class="fas fa-download"></i> Muat Turun</a>
                    </td>
                    <td style="border:1.5px solid #e3e6f0;">
                        <input type="file" name="dokumen_kelulusan_kpp" id="dokumen_kelulusan_kpp" class="form-control" accept=".pdf,.jpg,.jpeg,.png" style="background:#f1f3f6; border:1px solid #ddd;">
                        <small class="text-muted">Format: PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                        <div id="filePreview" class="mt-2"></div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="setPengesahan('approved')" title="Lulus">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="setPengesahan('rejected')" title="Tidak Lulus">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="pengesahanStatus" class="mt-1"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

<!-- Success/Error Messages -->
<div id="messageContainer" class="mt-3"></div>

<!-- Navigation Buttons -->
<div class="d-flex justify-content-center align-items-center mt-4" style="padding-left:16px; padding-right:16px;">
    <div class="me-3">
        <button type="button" class="btn btn-outline-secondary" onclick="goBack()" style="background-color: white; color: #6c757d; border-color: #6c757d;">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
    </div>
    <div class="me-3">
        <button type="button" class="btn btn-outline-primary" onclick="saveData()" style="background-color: white; color: #007bff; border-color: #007bff;">
            <i class="fas fa-save"></i> Simpan
        </button>
    </div>
    <div>
        <button type="button" class="btn btn-primary" onclick="goNext()" style="background-color: #007bff; color: white; border-color: #007bff;">
            Seterusnya <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>
@else
<div class="text-center py-5" style="padding-left:16px; padding-right:16px;">
    <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
    <h5 class="text-muted">Sila Pilih Tahun</h5>
    <p class="text-muted">Pilih tahun untuk melihat dokumen permohonan</p>
</div>
@endif

<script>
// Generate unique storage key based on year and user
const currentYear = '{{ request("tahun", $selectedYear ?? date("Y")) }}';
const userId = '{{ auth()->id() }}';
const storageKey = `dokumen_permohonan_${userId}_${currentYear}`;

// Save form data to localStorage
function saveFormData() {
    const form = document.getElementById('dokumenForm');
    const formData = new FormData(form);
    const fileInput = document.getElementById('dokumen_kelulusan_kpp');
    
    const dataToSave = {
        tahun: formData.get('tahun'),
        fish_type_id: formData.get('fish_type_id'),
        fma: formData.get('fma'),
        bilangan_stok: formData.get('bilangan_stok'),
        fileName: fileInput.files.length > 0 ? fileInput.files[0].name : null,
        lastSaved: new Date().toISOString()
    };
    
    localStorage.setItem(storageKey, JSON.stringify(dataToSave));
    console.log('Form data saved to localStorage:', dataToSave);
}

// Load form data from localStorage
function loadFormData() {
    const savedData = localStorage.getItem(storageKey);
    if (savedData) {
        try {
            const data = JSON.parse(savedData);
            console.log('Loading saved form data:', data);
            
            // Show file preview if file was previously selected
            if (data.fileName) {
                showFilePreview(data.fileName);
            }
            
            // Load pengesahan status if exists
            if (data.pengesahan_status) {
                setPengesahan(data.pengesahan_status);
            }
            
            // Show notification that data was restored
            showRestoredDataNotification(data.lastSaved);
            
        } catch (error) {
            console.error('Error loading saved data:', error);
        }
    }
}

// Show file preview
function showFilePreview(fileName) {
    const previewDiv = document.getElementById('filePreview');
    previewDiv.innerHTML = `
        <div class="alert alert-info alert-sm">
            <i class="fas fa-file"></i> File dipilih: ${fileName}
            <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="clearFileSelection()">
                <i class="fas fa-times"></i> Batal
            </button>
        </div>
    `;
}

// Clear file selection
function clearFileSelection() {
    const fileInput = document.getElementById('dokumen_kelulusan_kpp');
    const previewDiv = document.getElementById('filePreview');
    
    fileInput.value = '';
    previewDiv.innerHTML = '';
    
    // Remove from localStorage
    const savedData = localStorage.getItem(storageKey);
    if (savedData) {
        const data = JSON.parse(savedData);
        delete data.fileName;
        localStorage.setItem(storageKey, JSON.stringify(data));
    }
}

// Show notification that data was restored
function showRestoredDataNotification(lastSaved) {
    const date = new Date(lastSaved);
    const formattedDate = date.toLocaleString('ms-MY');
    
    const messageContainer = document.getElementById('messageContainer');
    messageContainer.innerHTML = `
        <div class="alert alert-info alert-dismissible fade show">
            <i class="fas fa-info-circle"></i> Data anda telah dipulihkan dari penyimpanan terakhir (${formattedDate})
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
}

// Set pengesahan status
function setPengesahan(status) {
    const statusDiv = document.getElementById('pengesahanStatus');
    const buttons = document.querySelectorAll('.btn-group button');
    
    // Remove active state from all buttons
    buttons.forEach(btn => {
        btn.classList.remove('btn-success', 'btn-danger');
        btn.classList.add('btn-outline-success', 'btn-outline-danger');
    });
    
    // Set active state for selected button
    if (status === 'approved') {
        buttons[0].classList.remove('btn-outline-success');
        buttons[0].classList.add('btn-success');
        statusDiv.innerHTML = '<small class="text-success"><i class="fas fa-check"></i> Lulus</small>';
    } else if (status === 'rejected') {
        buttons[1].classList.remove('btn-outline-danger');
        buttons[1].classList.add('btn-danger');
        statusDiv.innerHTML = '<small class="text-danger"><i class="fas fa-times"></i> Tidak Lulus</small>';
    }
    
    // Save to localStorage
    const savedData = localStorage.getItem(storageKey);
    let data = savedData ? JSON.parse(savedData) : {};
    data.pengesahan_status = status;
    data.lastSaved = new Date().toISOString();
    localStorage.setItem(storageKey, JSON.stringify(data));
    
    console.log('Pengesahan status saved:', status);
}

// Auto-save form data when file is selected
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('dokumen_kelulusan_kpp');
    const form = document.getElementById('dokumenForm');
    
    // Prevent default form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Form submission prevented');
    });
    
    // Load saved data when page loads
    loadFormData();
    
    // Auto-save when file is selected
    fileInput.addEventListener('change', function() {
        saveFormData();
        
        // Show file preview
        if (this.files.length > 0) {
            showFilePreview(this.files[0].name);
        } else {
            document.getElementById('filePreview').innerHTML = '';
        }
    });
    
    // Auto-save before page unload
    window.addEventListener('beforeunload', function() {
        saveFormData();
    });
    
    // Auto-save when tab becomes hidden (user switches tabs)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            saveFormData();
        }
    });
});

function goBack() {
    // Save data before navigating
    saveFormData();
    
    // Navigate to senarai_status tab
    const currentYear = '{{ request("tahun", $selectedYear ?? date("Y")) }}';
    window.location.href = `?tab=senarai_status&tahun=${currentYear}`;
}

function saveData() {
    // Submit the form
    const form = document.getElementById('dokumenForm');
    const formData = new FormData(form);
    
    // Remove file fields if no actual file is selected
    const fileInput = document.getElementById('dokumen_kelulusan_kpp');
    if (fileInput.files.length === 0) {
        formData.delete('dokumen_kelulusan_kpp');
    }
    
    const senaraiStokInput = document.getElementById('dokumen_senarai_stok');
    if (senaraiStokInput && senaraiStokInput.files.length === 0) {
        formData.delete('dokumen_senarai_stok');
    }
    
    // Add pengesahan status if exists
    const savedData = localStorage.getItem(storageKey);
    if (savedData) {
        const data = JSON.parse(savedData);
        if (data.pengesahan_status) {
            formData.append('pengesahan_status', data.pengesahan_status);
        }
    }
    
    // Get CSRF token from meta tag or form
    let csrfToken = '';
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    if (metaToken) {
        csrfToken = metaToken.getAttribute('content');
    } else {
        const formToken = document.querySelector('input[name="_token"]');
        if (formToken) {
            csrfToken = formToken.value;
        }
    }
    
    console.log('CSRF Token:', csrfToken);
    console.log('Form data being sent:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    
    fetch(form.action, {
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
        console.log('Response headers:', response.headers);
        
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
            // Clear localStorage after successful save
            localStorage.removeItem(storageKey);
            
            alert('Berjaya! ' + data.message);
        } else {
            alert('Ralat! ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ralat semasa menyimpan data: ' + error.message);
    });
}

function goNext() {
    // Auto-save data to database before navigating
    const form = document.getElementById('dokumenForm');
    const formData = new FormData(form);
    
    // Remove file fields if no actual file is selected
    const fileInput = document.getElementById('dokumen_kelulusan_kpp');
    if (fileInput.files.length === 0) {
        formData.delete('dokumen_kelulusan_kpp');
    }
    
    const senaraiStokInput = document.getElementById('dokumen_senarai_stok');
    if (senaraiStokInput && senaraiStokInput.files.length === 0) {
        formData.delete('dokumen_senarai_stok');
    }
    
    // Add pengesahan status if exists
    const savedData = localStorage.getItem(storageKey);
    if (savedData) {
        const data = JSON.parse(savedData);
        if (data.pengesahan_status) {
            formData.append('pengesahan_status', data.pengesahan_status);
        }
    }
    
    // Show loading message
    const seterusnyaButton = document.querySelector('button[onclick="goNext()"]');
    const originalText = seterusnyaButton.innerHTML;
    seterusnyaButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    seterusnyaButton.disabled = true;
    
    // Get CSRF token from meta tag or form
    let csrfToken = '';
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    if (metaToken) {
        csrfToken = metaToken.getAttribute('content');
    } else {
        const formToken = document.querySelector('input[name="_token"]');
        if (formToken) {
            csrfToken = formToken.value;
        }
    }
    
    console.log('CSRF Token:', csrfToken);
    console.log('Form data being sent:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    
    // Save to database first
    fetch(form.action, {
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
        console.log('Response headers:', response.headers);
        
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
            // Clear localStorage after successful save
            localStorage.removeItem(storageKey);
            
            // Navigate to tindakan tab
            const currentYear = '{{ request("tahun", $selectedYear ?? date("Y")) }}';
            window.location.href = `?tab=tindakan&tahun=${currentYear}`;
        } else {
            alert('Ralat! ' + data.message);
            // Restore button state
            seterusnyaButton.innerHTML = originalText;
            seterusnyaButton.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ralat semasa menyimpan data: ' + error.message);
        // Restore button state
        seterusnyaButton.innerHTML = originalText;
        seterusnyaButton.disabled = false;
    });
}
</script> 