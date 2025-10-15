@if ($errors->has('justifikasi'))
    <div class="alert alert-danger">{{ $errors->first('justifikasi') }}</div>
@endif
<h6 class="fw-bold mb-3" style="color: #0084ff; border-bottom: 3px solid #0084ff; padding-bottom: 4px;">Lanjutan Tempoh</h6>

<!-- Kelulusan Perolehan Selection -->
<div class="mb-3">
    <label for="kelulusan_perolehan_id" class="form-label fw-bold">Pilih No. Rujukan Permohonan <span class="text-danger">*</span></label>
    <select class="form-control" id="kelulusan_perolehan_id" name="kelulusan_perolehan_id" required>
        <option value="" selected disabled>Pilih Kelulusan Perolehan</option>
        @foreach(\App\Models\KelulusanPerolehan::where('jenis_permohonan', 'kvp08')->where('status', 'active')->get() as $kelulusan)
            <option value="{{ $kelulusan->id }}">
                {{ $kelulusan->no_rujukan }} - Lanjut Tempoh
            </option>
        @endforeach
    </select>
    <small class="form-text text-muted">Pilih kelulusan perolehan yang ingin dilanjutkan tempohnya</small>
</div>

<!-- Permit Selection Table -->
<div id="permit-selection-section" style="display:none;" class="mb-3">
    <h6 class="fw-bold mb-3" style="color: #0084ff; border-bottom: 2px solid #0084ff; padding-bottom: 4px;">Senarai Unit</h6>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;">Bil</th>
                    <th>No. Permit</th>
                    <th>Jenis Peralatan</th>
                    <th>Kali Permohonan</th>
                    <th>Status</th>
                    <th style="width: 100px;">Pilih</th>
                </tr>
            </thead>
            <tbody id="permit-table-body">
                {{-- Permits will be loaded here via JavaScript --}}
            </tbody>
        </table>
    </div>
</div>

<!-- Permit Information Display -->
<div id="permit-info" style="display: none;" class="mb-3">
    <div class="alert alert-info">
        <h6 class="fw-bold">Maklumat Permit:</h6>
        <div id="permit-details"></div>
    </div>
</div>

<!-- Progress Warning -->
<div id="progress-warning" style="display: none;" class="mb-3">
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Perhatian:</strong> Permit ini tidak mempunyai progress. 
        Jika permohonan kali ke-4 dibuat, permit akan dibatalkan secara automatik.
    </div>
</div>

<!-- Extension Period Display -->
<div id="extension-info" style="display: none;" class="mb-3">
    <div class="alert alert-success">
        <h6 class="fw-bold">Tempoh Lanjutan:</h6>
        <div id="extension-details"></div>
    </div>
</div>

<div class="mb-3">
    <label for="justifikasi" class="form-label fw-bold">Justifikasi Lanjutan Tempoh <span class="text-danger">*</span></label>
    <textarea class="form-control" id="justifikasi" name="justifikasi" rows="3" required>{{ old('justifikasi') }}</textarea>
</div>

<!-- Hidden fields for selected permits -->
<div id="selected-permits-container">
    {{-- Hidden fields will be added here by JavaScript --}}
</div>

<!-- Navigation Button -->
<div class="text-center mt-4">
    <button type="button" class="btn btn-sm" style="background-color: #F0F4F5; color: #000; border: 1px solid #F0F4F5; border-radius: 8px;" onclick="goToDokumenTab()" id="next-btn">
        Seterusnya <i class="fas fa-arrow-right ms-2" style="color: #000;"></i>
    </button>
</div>
