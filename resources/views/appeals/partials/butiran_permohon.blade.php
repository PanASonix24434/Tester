{{-- Kelulusan Perolehan Selection --}}
<h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Kelulusan Perolehan</h6>
<div class="form-group">
    <label class="font-weight-bold" for="kelulusan_perolehan_id">Pilih No. Rujukan Permohonan <span class="text-danger">*</span></label>
    <select class="form-control" id="kelulusan_perolehan_id" name="kelulusan_perolehan_id" required>
        <option value="" selected disabled>Pilih Kelulusan Perolehan</option>
        @foreach(\App\Models\KelulusanPerolehan::where('status', 'active')->get() as $kelulusan)
            <option value="{{ $kelulusan->id }}" data-type="{{ $kelulusan->jenis_permohonan }}">
                {{ $kelulusan->no_rujukan }} - {{ $kelulusan->jenis_permohonan === 'kvp07' ? 'Rayuan Pindaan Syarat' : 'Lanjut Tempoh' }}
            </option>
        @endforeach
    </select>
</div>

{{-- Permit Selection Section --}}
<div id="permit-selection-section" style="display:none;">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Pilih Permit</h6>
    <div id="permit-checkboxes">
        {{-- Permits will be loaded here via JavaScript --}}
    </div>
</div>

<h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Pindaan Syarat</h6>
<div class="form-group">
    <label class="font-weight-bold" for="jenis_pindaan_syarat">Jenis Pindaan Syarat <span class="text-danger">*</span></label>
    <select class="form-control" id="jenis_pindaan_syarat" name="jenis_pindaan_syarat">
        <option value="" selected disabled>Pilih Jenis Pindaan Syarat</option>
        <option value="Jenis bahan binaan vesel">Jenis Bahan Binaan Vesel</option>
        <option value="Jenis perolehan">Jenis Perolehan</option>
        <option value="Pangkalan">Pangkalan</option>
        <option value="Tukar Jenis Peralatan">Tukar Jenis Peralatan</option>
        <option value="Tukar Nama Pendaftaran Syarikat">Tukar Nama Pendaftaran Syarikat</option>
    </select>
</div>

<div id="section-bahan" style="display:none;">
    <div class="form-group">
        <label class="font-weight-bold" for="jenis_bahan_binaan_vesel">Jenis Bahan Binaan Vesel <span class="text-danger">*</span></label>
        <select class="form-control" id="jenis_bahan_binaan_vesel" name="jenis_bahan_binaan_vesel">
            <option value="" selected disabled>Pilih Jenis Bahan Binaan Vesel</option>
            <option value="Kayu">Kayu</option>
            <option value="Gentian Kaca (Fiber)">Gentian Kaca (Fiber)</option>
            <option value="Besi">Besi</option>
        </select>
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="nyatakan">Justifikasi Rayuan <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="nyatakan" name="nyatakan">
    </div>
