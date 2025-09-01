@php
    $selectedYear = request('tahun');
    $statusStocks = $selectedYear 
        ? \App\Models\StatusStock::with('fishType')->where('tahun', $selectedYear)->whereNotNull('fish_type_id')->get()
        : collect();
@endphp

<div class="mb-2" style="border-bottom: 3px solid #007bff; width: fit-content; margin-left:16px;">
    <span class="fw-bold" style="color:#007bff;">Tindakan Keputusan Akhir</span>
</div>

@if($selectedYear)
    <div style="padding-left:16px; padding-right:16px;">
        <!-- Perakuan Keputusan KPP Section -->
        <div class="card mb-4" style="border:1.5px solid #e3e6f0;">
            <div class="card-header" style="background:#f8f9fa; border-bottom:1.5px solid #e3e6f0;">
                <h6 class="mb-0" style="color: #007bff;">Perakuan Keputusan KPP</h6>
            </div>
            <div class="card-body">
                <div style="border-bottom: 2px solid #007bff; margin-bottom: 15px;"></div>
                
                <form id="perakuanForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Saya akui:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="terima_keputusan" name="perakuan" value="terima" onchange="toggleHantarButton()">
                            <label class="form-check-label text-muted" for="terima_keputusan">
                                Terima
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Current Status Summary -->
        <div class="card mb-4" style="border:1.5px solid #e3e6f0;">
            <div class="card-header" style="background:#f8f9fa; border-bottom:1.5px solid #e3e6f0;">
                <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Status Semasa</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="text-center">
                            <h4 class="text-primary">{{ count($statusStocks) }}</h4>
                            <small class="text-muted">Jumlah Rekod</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <h4 class="text-success">{{ $statusStocks->where('pengesahan_status', 'approved')->count() }}</h4>
                            <small class="text-muted">Pengesahan Lulus</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <h4 class="text-danger">{{ $statusStocks->where('pengesahan_status', 'rejected')->count() }}</h4>
                            <small class="text-muted">Pengesahan Tidak Lulus</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-warning">{{ $statusStocks->where('semakan_status', 'disemak')->count() }}</h4>
                            <small class="text-muted">Semakan Selesai</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-info">{{ $statusStocks->where('final_decision', 'approved')->count() }}</h4>
                            <small class="text-muted">Keputusan Akhir</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                            <!-- Action Buttons -->
                    <div class="d-flex justify-content-center align-items-center mt-4" style="padding-left:16px; padding-right:16px;">
                        <div class="me-3">
                            <button type="button" class="btn btn-outline-secondary" onclick="goBack()" style="background-color: white; color: #6c757d; border-color: #6c757d;">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" id="hantarButton" onclick="showConfirmationModal()" style="background-color: #007bff; color: white; border-color: #007bff;" disabled>
                                <i class="fas fa-paper-plane"></i> Hantar
                            </button>
                        </div>
                    </div>

                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #007bff; color: white;">
                                    <h5 class="modal-title" id="confirmationModalLabel">
                                        <i class="fas fa-exclamation-triangle"></i> Pengesahan Tindakan
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-3">
                                        <i class="fas fa-question-circle fa-3x text-warning"></i>
                                    </div>
                                    <p class="text-center mb-0">
                                        <strong>Adakah anda pasti mahu menghantar perakuan keputusan?</strong>
                                    </p>
                                    <p class="text-center text-muted small">
                                        Tindakan ini tidak boleh dibatalkan dan akan mengemaskini status keputusan akhir dalam pangkalan data.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i> Batal
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="hantarKeputusan()">
                                        <i class="fas fa-check"></i> Ya, Hantar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <h5 class="text-success mb-3">Perakuan Keputusan Berjaya Dihantar!</h5>
                                    <p class="text-muted">
                                        Keputusan akhir telah dikemaskini dalam pangkalan data untuk tahun {{ $selectedYear }}.
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
    </div>
@else
    <div class="text-center py-5" style="padding-left:16px; padding-right:16px;">
        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">Sila Pilih Tahun</h5>
        <p class="text-muted">Pilih tahun untuk membuat tindakan keputusan</p>
    </div>
@endif

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
function goBack() {
    const currentYear = '{{ $selectedYear }}';
    window.location.href = `?tab=dokumen_permohonan&tahun=${currentYear}`;
}

function toggleHantarButton() {
    const terimaRadio = document.getElementById('terima_keputusan');
    const hantarButton = document.getElementById('hantarButton');

    if (terimaRadio.checked) {
        hantarButton.disabled = false;
        hantarButton.style.opacity = '1';
    } else {
        hantarButton.disabled = true;
        hantarButton.style.opacity = '0.6';
    }
}

function showConfirmationModal() {
    const terimaRadio = document.getElementById('terima_keputusan');

    if (!terimaRadio.checked) {
        alert('Sila tandakan "Terima" terlebih dahulu sebelum menghantar.');
        return;
    }

    // Show the confirmation modal
    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    modal.show();
}

function hantarKeputusan() {
    // Close the modal first
    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
    if (modal) {
        modal.hide();
    }

    const hantarButton = document.getElementById('hantarButton');
    const originalText = hantarButton.innerHTML;
    hantarButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghantar...';
    hantarButton.disabled = true;

    const data = {
        tahun: '{{ $selectedYear }}',
        semakan_status: 'disemak',
        pengesahan_status: 'approved'
    };

    console.log('Sending data to API:', data);
    fetch('{{ route("status-stock.final-decision") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
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
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        } else {
            alert('Ralat! ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ralat semasa menghantar perakuan: ' + error.message);
    })
    .finally(() => {
        hantarButton.innerHTML = originalText;
        hantarButton.disabled = false;
    });
}

function redirectToDashboard() {
    window.location.href = '{{ route("home") }}';
}

document.addEventListener('DOMContentLoaded', function() {
    toggleHantarButton();
});
</script> 