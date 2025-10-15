@if ($errors->has('dokumen_sokongan'))
    <div class="alert alert-danger">{{ $errors->first('dokumen_sokongan') }}</div>
@endif
<h6 class="fw-bold mb-3" style="color: #0084ff; border-bottom: 3px solid #0084ff; padding-bottom: 4px;">Senarai Dokumen Yang Perlu Pemohon Muatnaik</h6>
<div class="mb-3 row align-items-center">
    <label for="dokumen_sokongan" class="col-sm-3 col-form-label fw-bold">Dokumen Sokongan</label>
    <div class="col-sm-9">
        <input type="file" class="form-control" id="dokumen_sokongan" name="dokumen_sokongan" accept=".pdf,.png,.jpg,.jpeg" required>
        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 10MB.</small>
    </div>
</div>

<!-- Navigation Buttons -->
<div class="text-center mt-4">
    <button type="button" class="btn btn-sm" style="background-color: #282c34; color: #fff; border: 1px solid #282c34; border-radius: 8px;" onclick="goToButiranTab()">
        <i class="fas fa-arrow-left me-2" style="color: #fff;"></i> Kembali
    </button>
    <button type="button" class="btn btn-sm" style="background-color: #28a745; color: #fff; border: 1px solid #28a745; border-radius: 8px;" onclick="saveDokumen()">
        <i class="fas fa-save me-2" style="color: #fff;"></i> Simpan
    </button>
    <button type="button" class="btn btn-sm" style="background-color: #F0F4F5; color: #000; border: 1px solid #F0F4F5; border-radius: 8px;" onclick="goToPerakuanTab()">
        Seterusnya <i class="fas fa-arrow-right ms-2" style="color: #000;"></i>
    </button>
</div>