</div>
<div id="section-perolehan" style="display:none;">
    <div class="form-group">
        <label class="font-weight-bold" for="jenis_perolehan">Jenis Perolehan <span class="text-danger">*</span></label>
        <select class="form-control" id="jenis_perolehan" name="jenis_perolehan">
            <option value="" selected disabled>Pilih Jenis Perolehan</option>
            <option value="bina_baru_dalam_negara">Vesel Bina Baru Dalam Negara</option>
            <option value="bina_baru_luar_negara">Vesel Bina Baru Luar Negara</option>
            <option value="terpakai_tempatan">Vesel Terpakai Tempatan</option>
            <option value="terpakai_luar_negara">Vesel Terpakai Luar Negara</option>
        </select>
    </div>
    <div id="perolehan-bina-baru" style="display:none;">
        <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Vesel Bina Baru</h6>
        <div class="form-group">
            <label class="font-weight-bold" for="nama_limbungan_baru">Nama Limbungan <span class="text-danger">*</span></label>
            <select class="form-control" id="nama_limbungan_baru" name="nama_limbungan_baru">
                <option value="" selected disabled>Pilih Nama Limbungan</option>
                <option value="Limbungan A">Limbungan A</option>
                <option value="Limbungan B">Limbungan B</option>
                <option value="Limbungan C">Limbungan C</option>
                <option value="Limbungan D">Limbungan D</option>
            </select>
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="negeri_limbungan_baru">Negeri Limbungan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="negeri_limbungan_baru" name="negeri_limbungan_baru" readonly>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold" for="daerah_baru">Daerah <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="daerah_baru" name="daerah_baru" readonly>
            </div>
            <div class="form-group col-md-6">
                <label class="font-weight-bold" for="alamat_baru">Alamat Limbungan <span class="text-danger">*</span></label>
                <textarea class="form-control" id="alamat_baru" name="alamat_baru" rows="3" readonly></textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold" for="poskod_baru">Poskod <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="poskod_baru" name="poskod_baru" readonly>
            </div>
        </div>
    </div>
    <div id="perolehan-terpakai-tempatan" style="display:none;">
        <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Vesel Terpakai</h6>
        <div class="form-group">
            <label class="font-weight-bold d-block">Vesel Pernah Berdaftar Dengan Jabatan Perikanan Malaysia/Jabatan Laut Malaysia? <span class="text-danger">*</span></label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pernah_berdaftar" id="berdaftar_ya" value="ya">
                <label class="form-check-label" for="berdaftar_ya">Ya</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pernah_berdaftar" id="berdaftar_tidak" value="tidak">
                <label class="form-check-label" for="berdaftar_tidak">Tidak</label>
            </div>
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="no_pendaftaran_vesel">No Tetap Vesel/No. Pendaftaran Vesel <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="no_pendaftaran_vesel" name="no_pendaftaran_vesel">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold" for="negeri_asal_vesel">Negeri Asal Vesel Didafarkan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="negeri_asal_vesel" name="negeri_asal_vesel">
            </div>
            <div class="form-group col-md-6">
                <label class="font-weight-bold" for="pelabuhan_pangkalan">Pelabuhan/Pangkalan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="pelabuhan_pangkalan" name="pelabuhan_pangkalan">
            </div>
        </div>
    </div>
    <div id="perolehan-bina-baru-luar-negara" style="display:none;">
        <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Vesel Bina Baru Luar Negara</h6>
        <div class="form-group">
            <label class="font-weight-bold" for="alamat_limbungan_luar_negara">Alamat Limbungan <span class="text-danger">*</span></label>
            <textarea class="form-control" id="alamat_limbungan_luar_negara" name="alamat_limbungan_luar_negara" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="negara_limbungan">Negara <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="negara_limbungan" name="negara_limbungan">
        </div>
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="justifikasi_perolehan">Justifikasi Rayuan <span class="text-danger">*</span></label>
        <textarea class="form-control" id="justifikasi_perolehan" name="justifikasi_perolehan" rows="3"></textarea>
    </div>
</div>

<div id="section-tukar-peralatan" style="display:none;">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Tukar Jenis Peralatan</h6>
    <div class="form-group">
        <label class="font-weight-bold" for="no_permit_peralatan">No. Permit <span class="text-danger">*</span></label>
        <select class="form-control" id="no_permit_peralatan" name="no_permit_peralatan">
            <option value="" selected disabled>Pilih No. Permit</option>
            <option value="112341">112341</option>
            <option value="112342">112342</option>
            <option value="112343">112343</option>
            <option value="112344">112344</option>
            <option value="112345">112345</option>
        </select>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Bil</th>
                    <th>No. Permit</th>
                    <th>Jenis Peralatan Asal</th>
                    <th>Jenis Peralatan Baru</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td id="display_permit_no">-</td>
                    <td>
                        <select class="form-control" id="jenis_peralatan_asal" name="jenis_peralatan_asal">
                            <option value="" selected disabled>Pilih Jenis Peralatan Asal</option>
                            <option value="Pukat Hanyut">Pukat Hanyut</option>
                            <option value="Pukat Tunda">Pukat Tunda</option>
                            <option value="Rawai">Rawai</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" id="jenis_peralatan_baru" name="jenis_peralatan_baru">
                            <option value="" selected disabled>Pilih Jenis Peralatan Baru</option>
                            <option value="Pukat Hanyut">Pukat Hanyut</option>
                            <option value="Pukat Tunda">Pukat Tunda</option>
                            <option value="Rawai">Rawai</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="form-group">
        <label class="font-weight-bold" for="justifikasi_tukar_peralatan">Justifikasi Rayuan <span class="text-danger">*</span></label>
        <textarea class="form-control" id="justifikasi_tukar_peralatan" name="justifikasi_tukar_peralatan" rows="3"></textarea>
    </div>
