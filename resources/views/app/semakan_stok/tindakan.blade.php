<div class="mb-2" style="border-bottom: 3px solid #007bff; width: fit-content; margin-left:16px;">
    <span class="fw-bold" style="color:#007bff;">Semakan Perakuan</span>
</div>

@if($selectedYear)
<div class="mb-3">
    <div style="padding-left:16px; padding-right:16px;">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Semakan Selesai!</strong><br>
            Sila tandakan "Disemak" dan klik "Hantar" untuk melengkapkan proses semakan.
        </div>
        <div class="mb-3">
            <label class="fw-bold mb-2">Status Semakan:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="semakan_disemak" onchange="toggleHantarButton()">
                <label class="form-check-label" for="semakan_disemak">
                    Disemak
                </label>
            </div>
            <small class="text-muted">Tandakan kotak ini untuk mengesahkan bahawa semakan telah selesai.</small>
        </div>
    </div>
</div>

<!-- Navigation Buttons -->
<div class="d-flex justify-content-center align-items-center mt-4" style="padding-left:16px; padding-right:16px;">
    <div class="me-3">
        <button type="button" class="btn btn-outline-secondary" onclick="goBack()" style="background-color: white; color: #6c757d; border-color: #6c757d;">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
    </div>
    <div>
        <button type="button" class="btn btn-primary" id="hantarButton" onclick="hantarSemakan()" style="background-color: #007bff; color: white; border-color: #007bff;" disabled>
            <i class="fas fa-paper-plane"></i> Hantar
        </button>
    </div>
</div>
@else
<div class="text-center py-5" style="padding-left:16px; padding-right:16px;">
    <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
    <h5 class="text-muted">Sila Pilih Tahun</h5>
    <p class="text-muted">Pilih tahun untuk membuat tindakan keputusan</p>
</div>
@endif

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
                <h5 class="text-success mb-3">Semakan Status Berjaya Dihantar!</h5>
                <p class="text-muted">
                    Status semakan telah dikemaskini dalam pangkalan data untuk tahun <span id="successYear"></span>.
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
function goBack() {
    // Navigate to dokumen_permohonan tab
    const currentYear = '{{ request("tahun", $selectedYear ?? date("Y")) }}';
    window.location.href = `?tab=dokumen_permohonan&tahun=${currentYear}`;
}

function toggleHantarButton() {
    const disemakCheckbox = document.getElementById('semakan_disemak');
    const hantarButton = document.getElementById('hantarButton');
    
    if (disemakCheckbox.checked) {
        hantarButton.disabled = false;
        hantarButton.style.opacity = '1';
    } else {
        hantarButton.disabled = true;
        hantarButton.style.opacity = '0.6';
    }
}

function hantarSemakan() {
    const disemakCheckbox = document.getElementById('semakan_disemak');
    
    if (!disemakCheckbox.checked) {
        alert('Sila tandakan "Disemak" terlebih dahulu sebelum menghantar.');
        return;
    }
    
    // Show loading state
    const hantarButton = document.getElementById('hantarButton');
    const originalText = hantarButton.innerHTML;
    hantarButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghantar...';
    hantarButton.disabled = true;
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Send AJAX request to update semakan_status
    fetch('{{ route("semakan-stok.update-semakan-status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            tahun: '{{ request("tahun", $selectedYear ?? date("Y")) }}',
            semakan_status: 'disemak'
        })
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 419) {
                throw new Error('CSRF token mismatch. Please refresh the page and try again.');
            } else {
                throw new Error('Network response was not ok: ' + response.status);
            }
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success modal
            document.getElementById('successYear').textContent = '{{ request("tahun", $selectedYear ?? date("Y")) }}';
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
        hantarButton.innerHTML = originalText;
        hantarButton.disabled = false;
    });
}

// Initialize button state on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleHantarButton();
});
</script> 