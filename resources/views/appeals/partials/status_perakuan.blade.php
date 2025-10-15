<h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Perakuan</h6>

<div class="form-group">
    <label class="font-weight-bold d-block">Saya mengakui bahawa:</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="perakuan_checkbox" {{ $perakuan && $perakuan->perakuan_checkbox ? 'checked' : '' }} disabled>
        <label class="form-check-label" for="perakuan_checkbox">
            Saya mengakui bahawa maklumat yang diberikan adalah benar dan lengkap. Saya memahami bahawa memberikan maklumat palsu adalah satu kesalahan di bawah undang-undang.
        </label>
    </div>
</div>

<!-- Navigation Buttons -->
<div class="text-center mt-4">
    <button type="button" class="btn btn-sm me-3" style="background-color: #282c34; color: #fff; border: 1px solid #282c34; border-radius: 8px;" onclick="prevTab('dokumen-status-tab')">
        <i class="fas fa-arrow-left me-2" style="color: #fff;"></i> Kembali
    </button>
    <button type="button" class="btn btn-sm" style="background-color: #F0F4F5; color: #000; border: 1px solid #F0F4F5; border-radius: 8px;" onclick="nextTab('keputusan-status-tab')">
        Seterusnya <i class="fas fa-arrow-right ms-2" style="color: #000;"></i>
    </button>
</div>

<script>
// Tab Navigation Functions
function prevTab(tabId) {
    const tabButton = document.querySelector(`#${tabId}`);
    if (tabButton) {
        const tab = new bootstrap.Tab(tabButton);
        tab.show();
    }
}

function nextTab(tabId) {
    const tabButton = document.querySelector(`#${tabId}`);
    if (tabButton) {
        const tab = new bootstrap.Tab(tabButton);
        tab.show();
    }
}
</script>
