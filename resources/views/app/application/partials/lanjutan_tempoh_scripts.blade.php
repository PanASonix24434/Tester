<script>
document.addEventListener('DOMContentLoaded', function() {
    const kelulusanSelect = document.getElementById('kelulusan_perolehan_id');
    const permitSelectionSection = document.getElementById('permit-selection-section');
    const permitTableBody = document.getElementById('permit-table-body');

    if (kelulusanSelect) {
        kelulusanSelect.addEventListener('change', function() {
            if (this.value) {
                loadPermitsForKvp08(this.value);
            } else {
                permitSelectionSection.style.display = 'none';
            }
        });
    }

    // Copy justifikasi value to hidden field on Perakuan form submit
    const perakuanForm = document.querySelector('form[action*="perakuan"]');
    if (perakuanForm) {
        perakuanForm.addEventListener('submit', function(e) {
            const justifikasi = document.getElementById('justifikasi');
            if (justifikasi) {
                document.getElementById('hidden_justifikasi').value = justifikasi.value;
            }
        });
    }
});

// Function to load permits for KPV-08
function loadPermitsForKvp08(kelulusanId) {
    if (!kelulusanId) {
        document.getElementById('permit-selection-section').style.display = 'none';
        return;
    }

    // Show the permit selection section
    document.getElementById('permit-selection-section').style.display = 'block';

    // Fetch permits via AJAX
    console.log('Fetching permits for kelulusan ID:', kelulusanId);
    fetch(`{{ url('/debug-permits') }}/${kelulusanId}`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const permitTableBody = document.getElementById('permit-table-body');
            permitTableBody.innerHTML = '';

            if (data.permits && data.permits.length > 0) {
                data.permits.forEach((permit, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="text-center">${index + 1}</td>
                        <td>${permit.no_permit}</td>
                        <td>${permit.jenis_peralatan}</td>
                        <td>
                            <span class="badge bg-info text-white">
                                ${permit.application_count_text || 'Kali Pertama'}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-${permit.status === 'ada_kemajuan' ? 'success' : 'warning'}">
                                ${permit.status === 'ada_kemajuan' ? 'Ada kemajuan' : 'Tiada kemajuan'}
                            </span>
                        </td>
                        <td class="text-center">
                            <input type="checkbox" name="selected_permits[]" value="${permit.id}" 
                                   class="form-check-input permit-checkbox" onchange="updateSelectedPermits()">
                        </td>
                    `;
                    permitTableBody.appendChild(row);
                });
            } else {
                permitTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Tiada permit dijumpai untuk kelulusan ini.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error loading permits:', error);
            document.getElementById('permit-table-body').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Ralat memuatkan permit.</td></tr>';
        });
}

// Function to update hidden fields for selected permits
function updateSelectedPermits() {
    const selectedPermitsContainer = document.getElementById('selected-permits-container');
    const checkboxes = document.querySelectorAll('.permit-checkbox:checked');
    
    // Clear existing hidden fields
    selectedPermitsContainer.innerHTML = '';
    
    // Add hidden fields for selected permits
    checkboxes.forEach(checkbox => {
        const hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = 'permit_id[]';
        hiddenField.value = checkbox.value;
        selectedPermitsContainer.appendChild(hiddenField);
    });
    
    console.log('Selected permits:', Array.from(checkboxes).map(cb => cb.value));
}

// Simple Tab Navigation Functions
function goToDokumenTab() {
    console.log('Going to dokumen tab...');
    
    // Hide all tab panes
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.style.display = 'none';
        pane.classList.remove('show', 'active');
    });
    
    // Remove active from all nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        link.setAttribute('aria-selected', 'false');
    });
    
    // Show dokumen tab pane
    const dokumenPane = document.getElementById('dokumen');
    if (dokumenPane) {
        dokumenPane.style.display = 'block';
        dokumenPane.classList.add('show', 'active');
    }
    
    // Activate dokumen nav link
    const dokumenNav = document.getElementById('dokumen-tab');
    if (dokumenNav) {
        dokumenNav.classList.add('active');
        dokumenNav.setAttribute('aria-selected', 'true');
    }
    
    console.log('Successfully navigated to dokumen tab');
}

function goToButiranTab() {
    console.log('Going to butiran tab...');
    
    // Hide all tab panes
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.style.display = 'none';
        pane.classList.remove('show', 'active');
    });
    
    // Remove active from all nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        link.setAttribute('aria-selected', 'false');
    });
    
    // Show butiran tab pane
    const butiranPane = document.getElementById('butiran');
    if (butiranPane) {
        butiranPane.style.display = 'block';
        butiranPane.classList.add('show', 'active');
    }
    
    // Activate butiran nav link
    const butiranNav = document.getElementById('butiran-tab');
    if (butiranNav) {
        butiranNav.classList.add('active');
        butiranNav.setAttribute('aria-selected', 'true');
    }
    
    console.log('Successfully navigated to butiran tab');
}

function goToPerakuanTab() {
    console.log('Going to perakuan tab...');
    
    // Hide all tab panes
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.style.display = 'none';
        pane.classList.remove('show', 'active');
    });
    
    // Remove active from all nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        link.setAttribute('aria-selected', 'false');
    });
    
    // Show perakuan tab pane
    const perakuanPane = document.getElementById('perakuan');
    if (perakuanPane) {
        perakuanPane.style.display = 'block';
        perakuanPane.classList.add('show', 'active');
    }
    
    // Activate perakuan nav link
    const perakuanNav = document.getElementById('perakuan-tab');
    if (perakuanNav) {
        perakuanNav.classList.add('active');
        perakuanNav.setAttribute('aria-selected', 'true');
    }
    
    console.log('Successfully navigated to perakuan tab');
}
</script>
