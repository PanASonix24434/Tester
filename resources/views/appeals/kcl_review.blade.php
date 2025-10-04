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
                                                                                <i class="fas fa-search me-1" style="color: #fff;"></i>Lihat Dokumen
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
                                                                                <i class="fas fa-search me-1" style="color: #fff;"></i>Lihat Dokumen
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
                                                                            <i class="fas fa-search me-1"></i>Lihat Dokumen
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
                                                                                <i class="fas fa-search me-1" style="color: #fff;"></i>Lihat Dokumen
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
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="mb-0 fw-bold" style="color: #1a1a1a;">Status Permohonan</h5>
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="printStatusPermohonan()">
                                                    <i class="fas fa-print me-1"></i>Cetak
                                                </button>
                                            </div>
                                            
                                            <!-- Hantar Permohonan Card -->
                                            <div class="card mb-3" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: 1px solid #dee2e6;">
                                                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 12px 16px;">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 fw-bold" style="color: #343a40;">HANTAR PERMOHONAN</h6>
                                                    </div>
                                                    <div class="d-flex align-items-center ms-auto">
                                                        <span class="me-3" style="color: #343a40;">{{ $appeal->created_at ? $appeal->created_at->format('d M Y, h:i A') : '-' }}</span>
                                                        <button class="btn btn-sm" style="border: 1px solid #ced4da; background-color: #fff; padding: 4px 8px;">
                                                            <i class="fas fa-chevron-down" style="color: #343a40;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" style="background-color: #fff; padding: 16px;">
                                                    <table class="table table-borderless" style="margin-bottom: 0;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="color: #343a40; padding: 8px 0; width: 80px;">Status</td>
                                                                <td style="color: #343a40; padding: 8px 0; text-align: start; padding-left: 0; width: 10px;">:</td>
                                                                <td style="color: #343a40; padding: 8px 0;">DIHANTAR</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="color: #343a40; padding: 8px 0; width: 80px;">Ulasan</td>
                                                                <td style="color: #343a40; padding: 8px 0; text-align: start; padding-left: 0; width: 10px;">:</td>
                                                                <td style="color: #343a40; padding: 8px 0;">{{ $appeal->perakuan->nyatakan ?? 'PERMOHONAN DITERIMA SISTEM.' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="color: #343a40; padding: 8px 0; width: 80px;">Nama</td>
                                                                <td style="color: #343a40; padding: 8px 0; text-align: start; padding-left: 0; width: 10px;">:</td>
                                                                <td style="color: #343a40; padding: 8px 0;">{{ $appeal->applicant->name ?? 'ALI BIN ABU' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Semakan Dokumen Card -->
                                            <div class="card mb-3" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: 1px solid #dee2e6;">
                                                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 12px 16px;">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 fw-bold" style="color: #343a40;">SEMAKAN DOKUMEN</h6>
                                                    </div>
                                                    <div class="d-flex align-items-center ms-auto">
                                                        <span class="me-3" style="color: #343a40;">{{ $appeal->updated_at ? $appeal->updated_at->format('d M Y, h:i A') : '-' }}</span>
                                                        <button class="btn btn-sm" style="border: 1px solid #ced4da; background-color: #fff; padding: 4px 8px;">
                                                            <i class="fas fa-chevron-down" style="color: #343a40;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" style="background-color: #fff; padding: 16px;">
                                                    <table class="table table-borderless" style="margin-bottom: 0;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="color: #343a40; padding: 8px 0; width: 80px;">Status</td>
                                                                <td style="color: #343a40; padding: 8px 0; text-align: start; padding-left: 0; width: 10px;">:</td>
                                                                <td style="color: #343a40; padding: 8px 0;">
                                                                    @if(strtolower($appeal->ppl_status) === 'lengkap')
                                                                        LENGKAP
                                                                    @else
                                                                        TIDAK LENGKAP
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                                <td style="color: #343a40; padding: 8px 0; width: 80px;">Ulasan</td>
                                                                <td style="color: #343a40; padding: 8px 0; text-align: start; padding-left: 0; width: 10px;">:</td>
                                                                <td style="color: #343a40; padding: 8px 0;">{{ $appeal->ppl_comments }}</td>
                                                    </tr>
                                                    <tr>
                                                                <td style="color: #343a40; padding: 8px 0; width: 80px;">Nama</td>
                                                                <td style="color: #343a40; padding: 8px 0; text-align: start; padding-left: 0; width: 10px;">:</td>
                                                                <td style="color: #343a40; padding: 8px 0;">{{ $appeal->pplReviewer->name ?? 'PN. SITI BINTI OMAR' }}</td>
                                                    </tr>
                                                        </tbody>
                                                </table>
                                                </div>
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
                                                            <label class="form-label fw-bold">Maklumat dan Dokumen Permohonan <span class="text-danger">*</span> :</label>
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
                                                            <label class="form-label fw-bold">Ulasan <span class="text-danger">*</span></label>
                                                            <textarea name="comments" class="form-control" id="kclUlasanField" rows="4" placeholder="Masukkan ulasan anda..." @if(!$canEdit) disabled @endif>{{ old('comments', $appeal->kcl_comments) }}</textarea>
                                                        </div>
                                                        <div class="text-center mt-4 bg-white p-2" style="border-radius: 0 0 0.5rem 0.5rem;">
                                                            <a href="{{ route('appeals.amendment') }}" class="btn btn-sm" style="background-color: #282c34; color: #fff !important; border: 1px solid #282c34; border-radius: 8px;">
                                                                <i class="fas fa-arrow-left me-2" style="color: #fff;"></i><span style="color: #fff !important;">Kembali</span>
                                                            </a>
                                                            @if($canEdit)
                                                                <button type="submit" name="action" value="save" class="btn btn-sm" style="background-color: #007BFF; color: #fff; border: 1px solid #007BFF; border-radius: 8px;">
                                                                    <i class="fas fa-save me-2" style="color: #fff;"></i>Simpan
                                                                </button>
                                                                <button type="submit" name="action" value="submit" class="btn btn-sm" style="background-color: #28a745; color: #fff; border: 1px solid #28a745; border-radius: 8px;" id="kclHantarBtn">
                                                                    <i class="fas fa-paper-plane me-2" style="color: #fff;"></i>Hantar
                                                                </button>
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

                                                        // Print Status Permohonan Function
                                                        function printStatusPermohonan() {
                                                            // Get the status-permohonan tab content
                                                            const statusContent = document.getElementById('status-permohonan');
                                                            
                                                            // Create a new window for printing
                                                            const printWindow = window.open('', '_blank', 'width=800,height=600');
                                                            
                                                            // Get current date and time
                                                            const now = new Date();
                                                            const dateTime = now.toLocaleString('ms-MY', {
                                                                year: 'numeric',
                                                                month: '2-digit',
                                                                day: '2-digit',
                                                                hour: '2-digit',
                                                                minute: '2-digit'
                                                            });
                                                            
                                                            // Write the content to the new window
                                                            printWindow.document.write(`
                                                                <html>
                                                                    <head>
                                                                        <title>Status Permohonan - KCL</title>
                                                                        <style>
                                                                            body { 
                                                                                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                                                                                margin: 20px; 
                                                                                color: #333;
                                                                                line-height: 1.6;
                                                                                position: relative;
                                                                            }
                                                                            .watermark {
                                                                                position: fixed;
                                                                                top: 0;
                                                                                left: 0;
                                                                                width: 100%;
                                                                                height: 100%;
                                                                                z-index: 999;
                                                                                pointer-events: none;
                                                                                user-select: none;
                                                                                background: transparent;
                                                                            }
                                                                            .watermark::before {
                                                                                content: "SULIT";
                                                                                position: absolute;
                                                                                top: 50%;
                                                                                left: 50%;
                                                                                transform: translate(-50%, -50%) rotate(-45deg);
                                                                                font-size: 80px;
                                                                                font-weight: bold;
                                                                                color: rgba(255, 0, 0, 0.08);
                                                                                text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
                                                                            }
                                                                            .watermark::after {
                                                                                content: "SULIT";
                                                                                position: absolute;
                                                                                top: 25%;
                                                                                left: 25%;
                                                                                transform: rotate(-45deg);
                                                                                font-size: 80px;
                                                                                font-weight: bold;
                                                                                color: rgba(255, 0, 0, 0.06);
                                                                                text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
                                                                            }
                                                                            .watermark .sulit-1 {
                                                                                position: absolute;
                                                                                top: 20%;
                                                                                left: 20%;
                                                                                transform: translate(-50%, -50%) rotate(-45deg);
                                                                                font-size: 70px;
                                                                                font-weight: bold;
                                                                                color: rgba(255, 0, 0, 0.05);
                                                                                text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
                                                                                pointer-events: none;
                                                                                user-select: none;
                                                                            }
                                                                            .watermark .sulit-2 {
                                                                                position: absolute;
                                                                                top: 20%;
                                                                                left: 80%;
                                                                                transform: translate(-50%, -50%) rotate(-45deg);
                                                                                font-size: 70px;
                                                                                font-weight: bold;
                                                                                color: rgba(255, 0, 0, 0.05);
                                                                                text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
                                                                                pointer-events: none;
                                                                                user-select: none;
                                                                            }
                                                                            .watermark .sulit-3 {
                                                                                position: absolute;
                                                                                top: 80%;
                                                                                left: 20%;
                                                                                transform: translate(-50%, -50%) rotate(-45deg);
                                                                                font-size: 70px;
                                                                                font-weight: bold;
                                                                                color: rgba(255, 0, 0, 0.05);
                                                                                text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
                                                                                pointer-events: none;
                                                                                user-select: none;
                                                                            }
                                                                            .watermark .sulit-4 {
                                                                                position: absolute;
                                                                                top: 80%;
                                                                                left: 80%;
                                                                                transform: translate(-50%, -50%) rotate(-45deg);
                                                                                font-size: 70px;
                                                                                font-weight: bold;
                                                                                color: rgba(255, 0, 0, 0.05);
                                                                                text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
                                                                                pointer-events: none;
                                                                                user-select: none;
                                                                            }
                                                                            .header {
                                                                                text-align: center;
                                                                                border-bottom: 2px solid #007bff;
                                                                                padding-bottom: 15px;
                                                                                margin-bottom: 20px;
                                                                                position: relative;
                                                                                z-index: 1;
                                                                            }
                                                                            .header h1 {
                                                                                color: #007bff;
                                                                                margin: 0;
                                                                                font-size: 24px;
                                                                            }
                                                                            .header p {
                                                                                margin: 5px 0 0 0;
                                                                                color: #666;
                                                                                font-size: 14px;
                                                                            }
                                                                            .card { 
                                                                                border: 1px solid #dee2e6; 
                                                                                margin-bottom: 20px; 
                                                                                border-radius: 8px;
                                                                                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                                                                position: relative;
                                                                                z-index: 1;
                                                                                background-color: #fff;
                                                                            }
                                                                            .card-header { 
                                                                                background-color: #f8f9fa; 
                                                                                padding: 12px 16px; 
                                                                                font-weight: bold;
                                                                                border-bottom: 1px solid #dee2e6;
                                                                                font-size: 14px;
                                                                                color: #343a40;
                                                                            }
                                                                            .card-body { 
                                                                                padding: 16px; 
                                                                                background-color: #fff;
                                                                            }
                                                                            table { 
                                                                                width: 100%; 
                                                                                border-collapse: collapse;
                                                                            }
                                                                            td { 
                                                                                padding: 8px 0; 
                                                                                border: none;
                                                                            }
                                                                            .status-badge {
                                                                                font-weight: bold;
                                                                                padding: 4px 8px;
                                                                                border-radius: 4px;
                                                                                background-color: #28a745;
                                                                                color: white;
                                                                                font-size: 12px;
                                                                            }
                                                                            .footer {
                                                                                text-align: center;
                                                                                margin-top: 30px;
                                                                                padding-top: 20px;
                                                                                border-top: 1px solid #ddd;
                                                                                font-size: 12px;
                                                                                color: #666;
                                                                                position: relative;
                                                                                z-index: 1;
                                                                            }
                                                                            @media print {
                                                                                body { margin: 0; }
                                                                                .card { box-shadow: none; }
                                                                                .no-print { display: none; }
                                                                                .watermark {
                                                                                    background: transparent;
                                                                                }
                                                                                .watermark::before {
                                                                                    color: rgba(255, 0, 0, 0.12);
                                                                                }
                                                                                .watermark::after {
                                                                                    color: rgba(255, 0, 0, 0.10);
                                                                                }
                                                                                .watermark .sulit-1,
                                                                                .watermark .sulit-2,
                                                                                .watermark .sulit-3,
                                                                                .watermark .sulit-4 {
                                                                                    color: rgba(255, 0, 0, 0.08);
                                                                                }
                                                                            }
                                                                        </style>
                                                                    </head>
                                                                    <body>
                                                                        <div class="watermark">
                                                                            <div class="sulit-1">SULIT</div>
                                                                            <div class="sulit-2">SULIT</div>
                                                                            <div class="sulit-3">SULIT</div>
                                                                            <div class="sulit-4">SULIT</div>
                                                                        </div>
                                                                        <div class="header">
                                                                            <h1>Status Permohonan</h1>
                                                                            <p>Tarikh Cetak: ${dateTime}</p>
                                                                        </div>
                                                                        ${statusContent.innerHTML.replace(/<button[^>]*>.*?<\/button>/gi, '')}
                                                                        <div class="footer">
                                                                            <p>Dokumen ini dijana secara automatik pada ${dateTime}</p>
                                                                        </div>
                                                                    </body>
                                                                </html>
                                                            `);
                                                            
                                                            printWindow.document.close();
                                                            
                                                            // Wait for content to load then trigger print dialog
                                                            setTimeout(() => {
                                                                printWindow.focus();
                                                                printWindow.print();
                                                            }, 500);
                                                        }
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