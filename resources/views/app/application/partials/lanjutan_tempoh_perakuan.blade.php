@if ($errors->has('perakuan_checkbox'))
    <div class="alert alert-danger">{{ $errors->first('perakuan_checkbox') }}</div>
@endif
<h6 class="fw-bold mb-3" style="color: #0084ff; border-bottom: 3px solid #0084ff; padding-bottom: 4px;">Perakuan Pemohon</h6>
<div class="form-check mb-4">
    <input class="form-check-input" type="checkbox" id="perakuan_checkbox" name="perakuan_checkbox" required {{ old('perakuan_checkbox') ? 'checked' : '' }}>
    <label class="form-check-label" for="perakuan_checkbox">
        Saya dengan ini mengakui dan mengesahkan bahawa semua maklumat yang diberikan oleh saya adalah benar. Sekiranya terdapat maklumat yang tidak benar, pihak Jabatan boleh menolak permohonan saya dan tindakan undang-undang boleh dikenakan ke atas saya.
    </label>
</div>

<!-- Hidden field for justifikasi -->
<input type="hidden" id="hidden_justifikasi" name="hidden_justifikasi" value="{{ old('justifikasi') }}">

<div class="d-flex justify-content-end gap-2">
    <button type="button" class="btn btn-sm" style="background-color: #282c34; color: #fff; border: 1px solid #282c34; border-radius: 8px;" onclick="goToDokumenTab()">Kembali</button>
    <button type="submit" class="btn btn-sm" style="background-color: #28a745; color: #fff; border: 1px solid #28a745; border-radius: 8px;">
        <i class="fas fa-paper-plane me-2" style="color: #fff;"></i>Hantar
    </button>
</div>
