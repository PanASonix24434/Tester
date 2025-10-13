<!-- Reusable Modal Component -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                <h5 class="modal-title fw-bold" id="modalTitle" style="color: #1a1a1a;">
                    <!-- Dynamic title will be inserted here -->
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="d-flex align-items-center">
                    <div class="me-3" id="modalIcon">
                        <!-- Dynamic icon will be inserted here -->
                    </div>
                    <p class="mb-0" id="modalMessage" style="color: #1a1a1a; font-size: 16px;">
                        <!-- Dynamic message will be inserted here -->
                    </p>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" id="modalCancelBtn" data-bs-dismiss="modal" style="border-radius: 8px;">
                    <!-- Dynamic cancel button text will be inserted here -->
                </button>
                <button type="button" class="btn" id="modalConfirmBtn" style="border-radius: 8px;">
                    <!-- Dynamic confirm button text will be inserted here -->
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Modal configuration for different types
const modalConfigs = {
    simpan: {
        title: 'Simpan Perubahan',
        message: 'Adakah anda pasti untuk simpan perubahan ini?',
        icon: '<i class="fas fa-save text-primary" style="font-size: 24px;"></i>',
        cancelBtn: 'Batal',
        confirmBtn: 'Simpan',
        confirmBtnClass: 'btn-primary',
        confirmBtnIcon: '<i class="fas fa-save me-2"></i>'
    },
    hantar: {
        title: 'Hantar Maklumat',
        message: 'Adakah anda pasti untuk hantar maklumat ini?',
        icon: '<i class="fas fa-paper-plane text-success" style="font-size: 24px;"></i>',
        cancelBtn: 'Batal',
        confirmBtn: 'Hantar',
        confirmBtnClass: 'btn-success',
        confirmBtnIcon: '<i class="fas fa-paper-plane me-2"></i>'
    },
    gagal: {
        title: 'Ralat Penghantaran',
        message: 'Maaf, penghantaran gagal. Sila cuba lagi.',
        icon: '<i class="fas fa-exclamation-triangle text-danger" style="font-size: 24px;"></i>',
        cancelBtn: 'Tutup',
        confirmBtn: 'Cuba Lagi',
        confirmBtnClass: 'btn-warning',
        confirmBtnIcon: '<i class="fas fa-redo me-2"></i>'
    },
    berjaya: {
        title: 'Berjaya!',
        message: 'Tindakan anda telah berjaya dilaksanakan.',
        icon: '<i class="fas fa-check-circle text-success" style="font-size: 24px;"></i>',
        cancelBtn: 'Tutup',
        confirmBtn: 'Lihat Butiran',
        confirmBtnClass: 'btn-primary',
        confirmBtnIcon: '<i class="fas fa-eye me-2"></i>'
    }
};

// Function to show modal with specific type and callback
function showModal(type, confirmCallback = null, cancelCallback = null) {
    const config = modalConfigs[type];
    if (!config) {
        console.error('Modal type not found:', type);
        return;
    }

    // Set modal content
    document.getElementById('modalTitle').textContent = config.title;
    document.getElementById('modalMessage').textContent = config.message;
    document.getElementById('modalIcon').innerHTML = config.icon;
    document.getElementById('modalCancelBtn').textContent = config.cancelBtn;
    
    // Set confirm button
    const confirmBtn = document.getElementById('modalConfirmBtn');
    confirmBtn.textContent = config.confirmBtn;
    confirmBtn.className = `btn ${config.confirmBtnClass}`;
    confirmBtn.innerHTML = `${config.confirmBtnIcon}${config.confirmBtn}`;

    // Remove existing event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    
    const newCancelBtn = document.getElementById('modalCancelBtn').cloneNode(true);
    document.getElementById('modalCancelBtn').parentNode.replaceChild(newCancelBtn, document.getElementById('modalCancelBtn'));

    // Add event listeners
    newConfirmBtn.addEventListener('click', function() {
        if (confirmCallback && typeof confirmCallback === 'function') {
            confirmCallback();
        }
        bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
    });

    newCancelBtn.addEventListener('click', function() {
        if (cancelCallback && typeof cancelCallback === 'function') {
            cancelCallback();
        }
    });

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}

// Navigation helper functions
function navigateToIndex() {
    window.location.href = "{{ route('appeals.amendment') }}";
}

function navigateToDetails(appealId) {
    window.location.href = `{{ url('/appeals') }}/${appealId}/status`;
}

function reloadPage() {
    window.location.reload();
}

// Convenience functions for common actions
function showSaveModal(saveCallback) {
    showModal('simpan', saveCallback);
}

function showSubmitModal(submitCallback) {
    showModal('hantar', submitCallback);
}

function showErrorModal(retryCallback = null) {
    showModal('gagal', retryCallback || reloadPage);
}

function showSuccessModal(appealId = null) {
    const viewDetailsCallback = appealId ? 
        () => navigateToDetails(appealId) : 
        navigateToIndex;
    showModal('berjaya', viewDetailsCallback);
}
</script>
