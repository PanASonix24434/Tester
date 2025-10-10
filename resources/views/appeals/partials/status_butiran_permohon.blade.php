
{{-- Kelulusan Perolehan Selection --}}
<h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Kelulusan Perolehan</h6>
<div class="form-group">
    <label class="font-weight-bold" for="kelulusan_perolehan_id">Pilih No. Rujukan Permohonan</label>
    <select class="form-control" id="kelulusan_perolehan_id" name="kelulusan_perolehan_id" disabled>
        @if($perakuan && $perakuan->kelulusan_perolehan_id)
            @php
                $kelulusan = \App\Models\KelulusanPerolehan::find($perakuan->kelulusan_perolehan_id);
            @endphp
            @if($kelulusan)
                <option value="{{ $kelulusan->id }}" selected>
                    {{ $kelulusan->no_rujukan }} - {{ $kelulusan->jenis_permohonan === 'kvp07' ? 'Rayuan Pindaan Syarat' : 'Lanjut Tempoh' }}
                </option>
            @else
                <option value="" selected disabled>Pilih Kelulusan Perolehan</option>
            @endif
        @else
            <option value="" selected disabled>Pilih Kelulusan Perolehan</option>
        @endif
    </select>
</div>

{{-- Permit Selection Section --}}
@if($perakuan && $perakuan->selected_permits)
    <div id="permit-selection-section" style="display:block;">
        <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Pilih Permit</h6>
        <div id="permit-checkboxes">
            @php
                $selectedPermits = json_decode($perakuan->selected_permits, true) ?? [];
            @endphp
            @if(!empty($selectedPermits))
                @foreach($selectedPermits as $permitId)
                    @php
                        $permit = \App\Models\Permit::find($permitId);
                    @endphp
                    @if($permit)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" checked disabled>
                            <label class="form-check-label">
                                <strong>{{ $permit->no_permit }}</strong> - {{ $permit->jenis_peralatan }}
                                <span class="badge bg-{{ $permit->status === 'ada_kemajuan' ? 'success' : 'warning' }}">
                                    {{ $permit->status === 'ada_kemajuan' ? 'Ada kemajuan' : 'Tiada kemajuan' }}
                                </span>
                            </label>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endif

<h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Pindaan Syarat</h6>
<div class="form-group">
    <label class="font-weight-bold" for="jenis_pindaan_syarat">Jenis Pindaan Syarat</label>
    <select class="form-control" id="jenis_pindaan_syarat" name="jenis_pindaan_syarat" disabled>
        <option value="" {{ !$perakuan || !$perakuan->jenis_pindaan_syarat ? 'selected' : '' }} disabled>Pilih Jenis Pindaan Syarat</option>
        <option value="Jenis bahan binaan vesel" {{ $perakuan && $perakuan->jenis_pindaan_syarat === 'Jenis bahan binaan vesel' ? 'selected' : '' }}>Jenis Bahan Binaan Vesel</option>
        <option value="Jenis perolehan" {{ $perakuan && $perakuan->jenis_pindaan_syarat === 'Jenis perolehan' ? 'selected' : '' }}>Jenis Perolehan</option>
        <option value="Pangkalan" {{ $perakuan && $perakuan->jenis_pindaan_syarat === 'Pangkalan' ? 'selected' : '' }}>Pangkalan</option>
        <option value="Tukar Jenis Peralatan" {{ $perakuan && $perakuan->jenis_pindaan_syarat === 'Tukar Jenis Peralatan' ? 'selected' : '' }}>Tukar Jenis Peralatan</option>
        <option value="Tukar Nama Pendaftaran Syarikat" {{ $perakuan && $perakuan->jenis_pindaan_syarat === 'Tukar Nama Pendaftaran Syarikat' ? 'selected' : '' }}>Tukar Nama Pendaftaran Syarikat</option>
    </select>
</div>


