@extends('layouts.app')
@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header text-white fw-semibold rounded-top" style="background-color: #007bff;">
                            Semakan Permohonan - KCL
                        </div>
                        
                        <div class="card-body">
                            @php
                                $statusLabels = [
                                    'ppl_incomplete' => 'Dalam Semakan PPL',
                                    'ppl_review'     => 'Dalam Semakan PPL',
                                    'kcl_incomplete' => 'Dalam Semakan KCL',
                                    'kcl_review'     => 'Dalam Semakan KCL',
                                    'pk_incomplete'  => 'Dalam Semakan PK',
                                    'pk_review'      => 'Dalam Semakan PK',
                                    'kpp_decision'   => 'Menunggu Keputusan KPP',
                                    'approved'       => 'Diluluskan',
                                    'rejected'       => 'Ditolak',
                                    // Add more as needed
                                ];
                                $status = $appeal->status ?? 'unknown';
                            @endphp
                            <!-- Maklumat Pemohon -->
                            <div class="card border-0 shadow-sm rounded-3 mb-4">
                                <div class="card-body" style="color: #1a1a1a;">
                                    <h5 class="mb-2 fw-bold" style="color: #1a1a1a;">Maklumat Pemohon</h5>
                            <div class="table-responsive mb-4">
                                        <table class="table table-bordered bg-white" style="color: #1a1a1a;">
                                    <tr>
                                        <th width="200">Nama Pemohon:</th>
                                        <td>{{ $applicant->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. IC:</th>
                                        <td>{{ $applicant->username ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Permohonan:</th>
                                        <td>
                                                    <span class="badge bg-info text-white">
                                                {{ $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- Butiran Permohonan Pemohon -->
                                    <h5 class="mb-2 fw-bold" style="color: #1a1a1a;">Butiran Permohonan Pemohon</h5>
                            <div class="table-responsive mb-4">
                                        <table class="table table-bordered bg-white" style="color: #1a1a1a;">
                                    @php
                                        $allFields = [
                                            'jenis_pindaan_syarat' => 'Jenis Pindaan Syarat',
                                            'jenis_bahan_binaan_vesel' => 'Jenis Bahan Binaan Vesel',
                                            'nyatakan' => 'Nyaatakan',
                                            'jenis_perolehan' => 'Jenis Perolehan',
                                            'negeri_limbungan_baru' => 'Negeri Limbungan Baru',
                                            'nama_limbungan_baru' => 'Nama Limbungan Baru',
                                            'daerah_baru' => 'Daerah Baru',
                                            'alamat_baru' => 'Alamat Baru',
                                            'poskod_baru' => 'Poskod Baru',
                                            'pernah_berdaftar' => 'Pernah Berdaftar',
                                            'no_pendaftaran_vesel' => 'No Pendaftaran Vesel',
                                            'negeri_asal_vesel' => 'Negeri Asal Vesel',
                                            'pelabuhan_pangkalan' => 'Pelabuhan Pangkalan',
                                            'pangkalan_asal' => 'Pangkalan Asal',
                                            'pangkalan_baru' => 'Pangkalan Baru',
                                            'justifikasi_pindaan' => 'Justifikasi Pindaan'
                                        ];
                                    @endphp
                                            @php $hasField = false; @endphp
                                    @foreach($allFields as $field => $label)
                                        @if(!empty($perakuan->$field))
                                                    @php $hasField = true; @endphp
                                        <tr>
                                            <th width="200">{{ $label }}:</th>
                                            <td>{{ $perakuan->$field }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                            @if(!$hasField)
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted">Tiada maklumat</td>
                                                </tr>
                                            @endif
                                </table>
                            </div>
                            
                            <!-- Tab Navigation -->
                            <div class="card border-0 shadow-sm rounded-3 mb-4">
                                <div class="card-body">
                                    <ul class="nav nav-tabs mb-4" id="kclTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="dokumen-wajib-tab" data-bs-toggle="tab" data-bs-target="#dokumen-wajib" type="button" role="tab" aria-controls="dokumen-wajib" aria-selected="true">Dokumen Wajib</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="dokumen-sokongan-tab" data-bs-toggle="tab" data-bs-target="#dokumen-sokongan" type="button" role="tab" aria-controls="dokumen-sokongan" aria-selected="false">Dokumen Sokongan</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="dokumen-tambahan-tab" data-bs-toggle="tab" data-bs-target="#dokumen-tambahan" type="button" role="tab" aria-controls="dokumen-tambahan" aria-selected="false">Dokumen Tambahan</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="kclTabContent">
                                        <!-- Dokumen Wajib Tab -->
                                        <div class="tab-pane fade show active" id="dokumen-wajib" role="tabpanel" aria-labelledby="dokumen-wajib-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Dokumen Wajib</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered bg-white" style="color: #1a1a1a;">
                                                    @php
                                                        $wajibDocs = [
                                                            'kertas_kerja_bina_baru_path' => 'Kertas Kerja (Bina Baru Dalam Negara)',
                                                            'kertas_kerja_bina_baru_luar_negara_path' => 'Kertas Kerja (Bina Baru Luar Negara)',
                                                            'surat_jual_beli_terpakai_path' => 'Surat Jual Beli Vesel Terpakai',
                                                            'lesen_skl_terpakai_path' => 'Salinan Lesen SKL (Terpakai)',
                                                            'lesen_skl_bina_baru_path' => 'Salinan Lesen SKL (Bina Baru)',
                                                            'borang_e_kaedah_13_path' => 'Borang E - Kaedah 13',
                                                            'profil_perniagaan_enterprise_path' => 'Salinan Profil Perniagaan',
                                                            'form_9_path' => 'Form 9',
                                                            'form_24_path' => 'Form 24',
                                                            'form_44_path' => 'Form 44',
                                                            'form_49_path' => 'Form 49',
                                                            'pendaftaran_persatuan_path' => 'Pendaftaran Persatuan',
                                                            'profil_persatuan_path' => 'Profil Persatuan',
                                                            'pendaftaran_koperasi_path' => 'Pendaftaran Koperasi',
                                                            'profil_koperasi_path' => 'Profil Koperasi'
                                                        ];
                                                    @endphp
                                                    @php $hasWajibDoc = false; @endphp
                                                    @foreach($wajibDocs as $doc => $label)
                                                        @if(!empty($perakuan->$doc))
                                                            @php $hasWajibDoc = true; @endphp
                                                            <tr>
                                                                <th width="200">{{ $label }}:</th>
                                                                <td>
                                                                    <a href="{{ asset('storage/' . $perakuan->$doc) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                        <i class="fas fa-eye me-1"></i>Lihat Dokumen
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    @if(!$hasWajibDoc)
                                                        <tr>
                                                            <td colspan="2" class="text-center text-muted">Tiada dokumen wajib dijumpai</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Dokumen Sokongan Tab -->
                                        <div class="tab-pane fade" id="dokumen-sokongan" role="tabpanel" aria-labelledby="dokumen-sokongan-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Dokumen Sokongan</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered bg-white" style="color: #1a1a1a;">
                                                    @if($dokumenSokongan && $dokumenSokongan->count() > 0)
                                                        @foreach($dokumenSokongan as $dokumen)
                                                            <tr>
                                                                <th width="200">{{ ucfirst(str_replace('_', ' ', $dokumen->file_type)) }}:</th>
                                                                <td>
                                                                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                        <i class="fas fa-eye me-1"></i>Lihat Dokumen
                                                                    </a>
                                                                    <small class="text-muted ms-2">{{ $dokumen->file_name }}</small>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="2" class="text-center text-muted">Tiada dokumen sokongan dijumpai</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Dokumen Tambahan Tab -->
                                        <div class="tab-pane fade" id="dokumen-tambahan" role="tabpanel" aria-labelledby="dokumen-tambahan-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Dokumen Tambahan</h5>
                                            <div class="table-responsive">
                                        <table class="table table-bordered bg-white" style="color: #1a1a1a;">
                                    @php
                                                        $tambahanDocs = [
                                            'akuan_sumpah_bina_baru_path' => 'Akuan Sumpah (Bina Baru)',
                                                            'surat_kelulusan_kpp_path' => 'Surat Kelulusan KPP'
                                        ];
                                    @endphp
                                                    @php $hasTambahanDoc = false; @endphp
                                                    @foreach($tambahanDocs as $doc => $label)
                                        @if(!empty($perakuan->$doc))
                                                            @php $hasTambahanDoc = true; @endphp
                                        <tr>
                                            <th width="200">{{ $label }}:</th>
                                            <td>
                                                                    <a href="{{ asset('storage/' . $perakuan->$doc) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                        <i class="fas fa-eye me-1"></i>Lihat Dokumen
                                                                    </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                                    @if(!$hasTambahanDoc)
                                                <tr>
                                                            <td colspan="2" class="text-center text-muted">Tiada dokumen tambahan dijumpai</td>
                                                </tr>
                                            @endif
                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Review Form -->
                            <div class="card border-0 shadow-sm rounded-3 mt-4">
                                <div class="card-body bg-white">
                                    <h6 class="fw-bold mb-0" style="color: #1976d2;">Sokongan Permohonan</h6>
                                    <div style="border-bottom: 3px solid #1976d2; margin-bottom: 24px; margin-top: 2px;"></div>
                                    <form method="POST" action="{{ route('appeals.kcl_submit', $appeal->id) }}" id="kclReviewForm">
                                        @csrf
                                        <div class="mb-3 mt-3">
                                            <label class="form-label fw-bold">Maklumat dan Dokumen Permohonan :</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="disokong" value="Disokong" {{ old('status', $appeal->kcl_status) == 'Disokong' ? 'checked' : '' }} @if(!$canEdit) disabled @endif>
                                                <label class="form-check-label" for="disokong">Disokong</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="tidak_disokong" value="Tidak Disokong" {{ old('status', $appeal->kcl_status) == 'Tidak Disokong' ? 'checked' : '' }} @if(!$canEdit) disabled @endif>
                                                <label class="form-check-label" for="tidak_disokong">Tidak Disokong</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="tidak_lengkap" value="Tidak Lengkap" {{ old('status', $appeal->kcl_status) == 'Tidak Lengkap' ? 'checked' : '' }} @if(!$canEdit) disabled @endif>
                                                <label class="form-check-label" for="tidak_lengkap">Tidak Lengkap</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ulasan</label>
                                            <textarea name="comments" class="form-control" id="kclUlasanField" rows="4" placeholder="Masukkan ulasan anda..." @if(!$canEdit) disabled @endif>{{ old('comments', $appeal->kcl_comments) }}</textarea>
                                        </div>
                                        <div class="d-flex justify-content-end gap-2 bg-white p-2" style="border-radius: 0 0 0.5rem 0.5rem;">
                                            <a href="{{ route('appeals.amendment') }}" class="btn btn-outline-secondary">Kembali</a>
                                            @if($canEdit)
                                                <button type="submit" name="action" value="save" class="btn btn-outline-primary">Simpan</button>
                                                <button type="submit" name="action" value="submit" class="btn btn-primary" id="kclHantarBtn">Hantar</button>
                                            @else
                                                <span class="text-muted">Permohonan tidak boleh diedit kerana status bukan "Tidak Lengkap".</span>
                                            @endif
                                        </div>
                                    </form>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            document.getElementById('kclReviewForm').addEventListener('submit', function(e) {
                                                var status = document.querySelector('input[name="status"]:checked');
                                                var ulasan = document.getElementById('kclUlasanField').value.trim();
                                                if (status && (status.value === 'Tidak Lengkap' || status.value === 'Tidak Disokong') && ulasan === '') {
                                                    alert('Ulasan wajib diisi jika permohonan tidak lengkap atau tidak disokong.');
                                                    e.preventDefault();
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 