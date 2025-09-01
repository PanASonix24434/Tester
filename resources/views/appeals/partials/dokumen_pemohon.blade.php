<div id="dokumen-permohonan-section">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Senarai Dokumen Yang Perlu Pemohon Muatnaik</h6>

    <!-- Vesel Terpakai Tempatan -->
    <div id="dokumen-terpakai" style="display:none;">
        <table class="table table-bordered mb-0">
            <tr>
                <td class="align-middle font-weight-bold" style="width:40%">Surat Jual Beli Vesel Terpakai & Enjin</td>
                <td style="width:1%">:</td>
                <td>
                    <input type="file" name="surat_jual_beli_terpakai" class="form-control file-draft" data-draft-key="surat_jual_beli_terpakai" accept=".pdf,.png,.jpg,.jpeg">
                    <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                    <small class="text-success" id="draft-surat_jual_beli_terpakai"></small>
                </td>
            </tr>
            <tr>
                <td class="align-middle font-weight-bold">Salinan lesen untuk mengendali SKL</td>
                <td>:</td>
                <td>
                    <input type="file" name="lesen_skl_terpakai" class="form-control file-draft" data-draft-key="lesen_skl_terpakai" accept=".pdf,.png,.jpg,.jpeg">
                    <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                    <small class="text-success" id="draft-lesen_skl_terpakai"></small>
                </td>
            </tr>
            <tr>
                <td class="align-middle font-weight-bold">Dokumen Sokongan</td>
                <td>:</td>
                <td>
                    <div id="dokumen-sokongan-container-terpakai">
                        <div class="dokumen-sokongan-item mb-2">
                            <div class="input-group">
                                <input type="file" class="form-control dokumen-sokongan-input" name="dokumen_sokongan_terpakai[]" accept=".pdf,.png,.jpg,.jpeg">
                                <button type="button" class="btn btn-outline-danger btn-remove-dokumen" onclick="removeDokumenSokongan(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addDokumenSokongan('dokumen-sokongan-container-terpakai', 'dokumen_sokongan_terpakai[]')">
                        <i class="fas fa-plus me-2"></i>Tambah Dokumen Sokongan
                    </button>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Vesel Bina Baru -->
    <div id="dokumen-bina-baru" style="display:none;">
        <table class="table table-bordered mb-0">
            <tr>
                <td class="align-middle font-weight-bold" style="width:40%">Kertas Kerja <span class="text-danger">*</span></td>
                <td style="width:1%">:</td>
                <td>
                    <input type="file" name="kertas_kerja_bina_baru" class="form-control file-draft" data-draft-key="kertas_kerja_bina_baru" accept=".pdf,.png,.jpg,.jpeg" required>
                    <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                    <small class="text-success" id="draft-kertas_kerja_bina_baru"></small>
                </td>
            </tr>
            <tr>
                <td class="align-middle font-weight-bold">Salinan lesen untuk mengendali SKL</td>
                <td>:</td>
                <td>
                    <input type="file" name="lesen_skl_bina_baru" class="form-control file-draft" data-draft-key="lesen_skl_bina_baru" accept=".pdf,.png,.jpg,.jpeg">
                    <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                    <small class="text-success" id="draft-lesen_skl_bina_baru"></small>
                </td>
            </tr>
            <tr>
                <td class="align-middle font-weight-bold">Dokumen Sokongan</td>
                <td>:</td>
                <td>
                    <div id="dokumen-sokongan-container-bina-baru">
                        <div class="dokumen-sokongan-item mb-2">
                            <div class="input-group">
                                <input type="file" class="form-control dokumen-sokongan-input" name="dokumen_sokongan_bina_baru[]" accept=".pdf,.png,.jpg,.jpeg">
                                <button type="button" class="btn btn-outline-danger btn-remove-dokumen" onclick="removeDokumenSokongan(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addDokumenSokongan('dokumen-sokongan-container-bina-baru', 'dokumen_sokongan_bina_baru[]')">
                        <i class="fas fa-plus me-2"></i>Tambah Dokumen Sokongan
                    </button>
                </td>
            </tr>
        </table>
    </div>

    <!-- Vesel Bina Baru Luar Negara -->
    <div id="dokumen-bina-baru-luar-negara" style="display:none;">
        <table class="table table-bordered mb-0">
            <tr>
                <td class="align-middle font-weight-bold" style="width:40%">Kertas Kerja <span class="text-danger">*</span></td>
                <td style="width:1%">:</td>
                <td>
                    <input type="file" name="kertas_kerja_bina_baru_luar_negara" class="form-control file-draft" data-draft-key="kertas_kerja_bina_baru_luar_negara" accept=".pdf,.png,.jpg,.jpeg" required>
                    <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                    <small class="text-success" id="draft-kertas_kerja_bina_baru_luar_negara"></small>
                </td>
            </tr>
            <tr>
                <td class="align-middle font-weight-bold">Dokumen Sokongan</td>
                <td>:</td>
                <td>
                    <div id="dokumen-sokongan-container-bina-baru-luar-negara">
                        <div class="dokumen-sokongan-item mb-2">
                            <div class="input-group">
                                <input type="file" class="form-control dokumen-sokongan-input" name="dokumen_sokongan_bina_baru_luar_negara[]" accept=".pdf,.png,.jpg,.jpeg">
                                <button type="button" class="btn btn-outline-danger btn-remove-dokumen" onclick="removeDokumenSokongan(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addDokumenSokongan('dokumen-sokongan-container-bina-baru-luar-negara', 'dokumen_sokongan_bina_baru_luar_negara[]')">
                        <i class="fas fa-plus me-2"></i>Tambah Dokumen Sokongan
                    </button>
                </td>
            </tr>
        </table>
    </div>

    <!-- Pangkalan -->
    <div id="dokumen-pangkalan" style="display:none;">
        <table class="table table-bordered mb-0">
            <tr>
                <td class="align-middle font-weight-bold" style="width:40%">Dokumen Sokongan <span class="text-danger">*</span></td>
                <td style="width:1%">:</td>
                <td>
                    <div id="dokumen-sokongan-container-pangkalan">
                        <div class="dokumen-sokongan-item mb-2">
                            <div class="input-group">
                                <input type="file" class="form-control dokumen-sokongan-input" name="dokumen_sokongan_pangkalan[]" accept=".pdf,.png,.jpg,.jpeg" required>
                                <button type="button" class="btn btn-outline-danger btn-remove-dokumen" onclick="removeDokumenSokongan(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addDokumenSokongan('dokumen-sokongan-container-pangkalan', 'dokumen_sokongan_pangkalan[]')">
                        <i class="fas fa-plus me-2"></i>Tambah Dokumen Sokongan
                    </button>
                </td>
            </tr>
        </table>
    </div>

    <!-- Jenis Bahan Binaan Vessel -->
    <div id="dokumen-bahan-binaan" style="display:none;">
        <table class="table table-bordered mb-0">
            <tr>
                <td class="align-middle font-weight-bold" style="width:40%">Dokumen Sokongan <span class="text-danger">*</span></td>
                <td style="width:1%">:</td>
                <td>
                    <div id="dokumen-sokongan-container-bahan-binaan">
                        <div class="dokumen-sokongan-item mb-2">
                            <div class="input-group">
                                <input type="file" class="form-control dokumen-sokongan-input" name="dokumen_sokongan_bahan_binaan[]" accept=".pdf,.png,.jpg,.jpeg" required>
                                <button type="button" class="btn btn-outline-danger btn-remove-dokumen" onclick="removeDokumenSokongan(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addDokumenSokongan('dokumen-sokongan-container-bahan-binaan', 'dokumen_sokongan_bahan_binaan[]')">
                        <i class="fas fa-plus me-2"></i>Tambah Dokumen Sokongan
                    </button>
                </td>
            </tr>
        </table>
    </div>

    <!-- Tukar Jenis Peralatan -->
    <div id="dokumen-tukar-peralatan" style="display:none;">
        <table class="table table-bordered mb-0">
            <tr>
                <td class="align-middle font-weight-bold" style="width:40%">Dokumen Sokongan <span class="text-danger">*</span></td>
                <td style="width:1%">:</td>
                <td>
                    <div id="dokumen-sokongan-container-tukar-peralatan">
                        <div class="dokumen-sokongan-item mb-2">
                            <div class="input-group">
                                <input type="file" class="form-control dokumen-sokongan-input" name="dokumen_sokongan_tukar_peralatan[]" accept=".pdf,.png,.jpg,.jpeg" required>
                                <button type="button" class="btn btn-outline-danger btn-remove-dokumen" onclick="removeDokumenSokongan(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addDokumenSokongan('dokumen-sokongan-container-tukar-peralatan', 'dokumen_sokongan_tukar_peralatan[]')">
                        <i class="fas fa-plus me-2"></i>Tambah Dokumen Sokongan
                    </button>
                </td>
            </tr>
        </table>
    </div>

    <!-- Tukar Nama Pendaftaran Syarikat -->
    <div id="dokumen-tukar-nama-syarikat" style="display:none;">
        
        
        <!-- Enterprise -->
        <div class="mb-4">
            <h6 class="font-weight-bold text-dark mb-3">Enterprise</h6>
            <table class="table table-bordered mb-0">
                <tr>
                    <td class="align-middle font-weight-bold" style="width:40%">Borang E - Kaedah 13</td>
                    <td style="width:1%">:</td>
                    <td>
                        <input type="file" name="borang_e_kaedah_13" class="form-control file-draft" data-draft-key="borang_e_kaedah_13" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        <small class="text-success" id="draft-borang_e_kaedah_13"></small>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle font-weight-bold">Salinan Profil Perniagaan</td>
                    <td>:</td>
                    <td>
                        <input type="file" name="profil_perniagaan_enterprise" class="form-control file-draft" data-draft-key="profil_perniagaan_enterprise" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        <small class="text-success" id="draft-profil_perniagaan_enterprise"></small>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Syarikat -->
        <div class="mb-4">
            <h6 class="font-weight-bold text-dark mb-3">Syarikat</h6>
            <table class="table table-bordered mb-0">
                <tr>
                    <td class="align-middle font-weight-bold" style="width:40%">Form 9</td>
                    <td style="width:1%">:</td>
                    <td>
                        <input type="file" name="form_9" class="form-control file-draft" data-draft-key="form_9" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        <small class="text-success" id="draft-form_9"></small>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle font-weight-bold">Form 24</td>
                    <td>:</td>
                    <td>
                        <input type="file" name="form_24" class="form-control file-draft" data-draft-key="form_24" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        <small class="text-success" id="draft-form_24"></small>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle font-weight-bold">Form 44</td>
                    <td>:</td>
                    <td>
                        <input type="file" name="form_44" class="form-control file-draft" data-draft-key="form_44" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        <small class="text-success" id="draft-form_44"></small>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle font-weight-bold">Form 49</td>
                    <td>:</td>
                    <td>
                        <input type="file" name="form_49" class="form-control file-draft" data-draft-key="form_49" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        <small class="text-success" id="draft-form_49"></small>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Persatuan -->
        <div class="mb-4">
            <h6 class="font-weight-bold text-dark mb-3">Persatuan</h6>
            <table class="table table-bordered mb-0">
                <tr>
                    <td class="align-middle font-weight-bold" style="width:40%">Pendaftaran Persatuan</td>
                    <td style="width:1%">:</td>
                    <td>
                        <input type="file" name="pendaftaran_persatuan" class="form-control file-draft" data-draft-key="pendaftaran_persatuan" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        <small class="text-success" id="draft-pendaftaran_persatuan"></small>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle font-weight-bold">Profil Persatuan</td>
                    <td>:</td>
                    <td>
                        <input type="file" name="profil_persatuan" class="form-control file-draft" data-draft-key="profil_persatuan" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        <small class="text-success" id="draft-profil_persatuan"></small>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Koperasi -->
        <div class="mb-4">
            <h6 class="font-weight-bold text-dark mb-3">Koperasi</h6>
            <table class="table table-bordered mb-0">
                <tr>
                    <td class="align-middle font-weight-bold" style="width:40%">Pendaftaran Koperasi</td>
                    <td style="width:1%">:</td>
                    <td>
                        <input type="file" name="pendaftaran_koperasi" class="form-control file-draft" data-draft-key="pendaftaran_koperasi" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        <small class="text-success" id="draft-pendaftaran_koperasi"></small>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle font-weight-bold">Profil Koperasi</td>
                    <td>:</td>
                    <td>
                        <input type="file" name="profil_koperasi" class="form-control file-draft" data-draft-key="profil_koperasi" accept=".pdf,.png,.jpg,.jpeg">
                        <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                        <small class="text-success" id="draft-profil_koperasi"></small>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="text-center mt-4">
        <button type="button" class="btn btn-secondary me-2" onclick="previousTab('butiran-tab')">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </button>
        <button type="button" class="btn btn-primary" onclick="nextTab('perakuan-tab')">
            Seterusnya <i class="fas fa-arrow-right ms-2"></i>
        </button>
        <button type="button" class="btn btn-warning ms-2" id="simpan-draft">Simpan</button>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var jenisPerolehan = document.getElementById('jenis_perolehan');
    var jenisPindaan = document.getElementById('jenis_pindaan_syarat');
    var dokumenFields = document.querySelectorAll('input[type="file"][required]'); // Required file inputs
    var kembaliBtn = document.getElementById('kembali-dokumen');
    var simpanBtn = document.getElementById('simpan-draft');

    // Function to set required fields
    function setRequiredFields(sectionId) {
        // Remove required from all file inputs
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
            input.removeAttribute('required');
            input.classList.remove('is-invalid');
        });
        
        // Add required only to specific required documents based on section
        if (sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                // For KPV-07 (Pindaan Syarat), only kertas kerja is required
                if (sectionId === 'dokumen-bina-baru') {
                    const kertasKerjaInput = section.querySelector('input[name="kertas_kerja_bina_baru"]');
                    if (kertasKerjaInput) {
                        kertasKerjaInput.setAttribute('required', 'required');
                        // Add validation event listener
                        kertasKerjaInput.addEventListener('change', function() {
                            validateFileField(this);
                        });
                    }
                } else if (sectionId === 'dokumen-bina-baru-luar-negara') {
                    const kertasKerjaInput = section.querySelector('input[name="kertas_kerja_bina_baru_luar_negara"]');
                    if (kertasKerjaInput) {
                        kertasKerjaInput.setAttribute('required', 'required');
                        // Add validation event listener
                        kertasKerjaInput.addEventListener('change', function() {
                            validateFileField(this);
                        });
                    }
                } else {
                    // For other sections, check if input has data-required="true" attribute
                    section.querySelectorAll('input[type="file"][data-required="true"]').forEach(function(input) {
                        input.setAttribute('required', 'required');
                        // Add validation event listener
                        input.addEventListener('change', function() {
                            validateFileField(this);
                        });
                    });
                }
                
                // Update dokumen sokongan requirements after setting required fields
                if (typeof updateDokumenSokonganRequirements === 'function') {
                    updateDokumenSokonganRequirements();
                }
            }
        }
    }

    // Function to show document sections based on selection
    function showDokumenSection() {
        var jpValue = jenisPindaan ? jenisPindaan.value : '';
        var jprValue = jenisPerolehan ? jenisPerolehan.value : '';

        // Hide all document sections initially
        document.getElementById('dokumen-terpakai').style.display = 'none';
        document.getElementById('dokumen-bina-baru').style.display = 'none';
        document.getElementById('dokumen-bina-baru-luar-negara').style.display = 'none'; // Hide new vessel sections
        document.getElementById('dokumen-pangkalan').style.display = 'none';
        document.getElementById('dokumen-bahan-binaan').style.display = 'none';
        document.getElementById('dokumen-tukar-peralatan').style.display = 'none';
        document.getElementById('dokumen-tukar-nama-syarikat').style.display = 'none';

        // Show the correct section based on selection and set required fields
        if (jpValue === 'Jenis perolehan') {
            // Handle perolehan sub-sections
            const jenisPerolehan = document.getElementById('jenis_perolehan');
            if (jenisPerolehan && jenisPerolehan.value === 'bina_baru_dalam_negara') {
                document.getElementById('dokumen-bina-baru').style.display = 'block';
                setRequiredFields('dokumen-bina-baru');
            } else if (jenisPerolehan && jenisPerolehan.value === 'bina_baru_luar_negara') {
                document.getElementById('dokumen-bina-baru-luar-negara').style.display = 'block';
                setRequiredFields('dokumen-bina-baru-luar-negara');
            } else if (jenisPerolehan && (jenisPerolehan.value === 'terpakai_tempatan' || jenisPerolehan.value === 'terpakai_luar_negara')) {
                document.getElementById('dokumen-terpakai').style.display = 'block';
                setRequiredFields('dokumen-terpakai');
            }
        } else if (jpValue === 'Pangkalan') {
            document.getElementById('dokumen-pangkalan').style.display = 'block';
            setRequiredFields('dokumen-pangkalan');
        } else if (jpValue === 'Jenis bahan binaan vesel') {
            document.getElementById('dokumen-bahan-binaan').style.display = 'block';
            setRequiredFields('dokumen-bahan-binaan');
        } else if (jpValue === 'Tukar Jenis Peralatan') {
            document.getElementById('dokumen-tukar-peralatan').style.display = 'block';
            setRequiredFields('dokumen-tukar-peralatan');
        } else if (jpValue === 'Tukar Nama Pendaftaran Syarikat') {
            document.getElementById('dokumen-tukar-nama-syarikat').style.display = 'block';
            setRequiredFields('dokumen-tukar-nama-syarikat');
        } else {
            setRequiredFields(null);
        }
        updateRequirementsSummary(jpValue, jprValue);
    }

    // Function to save draft to localStorage
    function saveDraft() {
        var draftData = {};
        var form = document.getElementById('butiran-form');
        var formData = new FormData(form);
        // Save all form fields except files
        form.querySelectorAll('input, select, textarea').forEach(function(input) {
            if (input.type === 'checkbox') {
                draftData[input.name] = input.checked;
            } else if (input.type !== 'file') {
                draftData[input.name] = input.value;
            }
        });
        // Save file info (not the file itself)
        form.querySelectorAll('input[type="file"]').forEach(function(input) {
            if (input.files.length > 0) {
                draftData[input.name + '_fileName'] = input.files[0].name;
            }
        });
        localStorage.setItem('appeal_draft', JSON.stringify(draftData));
        // Show success message
        var successMsg = document.createElement('div');
        successMsg.className = 'alert alert-success mt-3';
        successMsg.textContent = 'Draft berjaya disimpan!';
        document.getElementById('dokumen-permohonan-section').appendChild(successMsg);
        setTimeout(function() { successMsg.remove(); }, 3000);
    }

    // Function to load draft from localStorage
    function loadDraft() {
        var draftData = localStorage.getItem('appeal_draft');
        if (draftData) {
            var data = JSON.parse(draftData);
            var form = document.getElementById('butiran-form');
            form.querySelectorAll('input, select, textarea').forEach(function(input) {
                if (input.type === 'checkbox') {
                    input.checked = !!data[input.name];
                } else if (input.type !== 'file' && data[input.name] !== undefined) {
                    input.value = data[input.name];
                }
            });
            // Show file names for saved files
            form.querySelectorAll('input[type="file"]').forEach(function(input) {
                var fileName = data[input.name + '_fileName'];
                var draftElement = document.getElementById('draft-' + input.name);
                if (fileName && draftElement) {
                    draftElement.textContent = 'File tersimpan: ' + fileName;
                }
            });
        }
    }

    // Function to clear draft from localStorage
    function clearDraft() {
        localStorage.removeItem('appeal_draft');
    }

    // Handle Kembali button
    if (kembaliBtn) {
        kembaliBtn.addEventListener('click', function() {
            $('#butiran-tab').tab('show');
        });
    }

    // Attach to Simpan button
    if (simpanBtn) {
        simpanBtn.addEventListener('click', function() {
            saveDraft();
        });
    }

    // Monitor changes in the "Jenis Pindaan" and "Jenis Perolehan" fields to show the corresponding sections
    if (jenisPerolehan) {
        jenisPerolehan.addEventListener('change', showDokumenSection);
    }
    if (jenisPindaan) {
        jenisPindaan.addEventListener('change', showDokumenSection);
    }

    // Initially call the function to show the appropriate sections
    showDokumenSection();
    
    // Load draft on page load
    loadDraft();

    // Clear draft on successful submission (listen for form submit)
    var form = document.getElementById('butiran-form');
    if (form) {
        form.addEventListener('submit', function() {
            clearDraft();
        });
    }
});
</script>
@endpush
