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
                            <!-- Tab Navigation for KCL Officer View -->
                            <div class="card border-0 shadow-sm rounded-3 mb-4">
                                <div class="card-body">
                                    <ul class="nav nav-tabs mb-4" id="kclOfficerTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="profil-pemohon-tab" data-bs-toggle="tab" data-bs-target="#profil-pemohon" type="button" role="tab" aria-controls="profil-pemohon" aria-selected="true">Profil Pemohon</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="maklumat-permohonan-tab" data-bs-toggle="tab" data-bs-target="#maklumat-permohonan" type="button" role="tab" aria-controls="maklumat-permohonan" aria-selected="false">Maklumat Permohonan</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab" aria-controls="dokumen" aria-selected="false">Dokumen</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="status-permohonan-tab" data-bs-toggle="tab" data-bs-target="#status-permohonan" type="button" role="tab" aria-controls="status-permohonan" aria-selected="false">Status Permohonan</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tindakan-tab" data-bs-toggle="tab" data-bs-target="#tindakan" type="button" role="tab" aria-controls="tindakan" aria-selected="false">Tindakan</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="kclOfficerTabContent">
                                        <!-- Profil Pemohon Tab -->
                                        <div class="tab-pane fade show active" id="profil-pemohon" role="tabpanel" aria-labelledby="profil-pemohon-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Butiran Am Pemohon</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered bg-white" style="color: #1a1a1a;">
                                                    <tr>
                                                        <th width="250">Nama Pemilik Vesel:</th>
                                                        <td>{{ $applicant->name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>No. Kad Pengenalan:</th>
                                                        <td>{{ $applicant->username ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Umur:</th>
                                                        <td>{{ $applicant->age ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Jantina:</th>
                                                        <td>{{ $applicant->gender ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Agama:</th>
                                                        <td>{{ $applicant->religion ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Bangsa:</th>
                                                        <td>{{ $applicant->race ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status Bumiputera:</th>
                                                        <td>{{ $applicant->bumiputera_status ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status Kewarganegaraan:</th>
                                                        <td>{{ $applicant->citizenship ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status Perkahwinan:</th>
                                                        <td>{{ $applicant->marital_status ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>No. Telefon Bimbit:</th>
                                                        <td>{{ $applicant->mobile_contact_number ?? $applicant->mobilePhone ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>No. Telefon (Pejabat):</th>
                                                        <td>{{ $applicant->no_phone_office ?? $applicant->phone_no ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email:</th>
                                                        <td>{{ $applicant->email ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Alamat Semasa:</th>
                                                        <td>
                                                            @if($applicant->current_address1 || $applicant->address1)
                                                                {{ $applicant->current_address1 ?? $applicant->address1 }}<br>
                                                                {{ $applicant->current_address2 ?? $applicant->address2 }}<br>
                                                                {{ $applicant->current_address3 ?? $applicant->address3 }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Poskod:</th>
                                                        <td>{{ $applicant->current_postcode ?? $applicant->postcode ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Daerah:</th>
                                                        <td>{{ $applicant->current_district ?? $applicant->district ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Negeri:</th>
                                                        <td>{{ $applicant->current_state ?? $applicant->state ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Maklumat Permohonan Tab -->
                                        <div class="tab-pane fade" id="maklumat-permohonan" role="tabpanel" aria-labelledby="maklumat-permohonan-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Maklumat Permohonan</h5>
                                            <div class="table-responsive">
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
                                        </div>

                                        <!-- Dokumen Tab -->
                                        <div class="tab-pane fade" id="dokumen" role="tabpanel" aria-labelledby="dokumen-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Dokumen Permohonan</h5>
                                            
                                            <!-- Sub-tabs for different document categories -->
                                            <ul class="nav nav-pills mb-3" id="kclDocumentSubTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="dokumen-wajib-sub-tab" data-bs-toggle="tab" data-bs-target="#dokumen-wajib-sub" type="button" role="tab">Dokumen Wajib</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="dokumen-sokongan-sub-tab" data-bs-toggle="tab" data-bs-target="#dokumen-sokongan-sub" type="button" role="tab">Dokumen Sokongan</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="dokumen-tambahan-sub-tab" data-bs-toggle="tab" data-bs-target="#dokumen-tambahan-sub" type="button" role="tab">Dokumen Tambahan</button>
                                                </li>
                                            </ul>

                                            <div class="tab-content" id="kclDocumentSubTabContent">
                                                <!-- Dokumen Wajib Sub-tab -->
                                                <div class="tab-pane fade show active" id="dokumen-wajib-sub" role="tabpanel">
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

                                                <!-- Dokumen Sokongan Sub-tab -->
                                                <div class="tab-pane fade" id="dokumen-sokongan-sub" role="tabpanel">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered bg-white" style="color: #1a1a1a;">
                                                            @php
                                                                $hasDocuments = false;
                                                            @endphp
                                                            
                                                            @if($dokumenSokongan && $dokumenSokongan->count() > 0)
                                                                @foreach($dokumenSokongan as $dokumen)
                                                                    @php $hasDocuments = true; @endphp
                                                                    <tr>
                                                                        <th width="200">{{ ucfirst(str_replace('_', ' ', $dokumen->file_type)) }}:</th>
                                                                        <td>
                                                                            <a href="{{ route('appeals.viewDokumenSokongan', $dokumen->id) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                                <i class="fas fa-eye me-1"></i>Lihat Dokumen
                                                                            </a>
                                                                            <small class="text-muted ms-2">{{ $dokumen->file_name }}</small>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            
                                                            @if($perakuan && $perakuan->type === 'kvp08' && !empty($perakuan->dokumen_sokongan_path))
                                                                @php $hasDocuments = true; @endphp
                                                                <tr>
                                                                    <th width="200">Dokumen Sokongan (KPV-08):</th>
                                                                    <td>
                                                                        <a href="{{ route('appeals.viewDocument', ['appealId' => $appeal->id, 'field' => 'dokumen_sokongan_path']) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                            <i class="fas fa-eye me-1"></i>Lihat Dokumen
                                                                        </a>
                                                                        <small class="text-muted ms-2">{{ basename($perakuan->dokumen_sokongan_path) }}</small>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if(!$hasDocuments)
                                                                <tr>
                                                                    <td colspan="2" class="text-center text-muted">Tiada dokumen sokongan dijumpai</td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- Dokumen Tambahan Sub-tab -->
                                                <div class="tab-pane fade" id="dokumen-tambahan-sub" role="tabpanel">
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

                                        <!-- Status Permohonan Tab -->
                                        <div class="tab-pane fade" id="status-permohonan" role="tabpanel" aria-labelledby="status-permohonan-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Status Permohonan</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered bg-white" style="color: #1a1a1a;">
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
                                                        ];
                                                        $status = $appeal->status ?? 'unknown';
                                                    @endphp
                                                    <tr>
                                                        <th width="200">Status Semasa:</th>
                                                        <td>
                                                            <span class="badge bg-info text-white">
                                                                {{ $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}
                                                            </span>
                                                            @php
                                                                $role = strtolower(auth()->user()->peranan ?? '');
                                                                $customStatus = null;
                                                                if (strpos($role, 'ketua cawangan') !== false && $appeal->kcl_status === 'Disokong') {
                                                                    $customStatus = 'disokong';
                                                                }
                                                            @endphp
                                                            @if($customStatus)
                                                                <span class="badge bg-success text-white ms-2">{{ ucfirst($customStatus) }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tarikh Permohonan:</th>
                                                        <td>{{ $appeal->created_at ? $appeal->created_at->format('d/m/Y H:i') : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tarikh Kemaskini:</th>
                                                        <td>{{ $appeal->updated_at ? $appeal->updated_at->format('d/m/Y H:i') : '-' }}</td>
                                                    </tr>
                                                    @if($appeal->ppl_comments)
                                                    <tr>
                                                        <th>Ulasan PPL:</th>
                                                        <td>{{ $appeal->ppl_comments }}</td>
                                                    </tr>
                                                    @endif
                                                    @if($appeal->kcl_comments)
                                                    <tr>
                                                        <th>Ulasan KCL:</th>
                                                        <td>{{ $appeal->kcl_comments }}</td>
                                                    </tr>
                                                    @endif
                                                    @if($appeal->pk_comments)
                                                    <tr>
                                                        <th>Ulasan PK:</th>
                                                        <td>{{ $appeal->pk_comments }}</td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Tindakan Tab -->
                                        <div class="tab-pane fade" id="tindakan" role="tabpanel" aria-labelledby="tindakan-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Tindakan Pegawai</h5>
                                            
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
            </div>
        </div>
    </div>
</div>
@endsection 