</div>

<div id="section-tukar-nama-syarikat" style="display:none;">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Sijil Pendaftaran Perniagaan/Syarikat</h6>
    
    <div class="form-group">
        <label class="font-weight-bold" for="no_pendaftaran_perniagaan">No. Pendaftaran Perniagaan/Syarikat <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="no_pendaftaran_perniagaan" name="no_pendaftaran_perniagaan">
    </div>
    
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="font-weight-bold" for="tarikh_pendaftaran_syarikat">Tarikh Pendaftaran Syarikat <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="tarikh_pendaftaran_syarikat" name="tarikh_pendaftaran_syarikat">
        </div>
        <div class="form-group col-md-6">
            <label class="font-weight-bold" for="tarikh_luput_pendaftaran">Tarikh Luput Pendaftaran <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="tarikh_luput_pendaftaran" name="tarikh_luput_pendaftaran">
        </div>
    </div>
    
    <div class="form-group">
        <label class="font-weight-bold d-block">Status Perniagaan Semasa <span class="text-danger">*</span></label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status_perniagaan" id="status_aktif" value="Aktif">
            <label class="form-check-label" for="status_aktif">Aktif</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status_perniagaan" id="status_tidak_aktif" value="Tidak Aktif">
            <label class="form-check-label" for="status_tidak_aktif">Tidak Aktif</label>
        </div>
    </div>
    
    <div class="form-group">
        <label class="font-weight-bold" for="nama_syarikat_baru">Nama Syarikat Baru <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="nama_syarikat_baru" name="nama_syarikat_baru">
    </div>
    
    <div class="form-group">
        <label class="font-weight-bold" for="justifikasi_tukar_nama">Justifikasi Rayuan <span class="text-danger">*</span></label>
        <textarea class="form-control" id="justifikasi_tukar_nama" name="justifikasi_tukar_nama" rows="3"></textarea>
    </div>
</div>

<div id="section-pangkalan" style="display:none;">
<div class="form-group">
        <label class="font-weight-bold" for="pangkalan_asal">Pangkalan Asal <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="pangkalan_asal" name="pangkalan_asal">
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="pangkalan_baru">Pangkalan Baru <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="pangkalan_baru" name="pangkalan_baru">
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="justifikasi_pindaan">Justifikasi Rayuan <span class="text-danger">*</span></label>
        <textarea class="form-control" id="justifikasi_pindaan" name="justifikasi_pindaan" rows="3"></textarea>
    </div>
</div>

