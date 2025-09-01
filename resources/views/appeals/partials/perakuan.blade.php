<div id="perakuan-section" class="mt-4">
    <h6 class="fw-bold text-primary">Perakuan</h6>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="perakuan_checkbox" name="perakuan" value="1">
            <label class="form-check-label" for="perakuan_checkbox">
                Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.
            </label>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var checkbox = document.getElementById('perakuan_checkbox');
    var hantarBtn = document.getElementById('hantar-btn');
    if (checkbox && hantarBtn) {
        checkbox.addEventListener('change', function() {
            hantarBtn.disabled = !this.checked;
        });
    }
});
</script>
@endpush