{{-- Section Bahan Binaan Vesel --}}
@if($perakuan && ($perakuan->jenis_pindaan_syarat === 'Jenis bahan binaan vesel' || $perakuan->jenis_bahan_binaan_vesel || $perakuan->nyatakan))
<div id="section-bahan" style="display:block;">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Jenis Bahan Binaan Vesel</h6>
    <div class="form-group">
        <label class="font-weight-bold" for="jenis_bahan_binaan_vesel">Jenis Bahan Binaan Vesel</label>
        <select class="form-control" id="jenis_bahan_binaan_vesel" name="jenis_bahan_binaan_vesel" disabled>
            <option value="" {{ !$perakuan || !$perakuan->jenis_bahan_binaan_vesel ? 'selected' : '' }} disabled>Pilih Jenis Bahan Binaan Vesel</option>
            <option value="Kayu" {{ $perakuan && $perakuan->jenis_bahan_binaan_vesel === 'Kayu' ? 'selected' : '' }}>Kayu</option>
            <option value="Gentian Kaca (Fiber)" {{ $perakuan && $perakuan->jenis_bahan_binaan_vesel === 'Gentian Kaca (Fiber)' ? 'selected' : '' }}>Gentian Kaca (Fiber)</option>
            <option value="Besi" {{ $perakuan && $perakuan->jenis_bahan_binaan_vesel === 'Besi' ? 'selected' : '' }}>Besi</option>
        </select>
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="nyatakan">Justifikasi Rayuan</label>
        <input type="text" class="form-control" id="nyatakan" name="nyatakan" value="{{ $perakuan->nyatakan ?? '' }}" readonly>
    </div>
</div>
@endif