<!-- Navigation Button -->
<div class="text-center mt-4">
    <button type="button" class="btn btn-sm" style="background-color: #3c2387; color: #fff; border: 1px solid #3c2387; border-radius: 8px;" onclick="nextTab('dokumen-tab')">
        Teruskan <i class="fas fa-arrow-right ms-2" style="color: #fff;"></i>
    </button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectJenisPindaan = document.getElementById('jenis_pindaan_syarat');
    var sectionBahan = document.getElementById('section-bahan');
    var sectionPerolehan = document.getElementById('section-perolehan');
    var sectionPangkalan = document.getElementById('section-pangkalan');
    var sectionTukarPeralatan = document.getElementById('section-tukar-peralatan');
    var sectionTukarNamaSyarikat = document.getElementById('section-tukar-nama-syarikat');

    function showSection() {
        var value = selectJenisPindaan.value;
        sectionBahan.style.display = (value === 'Jenis bahan binaan vesel') ? '' : 'none';
        sectionPerolehan.style.display = (value === 'Jenis perolehan') ? '' : 'none';
        sectionPangkalan.style.display = (value === 'Pangkalan') ? '' : 'none';
        sectionTukarPeralatan.style.display = (value === 'Tukar Jenis Peralatan') ? '' : 'none';
        sectionTukarNamaSyarikat.style.display = (value === 'Tukar Nama Pendaftaran Syarikat') ? '' : 'none';
    }

    selectJenisPindaan.addEventListener('change', showSection);
    showSection();

    var selectJenisPerolehan = document.getElementById('jenis_perolehan');
    var binaBaruDiv = document.getElementById('perolehan-bina-baru');
    var terpakaiDiv = document.getElementById('perolehan-terpakai-tempatan');
    var binaBaruLuarNegaraDiv = document.getElementById('perolehan-bina-baru-luar-negara');
    

    function showPerolehanSubSection() {
        if (!selectJenisPerolehan) return;
        var value = selectJenisPerolehan.value;
        binaBaruDiv.style.display = (value === 'bina_baru_dalam_negara') ? '' : 'none';
        terpakaiDiv.style.display = (value === 'terpakai_tempatan' || value === 'terpakai_luar_negara') ? '' : 'none';
        binaBaruLuarNegaraDiv.style.display = (value === 'bina_baru_luar_negara') ? '' : 'none';
    }

    if (selectJenisPerolehan) {
        selectJenisPerolehan.addEventListener('change', showPerolehanSubSection);
        showPerolehanSubSection();
    }

    // Handle permit number selection for equipment change
    var selectNoPermit = document.getElementById('no_permit_peralatan');
    if (selectNoPermit) {
        selectNoPermit.addEventListener('change', function() {
            var displayPermitNo = document.getElementById('display_permit_no');
            if (displayPermitNo) {
                displayPermitNo.textContent = this.value;
            }
        });
    }

    // Handle limbungan selection for auto-filling fields
    var selectLimbungan = document.getElementById('nama_limbungan_baru');
    if (selectLimbungan) {
        selectLimbungan.addEventListener('change', function() {
            // Mock data for limbungan - in real implementation, this would come from database
            var limbunganData = {
                'Limbungan A': {
                    negeri: 'Selangor',
                    daerah: 'Klang',
                    alamat: 'Jalan Limbungan A, Taman Limbungan, 42000 Klang, Selangor',
                    poskod: '42000'
                },
                'Limbungan B': {
                    negeri: 'Johor',
                    daerah: 'Johor Bahru',
                    alamat: 'Jalan Limbungan B, Taman Limbungan, 80000 Johor Bahru, Johor',
                    poskod: '80000'
                },
                'Limbungan C': {
                    negeri: 'Pulau Pinang',
                    daerah: 'Georgetown',
                    alamat: 'Jalan Limbungan C, Taman Limbungan, 10000 Georgetown, Pulau Pinang',
                    poskod: '10000'
                },
                'Limbungan D': {
                    negeri: 'Sabah',
                    daerah: 'Kota Kinabalu',
                    alamat: 'Jalan Limbungan D, Taman Limbungan, 88000 Kota Kinabalu, Sabah',
                    poskod: '88000'
                }
            };

            var selectedLimbungan = this.value;
            if (limbunganData[selectedLimbungan]) {
                var data = limbunganData[selectedLimbungan];
                document.getElementById('negeri_limbungan_baru').value = data.negeri;
                document.getElementById('daerah_baru').value = data.daerah;
                document.getElementById('alamat_baru').value = data.alamat;
                document.getElementById('poskod_baru').value = data.poskod;
            } else {
                // Clear fields if no limbungan selected
                document.getElementById('negeri_limbungan_baru').value = '';
                document.getElementById('daerah_baru').value = '';
                document.getElementById('alamat_baru').value = '';
                document.getElementById('poskod_baru').value = '';
            }
        });
    }

    // Load existing draft data if available
    @if(isset($existingDraft) && $existingDraft)
        console.log('Loading existing draft data...');
        
        // Populate form fields with draft data - only if values exist and are not empty
        if ('{{ $existingDraft->jenis_pindaan_syarat }}' && '{{ $existingDraft->jenis_pindaan_syarat }}'.trim() !== '') {
            document.getElementById('jenis_pindaan_syarat').value = '{{ $existingDraft->jenis_pindaan_syarat }}';
        }
        if ('{{ $existingDraft->jenis_bahan_binaan_vesel }}') {
            document.getElementById('jenis_bahan_binaan_vesel').value = '{{ $existingDraft->jenis_bahan_binaan_vesel }}';
        }
        if ('{{ $existingDraft->nyatakan }}') {
            document.getElementById('nyatakan').value = '{{ $existingDraft->nyatakan }}';
        }
        if ('{{ $existingDraft->jenis_perolehan }}') {
            document.getElementById('jenis_perolehan').value = '{{ $existingDraft->jenis_perolehan }}';
        }
        if ('{{ $existingDraft->nama_limbungan_baru }}') {
            document.getElementById('nama_limbungan_baru').value = '{{ $existingDraft->nama_limbungan_baru }}';
        }
        if ('{{ $existingDraft->negeri_limbungan_baru }}') {
            document.getElementById('negeri_limbungan_baru').value = '{{ $existingDraft->negeri_limbungan_baru }}';
        }
        if ('{{ $existingDraft->daerah_baru }}') {
            document.getElementById('daerah_baru').value = '{{ $existingDraft->daerah_baru }}';
        }
        if ('{{ $existingDraft->alamat_baru }}') {
            document.getElementById('alamat_baru').value = '{{ $existingDraft->alamat_baru }}';
        }
        if ('{{ $existingDraft->poskod_baru }}') {
            document.getElementById('poskod_baru').value = '{{ $existingDraft->poskod_baru }}';
        }
        if ('{{ $existingDraft->pernah_berdaftar }}') {
            document.getElementById('pernah_berdaftar').value = '{{ $existingDraft->pernah_berdaftar }}';
        }
        if ('{{ $existingDraft->no_pendaftaran_vesel }}') {
            document.getElementById('no_pendaftaran_vesel').value = '{{ $existingDraft->no_pendaftaran_vesel }}';
        }
        if ('{{ $existingDraft->negeri_asal_vesel }}') {
            document.getElementById('negeri_asal_vesel').value = '{{ $existingDraft->negeri_asal_vesel }}';
        }
        if ('{{ $existingDraft->pelabuhan_pangkalan }}') {
            document.getElementById('pelabuhan_pangkalan').value = '{{ $existingDraft->pelabuhan_pangkalan }}';
        }
        if ('{{ $existingDraft->pangkalan_asal }}') {
            document.getElementById('pangkalan_asal').value = '{{ $existingDraft->pangkalan_asal }}';
        }
        if ('{{ $existingDraft->pangkalan_baru }}') {
            document.getElementById('pangkalan_baru').value = '{{ $existingDraft->pangkalan_baru }}';
        }
        if ('{{ $existingDraft->justifikasi_pindaan }}') {
            document.getElementById('justifikasi_pindaan').value = '{{ $existingDraft->justifikasi_pindaan }}';
        }
        if ('{{ $existingDraft->justifikasi_perolehan }}') {
            document.getElementById('justifikasi_perolehan').value = '{{ $existingDraft->justifikasi_perolehan }}';
        }
        
        // New fields for Vesel Bina Baru Luar Negara
        if ('{{ $existingDraft->alamat_limbungan_luar_negara }}') {
            document.getElementById('alamat_limbungan_luar_negara').value = '{{ $existingDraft->alamat_limbungan_luar_negara }}';
        }
        if ('{{ $existingDraft->negara_limbungan }}') {
            document.getElementById('negara_limbungan').value = '{{ $existingDraft->negara_limbungan }}';
        }
        
        // New fields for equipment change
        if ('{{ $existingDraft->no_permit_peralatan }}') {
            document.getElementById('no_permit_peralatan').value = '{{ $existingDraft->no_permit_peralatan }}';
        }
        if ('{{ $existingDraft->jenis_peralatan_asal }}') {
            document.getElementById('jenis_peralatan_asal').value = '{{ $existingDraft->jenis_peralatan_asal }}';
        }
        if ('{{ $existingDraft->jenis_peralatan_baru }}') {
            document.getElementById('jenis_peralatan_baru').value = '{{ $existingDraft->jenis_peralatan_baru }}';
        }
        if ('{{ $existingDraft->justifikasi_tukar_peralatan }}') {
            document.getElementById('justifikasi_tukar_peralatan').value = '{{ $existingDraft->justifikasi_tukar_peralatan }}';
        }
        
        // New fields for company name change
        if ('{{ $existingDraft->no_pendaftaran_perniagaan }}') {
            document.getElementById('no_pendaftaran_perniagaan').value = '{{ $existingDraft->no_pendaftaran_perniagaan }}';
        }
        if ('{{ $existingDraft->tarikh_pendaftaran_syarikat }}') {
            document.getElementById('tarikh_pendaftaran_syarikat').value = '{{ $existingDraft->tarikh_pendaftaran_syarikat }}';
        }
        if ('{{ $existingDraft->tarikh_luput_pendaftaran }}') {
            document.getElementById('tarikh_luput_pendaftaran').value = '{{ $existingDraft->tarikh_luput_pendaftaran }}';
        }
        if ('{{ $existingDraft->status_perniagaan }}') {
            document.getElementById('status_perniagaan').value = '{{ $existingDraft->status_perniagaan }}';
        }
        if ('{{ $existingDraft->nama_syarikat_baru }}') {
            document.getElementById('nama_syarikat_baru').value = '{{ $existingDraft->nama_syarikat_baru }}';
        }
        if ('{{ $existingDraft->justifikasi_tukar_nama }}') {
            document.getElementById('justifikasi_tukar_nama').value = '{{ $existingDraft->justifikasi_tukar_nama }}';
        }
        
        // IMPORTANT: Trigger change events to properly show appropriate sections
        // This ensures the form behaves as if the user actually made the selections
        console.log('Triggering change events for draft data...');
        
        // Trigger jenis pindaan syarat change event
        if (selectJenisPindaan && selectJenisPindaan.value) {
            selectJenisPindaan.dispatchEvent(new Event('change'));
            console.log('Triggered jenis_pindaan_syarat change event');
        }
        
        // Trigger jenis perolehan change event if applicable
        if (selectJenisPerolehan && selectJenisPerolehan.value) {
            selectJenisPerolehan.dispatchEvent(new Event('change'));
            console.log('Triggered jenis_perolehan change event');
        }
        
        // Trigger other change events
        if (selectNoPermit && selectNoPermit.value) {
            selectNoPermit.dispatchEvent(new Event('change'));
        }
        if (selectLimbungan && selectLimbungan.value) {
            selectLimbungan.dispatchEvent(new Event('change'));
        }
        
        // Trigger document section update
        if (typeof updateDocumentSectionVisibility === 'function' && selectJenisPindaan && selectJenisPindaan.value) {
            updateDocumentSectionVisibility(selectJenisPindaan.value);
            console.log('Updated document section visibility');
        }
        
        // IMPORTANT: Also handle kelulusan perolehan selection if it exists in draft
        // This ensures the permit selection section appears when it should
        const kelulusanSelect = document.getElementById('kelulusan_perolehan_id');
        if (kelulusanSelect && '{{ $existingDraft->kelulusan_perolehan_id }}' && '{{ $existingDraft->kelulusan_perolehan_id }}'.trim() !== '') {
            kelulusanSelect.value = '{{ $existingDraft->kelulusan_perolehan_id }}';
            // Trigger the change event to load permits
            kelulusanSelect.dispatchEvent(new Event('change'));
            console.log('Triggered kelulusan_perolehan_id change event');
        }
        
        console.log('Draft data loading completed');
    @endif
});
</script>
@endpush
 