{{-- Section Perolehan --}}
@if($perakuan && ($perakuan->jenis_pindaan_syarat === 'Jenis perolehan' || $perakuan->jenis_perolehan || $perakuan->nama_limbungan_baru || $perakuan->pernah_berdaftar || $perakuan->alamat_limbungan_luar_negara || $perakuan->justifikasi_perolehan))
<div id="section-perolehan" style="display:block;">
    <div class="form-group">
        <label class="font-weight-bold" for="jenis_perolehan">Jenis Perolehan</label>
        <select class="form-control" id="jenis_perolehan" name="jenis_perolehan" disabled>
            <option value="" {{ !$perakuan || !$perakuan->jenis_perolehan ? 'selected' : '' }} disabled>Pilih Jenis Perolehan</option>
            <option value="bina_baru_dalam_negara" {{ $perakuan && $perakuan->jenis_perolehan === 'bina_baru_dalam_negara' ? 'selected' : '' }}>Vesel Bina Baru Dalam Negara</option>
            <option value="bina_baru_luar_negara" {{ $perakuan && $perakuan->jenis_perolehan === 'bina_baru_luar_negara' ? 'selected' : '' }}>Vesel Bina Baru Luar Negara</option>
            <option value="terpakai_tempatan" {{ $perakuan && $perakuan->jenis_perolehan === 'terpakai_tempatan' ? 'selected' : '' }}>Vesel Terpakai Tempatan</option>
            <option value="terpakai_luar_negara" {{ $perakuan && $perakuan->jenis_perolehan === 'terpakai_luar_negara' ? 'selected' : '' }}>Vesel Terpakai Luar Negara</option>
        </select>
    </div>
    
    {{-- Vesel Bina Baru Dalam Negara --}}
    @if($perakuan && $perakuan->jenis_perolehan === 'bina_baru_dalam_negara')
    <div id="perolehan-bina-baru" style="display:block;">
        <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Vesel Bina Baru</h6>
        <div class="form-group">
            <label class="font-weight-bold" for="nama_limbungan_baru">Nama Limbungan</label>
            <select class="form-control" id="nama_limbungan_baru" name="nama_limbungan_baru" disabled>
                <option value="" {{ !$perakuan || !$perakuan->nama_limbungan_baru ? 'selected' : '' }} disabled>Pilih Nama Limbungan</option>
                <option value="Limbungan A" {{ $perakuan && $perakuan->nama_limbungan_baru === 'Limbungan A' ? 'selected' : '' }}>Limbungan A</option>
                <option value="Limbungan B" {{ $perakuan && $perakuan->nama_limbungan_baru === 'Limbungan B' ? 'selected' : '' }}>Limbungan B</option>
                <option value="Limbungan C" {{ $perakuan && $perakuan->nama_limbungan_baru === 'Limbungan C' ? 'selected' : '' }}>Limbungan C</option>
                <option value="Limbungan D" {{ $perakuan && $perakuan->nama_limbungan_baru === 'Limbungan D' ? 'selected' : '' }}>Limbungan D</option>
            </select>
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="negeri_limbungan_baru">Negeri Limbungan</label>
            <input type="text" class="form-control" id="negeri_limbungan_baru" name="negeri_limbungan_baru" value="{{ $perakuan->negeri_limbungan_baru ?? '' }}" readonly>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold" for="daerah_baru">Daerah</label>
                <input type="text" class="form-control" id="daerah_baru" name="daerah_baru" value="{{ $perakuan->daerah_baru ?? '' }}" readonly>
            </div>
            <div class="form-group col-md-6">
                <label class="font-weight-bold" for="alamat_baru">Alamat Limbungan</label>
                <textarea class="form-control" id="alamat_baru" name="alamat_baru" rows="3" readonly>{{ $perakuan->alamat_baru ?? '' }}</textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold" for="poskod_baru">Poskod</label>
                <input type="text" class="form-control" id="poskod_baru" name="poskod_baru" value="{{ $perakuan->poskod_baru ?? '' }}" readonly>
            </div>
        </div>
    </div>
    @endif
    
    {{-- Vesel Terpakai --}}
    @if($perakuan && in_array($perakuan->jenis_perolehan, ['terpakai_tempatan', 'terpakai_luar_negara']))
    <div id="perolehan-terpakai-tempatan" style="display:block;">
        <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Vesel Terpakai</h6>
        <div class="form-group">
            <label class="font-weight-bold d-block">Vesel Pernah Berdaftar Dengan Jabatan Perikanan Malaysia/Jabatan Laut Malaysia?</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pernah_berdaftar" id="berdaftar_ya" value="ya" {{ $perakuan && $perakuan->pernah_berdaftar === 'ya' ? 'checked' : '' }} disabled>
                <label class="form-check-label" for="berdaftar_ya">Ya</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pernah_berdaftar" id="berdaftar_tidak" value="tidak" {{ $perakuan && $perakuan->pernah_berdaftar === 'tidak' ? 'checked' : '' }} disabled>
                <label class="form-check-label" for="berdaftar_tidak">Tidak</label>
            </div>
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="no_pendaftaran_vesel">No Tetap Vesel/No. Pendaftaran Vesel</label>
            <input type="text" class="form-control" id="no_pendaftaran_vesel" name="no_pendaftaran_vesel" value="{{ $perakuan->no_pendaftaran_vesel ?? '' }}" readonly>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="font-weight-bold" for="negeri_asal_vesel">Negeri Asal Vesel Didafarkan</label>
                <input type="text" class="form-control" id="negeri_asal_vesel" name="negeri_asal_vesel" value="{{ $perakuan->negeri_asal_vesel ?? '' }}" readonly>
            </div>
            <div class="form-group col-md-6">
                <label class="font-weight-bold" for="pelabuhan_pangkalan">Pelabuhan/Pangkalan</label>
                <input type="text" class="form-control" id="pelabuhan_pangkalan" name="pelabuhan_pangkalan" value="{{ $perakuan->pelabuhan_pangkalan ?? '' }}" readonly>
            </div>
        </div>
    </div>
    @endif
    
    {{-- Vesel Bina Baru Luar Negara --}}
    @if($perakuan && $perakuan->jenis_perolehan === 'bina_baru_luar_negara')
    <div id="perolehan-bina-baru-luar-negara" style="display:block;">
        <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Vesel Bina Baru Luar Negara</h6>
        <div class="form-group">
            <label class="font-weight-bold" for="alamat_limbungan_luar_negara">Alamat Limbungan</label>
            <textarea class="form-control" id="alamat_limbungan_luar_negara" name="alamat_limbungan_luar_negara" rows="3" readonly>{{ $perakuan->alamat_limbungan_luar_negara ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="negara_limbungan">Negara</label>
            <input type="text" class="form-control" id="negara_limbungan" name="negara_limbungan" value="{{ $perakuan->negara_limbungan ?? '' }}" readonly>
        </div>
    </div>
    @endif
    
    <div class="form-group">
        <label class="font-weight-bold" for="justifikasi_perolehan">Justifikasi Rayuan</label>
        <textarea class="form-control" id="justifikasi_perolehan" name="justifikasi_perolehan" rows="3" readonly>{{ $perakuan->justifikasi_perolehan ?? '' }}</textarea>
    </div>
</div>
@endif

{{-- Section Tukar Peralatan --}}
@if($perakuan && ($perakuan->jenis_pindaan_syarat === 'Tukar Jenis Peralatan' || $perakuan->no_permit_peralatan || $perakuan->jenis_peralatan_asal || $perakuan->jenis_peralatan_baru || $perakuan->justifikasi_tukar_peralatan))
<div id="section-tukar-peralatan" style="display:block;">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Tukar Jenis Peralatan</h6>
    <div class="form-group">
        <label class="font-weight-bold" for="no_permit_peralatan">No. Permit</label>
        <select class="form-control" id="no_permit_peralatan" name="no_permit_peralatan" disabled>
            <option value="" {{ !$perakuan || !$perakuan->no_permit_peralatan ? 'selected' : '' }} disabled>Pilih No. Permit</option>
            <option value="112341" {{ $perakuan && $perakuan->no_permit_peralatan === '112341' ? 'selected' : '' }}>112341</option>
            <option value="112342" {{ $perakuan && $perakuan->no_permit_peralatan === '112342' ? 'selected' : '' }}>112342</option>
            <option value="112343" {{ $perakuan && $perakuan->no_permit_peralatan === '112343' ? 'selected' : '' }}>112343</option>
            <option value="112344" {{ $perakuan && $perakuan->no_permit_peralatan === '112344' ? 'selected' : '' }}>112344</option>
            <option value="112345" {{ $perakuan && $perakuan->no_permit_peralatan === '112345' ? 'selected' : '' }}>112345</option>
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
                    <td id="display_permit_no">{{ $perakuan->no_permit_peralatan ?? '-' }}</td>
                    <td>
                        <select class="form-control" id="jenis_peralatan_asal" name="jenis_peralatan_asal" disabled>
                            <option value="" {{ !$perakuan || !$perakuan->jenis_peralatan_asal ? 'selected' : '' }} disabled>Pilih Jenis Peralatan Asal</option>
                            <option value="Pukat Hanyut" {{ $perakuan && $perakuan->jenis_peralatan_asal === 'Pukat Hanyut' ? 'selected' : '' }}>Pukat Hanyut</option>
                            <option value="Pukat Tunda" {{ $perakuan && $perakuan->jenis_peralatan_asal === 'Pukat Tunda' ? 'selected' : '' }}>Pukat Tunda</option>
                            <option value="Rawai" {{ $perakuan && $perakuan->jenis_peralatan_asal === 'Rawai' ? 'selected' : '' }}>Rawai</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" id="jenis_peralatan_baru" name="jenis_peralatan_baru" disabled>
                            <option value="" {{ !$perakuan || !$perakuan->jenis_peralatan_baru ? 'selected' : '' }} disabled>Pilih Jenis Peralatan Baru</option>
                            <option value="Pukat Hanyut" {{ $perakuan && $perakuan->jenis_peralatan_baru === 'Pukat Hanyut' ? 'selected' : '' }}>Pukat Hanyut</option>
                            <option value="Pukat Tunda" {{ $perakuan && $perakuan->jenis_peralatan_baru === 'Pukat Tunda' ? 'selected' : '' }}>Pukat Tunda</option>
                            <option value="Rawai" {{ $perakuan && $perakuan->jenis_peralatan_baru === 'Rawai' ? 'selected' : '' }}>Rawai</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="form-group">
        <label class="font-weight-bold" for="justifikasi_tukar_peralatan">Justifikasi Rayuan</label>
        <textarea class="form-control" id="justifikasi_tukar_peralatan" name="justifikasi_tukar_peralatan" rows="3" readonly>{{ $perakuan->justifikasi_tukar_peralatan ?? '' }}</textarea>
    </div>
</div>
@endif

{{-- Section Tukar Nama Syarikat --}}
@if($perakuan && ($perakuan->jenis_pindaan_syarat === 'Tukar Nama Pendaftaran Syarikat' || $perakuan->no_pendaftaran_perniagaan || $perakuan->nama_syarikat_baru || $perakuan->justifikasi_tukar_nama))
<div id="section-tukar-nama-syarikat" style="display:block;">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Sijil Pendaftaran Perniagaan/Syarikat</h6>
    
    <div class="form-group">
        <label class="font-weight-bold" for="no_pendaftaran_perniagaan">No. Pendaftaran Perniagaan/Syarikat</label>
        <input type="text" class="form-control" id="no_pendaftaran_perniagaan" name="no_pendaftaran_perniagaan" value="{{ $perakuan->no_pendaftaran_perniagaan ?? '' }}" readonly>
    </div>
    
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="font-weight-bold" for="tarikh_pendaftaran_syarikat">Tarikh Pendaftaran Syarikat</label>
            <input type="date" class="form-control" id="tarikh_pendaftaran_syarikat" name="tarikh_pendaftaran_syarikat" value="{{ $perakuan->tarikh_pendaftaran_syarikat ?? '' }}" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="font-weight-bold" for="tarikh_luput_pendaftaran">Tarikh Luput Pendaftaran</label>
            <input type="date" class="form-control" id="tarikh_luput_pendaftaran" name="tarikh_luput_pendaftaran" value="{{ $perakuan->tarikh_luput_pendaftaran ?? '' }}" readonly>
        </div>
    </div>
    
    <div class="form-group">
        <label class="font-weight-bold d-block">Status Perniagaan Semasa</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status_perniagaan" id="status_aktif" value="Aktif" {{ $perakuan && $perakuan->status_perniagaan === 'Aktif' ? 'checked' : '' }} disabled>
            <label class="form-check-label" for="status_aktif">Aktif</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status_perniagaan" id="status_tidak_aktif" value="Tidak Aktif" {{ $perakuan && $perakuan->status_perniagaan === 'Tidak Aktif' ? 'checked' : '' }} disabled>
            <label class="form-check-label" for="status_tidak_aktif">Tidak Aktif</label>
        </div>
    </div>
    
    <div class="form-group">
        <label class="font-weight-bold" for="nama_syarikat_baru">Nama Syarikat Baru</label>
        <input type="text" class="form-control" id="nama_syarikat_baru" name="nama_syarikat_baru" value="{{ $perakuan->nama_syarikat_baru ?? '' }}" readonly>
    </div>
    
    <div class="form-group">
        <label class="font-weight-bold" for="justifikasi_tukar_nama">Justifikasi Rayuan</label>
        <textarea class="form-control" id="justifikasi_tukar_nama" name="justifikasi_tukar_nama" rows="3" readonly>{{ $perakuan->justifikasi_tukar_nama ?? '' }}</textarea>
    </div>
</div>
@endif

{{-- Section Pangkalan --}}
@if($perakuan && ($perakuan->jenis_pindaan_syarat === 'Pangkalan' || $perakuan->pangkalan_asal || $perakuan->pangkalan_baru || $perakuan->justifikasi_pindaan))
<div id="section-pangkalan" style="display:block;">
    <div class="form-group">
        <label class="font-weight-bold" for="pangkalan_asal">Pangkalan Asal</label>
        <input type="text" class="form-control" id="pangkalan_asal" name="pangkalan_asal" value="{{ $perakuan->pangkalan_asal ?? '' }}" readonly>
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="pangkalan_baru">Pangkalan Baru</label>
        <input type="text" class="form-control" id="pangkalan_baru" name="pangkalan_baru" value="{{ $perakuan->pangkalan_baru ?? '' }}" readonly>
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="justifikasi_pindaan">Justifikasi Rayuan</label>
        <textarea class="form-control" id="justifikasi_pindaan" name="justifikasi_pindaan" rows="3" readonly>{{ $perakuan->justifikasi_pindaan ?? '' }}</textarea>
    </div>
</div>
@endif

{{-- Summary of All Submitted Data --}}
@if($perakuan)
<div class="mt-4">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Ringkasan Data Yang Dihantar</h6>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @if($perakuan->jenis_pindaan_syarat)
                    <tr><td>Jenis Pindaan Syarat</td><td>{{ $perakuan->jenis_pindaan_syarat }}</td></tr>
                @endif
                @if($perakuan->jenis_bahan_binaan_vesel)
                    <tr><td>Jenis Bahan Binaan Vesel</td><td>{{ $perakuan->jenis_bahan_binaan_vesel }}</td></tr>
                @endif
                @if($perakuan->nyatakan)
                    <tr><td>Justifikasi Bahan Binaan</td><td>{{ $perakuan->nyatakan }}</td></tr>
                @endif
                @if($perakuan->jenis_perolehan)
                    <tr><td>Jenis Perolehan</td><td>{{ $perakuan->jenis_perolehan }}</td></tr>
                @endif
                @if($perakuan->nama_limbungan_baru)
                    <tr><td>Nama Limbungan Baru</td><td>{{ $perakuan->nama_limbungan_baru }}</td></tr>
                @endif
                @if($perakuan->negeri_limbungan_baru)
                    <tr><td>Negeri Limbungan Baru</td><td>{{ $perakuan->negeri_limbungan_baru }}</td></tr>
                @endif
                @if($perakuan->daerah_baru)
                    <tr><td>Daerah Baru</td><td>{{ $perakuan->daerah_baru }}</td></tr>
                @endif
                @if($perakuan->alamat_baru)
                    <tr><td>Alamat Baru</td><td>{{ $perakuan->alamat_baru }}</td></tr>
                @endif
                @if($perakuan->poskod_baru)
                    <tr><td>Poskod Baru</td><td>{{ $perakuan->poskod_baru }}</td></tr>
                @endif
                @if($perakuan->pernah_berdaftar)
                    <tr><td>Pernah Berdaftar</td><td>{{ $perakuan->pernah_berdaftar }}</td></tr>
                @endif
                @if($perakuan->no_pendaftaran_vesel)
                    <tr><td>No Pendaftaran Vesel</td><td>{{ $perakuan->no_pendaftaran_vesel }}</td></tr>
                @endif
                @if($perakuan->negeri_asal_vesel)
                    <tr><td>Negeri Asal Vesel</td><td>{{ $perakuan->negeri_asal_vesel }}</td></tr>
                @endif
                @if($perakuan->pelabuhan_pangkalan)
                    <tr><td>Pelabuhan/Pangkalan</td><td>{{ $perakuan->pelabuhan_pangkalan }}</td></tr>
                @endif
                @if($perakuan->alamat_limbungan_luar_negara)
                    <tr><td>Alamat Limbungan Luar Negara</td><td>{{ $perakuan->alamat_limbungan_luar_negara }}</td></tr>
                @endif
                @if($perakuan->negara_limbungan)
                    <tr><td>Negara Limbungan</td><td>{{ $perakuan->negara_limbungan }}</td></tr>
                @endif
                @if($perakuan->justifikasi_perolehan)
                    <tr><td>Justifikasi Perolehan</td><td>{{ $perakuan->justifikasi_perolehan }}</td></tr>
                @endif
                @if($perakuan->no_permit_peralatan)
                    <tr><td>No Permit Peralatan</td><td>{{ $perakuan->no_permit_peralatan }}</td></tr>
                @endif
                @if($perakuan->jenis_peralatan_asal)
                    <tr><td>Jenis Peralatan Asal</td><td>{{ $perakuan->jenis_peralatan_asal }}</td></tr>
                @endif
                @if($perakuan->jenis_peralatan_baru)
                    <tr><td>Jenis Peralatan Baru</td><td>{{ $perakuan->jenis_peralatan_baru }}</td></tr>
                @endif
                @if($perakuan->justifikasi_tukar_peralatan)
                    <tr><td>Justifikasi Tukar Peralatan</td><td>{{ $perakuan->justifikasi_tukar_peralatan }}</td></tr>
                @endif
                @if($perakuan->no_pendaftaran_perniagaan)
                    <tr><td>No Pendaftaran Perniagaan</td><td>{{ $perakuan->no_pendaftaran_perniagaan }}</td></tr>
                @endif
                @if($perakuan->tarikh_pendaftaran_syarikat)
                    <tr><td>Tarikh Pendaftaran Syarikat</td><td>{{ $perakuan->tarikh_pendaftaran_syarikat }}</td></tr>
                @endif
                @if($perakuan->tarikh_luput_pendaftaran)
                    <tr><td>Tarikh Luput Pendaftaran</td><td>{{ $perakuan->tarikh_luput_pendaftaran }}</td></tr>
                @endif
                @if($perakuan->status_perniagaan)
                    <tr><td>Status Perniagaan</td><td>{{ $perakuan->status_perniagaan }}</td></tr>
                @endif
                @if($perakuan->nama_syarikat_baru)
                    <tr><td>Nama Syarikat Baru</td><td>{{ $perakuan->nama_syarikat_baru }}</td></tr>
                @endif
                @if($perakuan->justifikasi_tukar_nama)
                    <tr><td>Justifikasi Tukar Nama</td><td>{{ $perakuan->justifikasi_tukar_nama }}</td></tr>
                @endif
                @if($perakuan->pangkalan_asal)
                    <tr><td>Pangkalan Asal</td><td>{{ $perakuan->pangkalan_asal }}</td></tr>
                @endif
                @if($perakuan->pangkalan_baru)
                    <tr><td>Pangkalan Baru</td><td>{{ $perakuan->pangkalan_baru }}</td></tr>
                @endif
                @if($perakuan->justifikasi_pindaan)
                    <tr><td>Justifikasi Pindaan</td><td>{{ $perakuan->justifikasi_pindaan }}</td></tr>
                @endif
                @if($perakuan->justifikasi_pindaan)
                    <tr><td>Justifikasi Pindaan (Perakuan)</td><td>{{ $perakuan->justifikasi_pindaan }}</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Justifikasi Pindaan Section --}}
@if($perakuan && $perakuan->justifikasi_pindaan)
<div class="mt-4">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Justifikasi Pindaan</h6>
    <div class="form-group">
        <label class="font-weight-bold" for="justifikasi_pindaan">Justifikasi Pindaan</label>
        <textarea class="form-control" id="justifikasi_pindaan" name="justifikasi_pindaan" rows="4" readonly>{{ $perakuan->justifikasi_pindaan }}</textarea>
    </div>
</div>
@endif

<!-- Navigation Button -->
<div class="text-center mt-4">
    <button type="button" class="btn btn-sm" style="background-color: #3c2387; color: #fff; border: 1px solid #3c2387; border-radius: 8px;" onclick="nextTab('dokumen-status-tab')">
        Seterusnya <i class="fas fa-arrow-right ms-2" style="color: #fff;"></i>
    </button>
</div>
