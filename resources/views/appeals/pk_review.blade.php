@extends('layouts.app')
@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-white fw-semibold rounded-top" style="background-color: #3C2387;">
                            Semakan Permohonan
                        </div>
                        <div class="card-body">
                            <!-- Basic Info Section -->
                            <div class="card border-0  rounded-3 mb-4">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Basic Info</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" style="color: #1a1a1a;">No. Pendaftaran Vesel</label>
                                                <div class="form-control-plaintext bg-light rounded p-2" style="font-size: 1.2em; font-weight: bold; color: #495057;">
                                                    {{ $perakuan->no_pendaftaran_vesel ?? 'VES1234' }}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" style="color: #1a1a1a;">Nama Pemilik</label>
                                                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                                                    {{ $applicant->name ?? 'ABC MARINE SDN BHD' }}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" style="color: #1a1a1a;">No. Rujukan</label>
                                                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                                                    {{ $appeal->ref_number ?? 'APP-000001' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" style="color: #1a1a1a;">Di Mohon Oleh</label>
                                                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                                                    PENGURUS VESEL: {{ $applicant->name ?? 'ALI BIN ABU' }}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" style="color: #1a1a1a;">No. Kad Pengenalan / No. Pendaftaran Syarikat</label>
                                                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                                                    {{ $applicant->username ?? '900101-14-5678' }}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" style="color: #1a1a1a;">Tarikh Permohonan</label>
                                                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                                                    {{ $appeal->created_at ? $appeal->created_at->format('Y-m-d H:i:s') : '2025-08-21 10:30:00' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Navigation for PK Officer View -->
                            <div class="card border-0  rounded-3 mb-4">
                                <div class="card-body">
                                    <ul class="nav nav-tabs mb-4" id="pkOfficerTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pemohon-tab" data-bs-toggle="tab" data-bs-target="#pemohon" type="button" role="tab" aria-controls="pemohon" aria-selected="true">Pemohon</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="vesel-tab" data-bs-toggle="tab" data-bs-target="#vesel" type="button" role="tab" aria-controls="vesel" aria-selected="false">Vesel</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="permohonan-tab" data-bs-toggle="tab" data-bs-target="#permohonan" type="button" role="tab" aria-controls="permohonan" aria-selected="false">Permohonan</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab" aria-controls="dokumen" aria-selected="false">Dokumen</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="rekod-kesalahan-tab" data-bs-toggle="tab" data-bs-target="#rekod-kesalahan" type="button" role="tab" aria-controls="rekod-kesalahan" aria-selected="false">Rekod Kesalahan</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="status-permohonan-tab" data-bs-toggle="tab" data-bs-target="#status-permohonan" type="button" role="tab" aria-controls="status-permohonan" aria-selected="false">Status Permohonan</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tindakan-tab" data-bs-toggle="tab" data-bs-target="#tindakan" type="button" role="tab" aria-controls="tindakan" aria-selected="false">Tindakan</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="pkOfficerTabContent">
                                        <!-- Pemohon Tab -->
                                        <div class="tab-pane fade show active" id="pemohon" role="tabpanel" aria-labelledby="pemohon-tab">
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

                                        <!-- Vesel Tab -->
                                        <div class="tab-pane fade" id="vesel" role="tabpanel" aria-labelledby="vesel-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Maklumat Vesel</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered bg-white" style="color: #1a1a1a;">
                                                    <tr>
                                                        <th width="250">No. Pendaftaran Vesel:</th>
                                                        <td>{{ $perakuan->no_pendaftaran_vesel ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Negeri Asal Vesel:</th>
                                                        <td>{{ $perakuan->negeri_asal_vesel ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Pelabuhan Pangkalan:</th>
                                                        <td>{{ $perakuan->pelabuhan_pangkalan ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Pangkalan Asal:</th>
                                                        <td>{{ $perakuan->pangkalan_asal ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Pangkalan Baru:</th>
                                                        <td>{{ $perakuan->pangkalan_baru ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Jenis Bahan Binaan Vesel:</th>
                                                        <td>{{ $perakuan->jenis_bahan_binaan_vesel ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Permohonan Tab -->
                                        <div class="tab-pane fade" id="permohonan" role="tabpanel" aria-labelledby="permohonan-tab">
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

                                        <!-- Rekod Kesalahan Tab -->
                                        <div class="tab-pane fade" id="rekod-kesalahan" role="tabpanel" aria-labelledby="rekod-kesalahan-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Rekod Kesalahan</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered bg-white" style="color: #1a1a1a;">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Bil</th>
                                                            <th>Tarikh Kesalahan</th>
                                                            <th>Jenis Kesalahan</th>
                                                            <th>Hukuman</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">Tiada rekod kesalahan dijumpai</td>
                                                        </tr>
                                                    </tbody>
                                </table>
                            </div>
                                        </div>

                                        <!-- Dokumen Tab -->
                                        <div class="tab-pane fade" id="dokumen" role="tabpanel" aria-labelledby="dokumen-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Maklumat Dokumen</h5>
                                            <p class="text-muted mb-4">Senarai dokumen sokongan yang dimuat naik oleh pemohon</p>
                                            
                                            <div class="card border-0  rounded-3">
                                                <div class="card-body p-0">
                                            <div class="table-responsive">
                                                        <table class="table table-hover mb-0" style="color: #1a1a1a;">
                                                            <thead style="background-color: #E6E6FA;">
                                                                <tr>
                                                                    <th class="border-0 py-3 px-4 fw-bold" style="width: 60px;">Bil.</th>
                                                                    <th class="border-0 py-3 px-4 fw-bold">Jenis Dokumen</th>
                                                                    <th class="border-0 py-3 px-4 fw-bold">Nama Fail</th>
                                                                    <th class="border-0 py-3 px-4 fw-bold">Tarikh Muat Naik</th>
                                                                    <th class="border-0 py-3 px-4 fw-bold text-center" style="width: 120px;">Tindakan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $documents = [];
                                                                    $counter = 1;
                                                                    
                                                                    // Add wajib documents
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
                                                                    
                                                                    foreach($wajibDocs as $doc => $label) {
                                                                        if(!empty($perakuan->$doc)) {
                                                                            $documents[] = [
                                                                                'type' => $label,
                                                                                'filename' => basename($perakuan->$doc),
                                                                                'date' => $perakuan->updated_at ? $perakuan->updated_at->format('d M Y') : 'N/A',
                                                                                'route' => route('appeals.viewDocument', ['appealId' => $appeal->id, 'field' => $doc])
                                                                            ];
                                                                        }
                                                                    }
                                                                    
                                                                    // Add dokumen sokongan
                                                                    if($dokumenSokongan && $dokumenSokongan->count() > 0) {
                                                                        foreach($dokumenSokongan as $dokumen) {
                                                                            $documents[] = [
                                                                                'type' => ucfirst(str_replace('_', ' ', $dokumen->file_type)),
                                                                                'filename' => $dokumen->file_name,
                                                                                'date' => $dokumen->created_at ? $dokumen->created_at->format('d M Y') : 'N/A',
                                                                                'route' => route('appeals.viewDokumenSokongan', $dokumen->id)
                                                                            ];
                                                                        }
                                                                    }
                                                                    
                                                                    // Add KVP-08 dokumen sokongan
                                                                    if($perakuan && $perakuan->type === 'kvp08' && !empty($perakuan->dokumen_sokongan_path)) {
                                                                        $documents[] = [
                                                                            'type' => 'Dokumen Sokongan (KPV-08)',
                                                                            'filename' => basename($perakuan->dokumen_sokongan_path),
                                                                            'date' => $perakuan->updated_at ? $perakuan->updated_at->format('d M Y') : 'N/A',
                                                                            'route' => route('appeals.viewDocument', ['appealId' => $appeal->id, 'field' => 'dokumen_sokongan_path'])
                                                                        ];
                                                                    }
                                                                    
                                                                    // Add tambahan documents
                                                        $tambahanDocs = [
                                                            'akuan_sumpah_bina_baru_path' => 'Akuan Sumpah (Bina Baru)',
                                                            'surat_kelulusan_kpp_path' => 'Surat Kelulusan KPP'
                                                        ];
                                                                    
                                                                    foreach($tambahanDocs as $doc => $label) {
                                                                        if(!empty($perakuan->$doc)) {
                                                                            $documents[] = [
                                                                                'type' => $label,
                                                                                'filename' => basename($perakuan->$doc),
                                                                                'date' => $perakuan->updated_at ? $perakuan->updated_at->format('d M Y') : 'N/A',
                                                                                'route' => route('appeals.viewDocument', ['appealId' => $appeal->id, 'field' => $doc])
                                                                            ];
                                                                        }
                                                                    }
                                                    @endphp
                                                                
                                                                @if(count($documents) > 0)
                                                                    @foreach($documents as $index => $document)
                                                                        <tr>
                                                                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                                                                            <td class="py-3 px-4">{{ $document['type'] }}</td>
                                                                            <td class="py-3 px-4">{{ $document['filename'] }}</td>
                                                                            <td class="py-3 px-4">{{ $document['date'] }}</td>
                                                                            <td class="py-3 px-4 text-center">
                                                                                <div class="btn-group" role="group">
                                                                                    <a href="{{ $document['route'] }}" target="_blank" class="btn btn-sm me-2" style="background-color: #1E40AF; color: #fff; border: 1px solid #1E40AF; border-radius: 6px; padding: 6px 12px;" title="Lihat Dokumen">
                                                                                        <i class="fas fa-search" style="color: #fff;"></i>
                                                                                    </a>
                                                                                    <a href="{{ $document['route'] }}" download class="btn btn-sm" style="background-color: #059669; color: #fff; border: 1px solid #059669; border-radius: 6px; padding: 6px 12px;" title="Muat Turun Dokumen">
                                                                                        <i class="fas fa-download" style="color: #fff;"></i>
                                                                                    </a>
                                                                                </div>
                                                                </td>
                                                            </tr>
                                                    @endforeach
                                                                @else
                                                        <tr>
                                                                        <td colspan="5" class="text-center text-muted py-4">Tiada dokumen dijumpai</td>
                                                        </tr>
                                                    @endif
                                                            </tbody>
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
                                                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 12px 16px; cursor: pointer;" onclick="toggleStatusCard(this)">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 fw-bold" style="color: #343a40;">HANTAR PERMOHONAN</h6>
                                                    </div>
                                                    <div class="d-flex align-items-center ms-auto">
                                                        <span class="me-3" style="color: #343a40;">{{ $appeal->created_at ? $appeal->created_at->format('d M Y, h:i A') : '-' }}</span>
                                                        <button class="btn btn-sm toggle-arrow" style="border: 1px solid #ced4da; background-color: #fff; padding: 4px 8px;" type="button">
                                                            <i class="fas fa-chevron-down" style="color: #343a40;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body status-card-body" style="background-color: #fff; padding: 16px;">
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
                                                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 12px 16px; cursor: pointer;" onclick="toggleStatusCard(this)">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 fw-bold" style="color: #343a40;">SEMAKAN DOKUMEN</h6>
                                                    </div>
                                                    <div class="d-flex align-items-center ms-auto">
                                                        <span class="me-3" style="color: #343a40;">{{ $appeal->updated_at ? $appeal->updated_at->format('d M Y, h:i A') : '-' }}</span>
                                                        <button class="btn btn-sm toggle-arrow" style="border: 1px solid #ced4da; background-color: #fff; padding: 4px 8px;" type="button">
                                                            <i class="fas fa-chevron-down" style="color: #343a40;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body status-card-body" style="background-color: #fff; padding: 16px;">
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

                                            <!-- Jadual Pemeriksaan Card -->
                                            @if($appeal->kcl_comments || $appeal->kcl_status)
                                            <div class="card mb-3" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: 1px solid #dee2e6;">
                                                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 12px 16px; cursor: pointer;" onclick="toggleStatusCard(this)">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 fw-bold" style="color: #343a40;">JADUAL PEMERIKSAAN</h6>
                                                    </div>
                                                    <div class="d-flex align-items-center ms-auto">
                                                        <span class="me-3" style="color: #343a40;">{{ $appeal->updated_at ? $appeal->updated_at->format('d M Y, h:i A') : '-' }}</span>
                                                        <button class="btn btn-sm toggle-arrow" style="border: 1px solid #ced4da; background-color: #fff; padding: 4px 8px;" type="button">
                                                            <i class="fas fa-chevron-down" style="color: #343a40;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body status-card-body" style="background-color: #fff; padding: 16px;">
                                                    <table class="table table-borderless" style="margin-bottom: 0;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="color: #343a40; padding: 8px 0; width: 80px;">Status</td>
                                                                <td style="color: #343a40; padding: 8px 0; text-align: start; padding-left: 0; width: 10px;">:</td>
                                                                <td style="color: #343a40; padding: 8px 0;">
                                                                    @if(strtolower($appeal->kcl_status) === 'disokong')
                                                                        DISOKONG
                                                                    @elseif(strtolower($appeal->kcl_status) === 'tidak disokong')
                                                                        TIDAK DISOKONG
                                                                    @elseif(strtolower($appeal->kcl_status) === 'tidak lengkap')
                                                                        TIDAK LENGKAP
                                                                    @else
                                                                        DIJADUALKAN
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="color: #343a40; padding: 8px 0; width: 80px;">Ulasan</td>
                                                                <td style="color: #343a40; padding: 8px 0; text-align: start; padding-left: 0; width: 10px;">:</td>
                                                                <td style="color: #343a40; padding: 8px 0;">{{ $appeal->kcl_comments }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="color: #343a40; padding: 8px 0; width: 80px;">Nama</td>
                                                                <td style="color: #343a40; padding: 8px 0; text-align: start; padding-left: 0; width: 10px;">:</td>
                                                                <td style="color: #343a40; padding: 8px 0;">{{ $appeal->kclReviewer->name ?? 'KETUA DAERAH PERIKANAN' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @endif

                    </div>

                                        <!-- Tindakan Tab -->
                                        <div class="tab-pane fade" id="tindakan" role="tabpanel" aria-labelledby="tindakan-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Tindakan: Keputusan</h5>
                                            <p class="text-muted mb-4">Pilih hasil semakan dan nyatakan ulasan. Keputusan hanya diperlukan jika semakan adalah lengkap.</p>
                                            
                                            <form method="POST" action="{{ route('appeals.pk_submit', $appeal->id) }}" enctype="multipart/form-data" id="pkReviewForm">
                                        @csrf
                                                        
                                                        <!-- Jana dan Cetak Surat Section -->
                                                        <div class="mb-4 p-3" style="background-color: #f8f9fa; border-radius: 8px; border-left: 4px solid #198754;">
                                                            <h6 class="fw-bold mb-2" style="color: #1a1a1a;">
                                                                <i class="fas fa-file-pdf me-2 text-success"></i>Surat Kelulusan KPP Berserta Laporan
                                                            </h6>
                                                            <p class="text-muted small mb-3">
                                                                Klik butang di bawah untuk menjana nombor rujukan dan cetak Surat Kelulusan KPP berserta laporan permohonan. 
                                                                Surat ini perlu diserahkan kepada KPP untuk ditandatangani.
                                                            </p>
                                                            <div class="text-start">
                                                                @if($canSubmit)
                                                                <button type="button" class="btn btn-sm" style="background-color: #198754; color: #fff; border: 1px solid #198754; border-radius: 8px; font-weight: bold;" onclick="generateAndPrintLetter()" id="generateLetterBtn">
                                                                    <i class="fas fa-file-pdf me-2" style="color: #fff;"></i>Jana dan Cetak Surat Kelulusan KPP Berserta Laporan
                                                                </button>
                                                                @else
                                                                <button type="button" class="btn btn-sm" style="background-color: #6c757d; color: #fff; border: 1px solid #ddd; border-radius: 6px;" disabled title="Permohonan telah dihantar pada {{ $appeal->pk_submitted_at ? $appeal->pk_submitted_at->format('d M Y, h:i A') : '' }}">
                                                                    <i class="fas fa-file-pdf me-2" style="color: #fff;"></i>Jana dan Cetak Surat Kelulusan KPP Berserta Laporan
                                                                </button>
                                                                <small class="text-muted d-block mt-2">(Permohonan telah dihantar)</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Semakan Section -->
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold" style="color: #1a1a1a;">Semakan <span class="text-danger">*</span></label>
                                                            <p class="text-muted small mb-3">Sila pilih semakan untuk permohonan ini</p>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="semakan_status" id="lengkap" value="Lengkap" {{ old('semakan_status', $appeal->pk_semakan_status) == 'Lengkap' ? 'checked' : '' }} {{ !$canSubmit ? 'disabled' : '' }}>
                                                                    <label class="form-check-label fw-medium" for="lengkap" style="color: #1a1a1a;">Lengkap</label>
                                    </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="semakan_status" id="tidak_lengkap" value="Tidak Lengkap" {{ old('semakan_status', $appeal->pk_semakan_status) == 'Tidak Lengkap' ? 'checked' : '' }} {{ !$canSubmit ? 'disabled' : '' }}>
                                                                    <label class="form-check-label fw-medium" for="tidak_lengkap" style="color: #1a1a1a;">Tidak Lengkap</label>
                                        </div>
                                        </div>
                                                        </div>
                                                        
                                                        <!-- Keputusan Section -->
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold" style="color: #1a1a1a;">Keputusan <span class="text-danger">*</span></label>
                                                            <p class="text-muted small mb-3">Sila berikan keputusan anda untuk permohonan ini</p>
                                                            <div class="d-flex gap-4">
                                            <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="decision" id="diluluskan" value="Diluluskan" {{ old('decision', $appeal->pk_decision) == 'Diluluskan' ? 'checked' : '' }} {{ !$canSubmit ? 'disabled' : '' }}>
                                                                    <label class="form-check-label fw-medium" for="diluluskan" style="color: #1a1a1a;">Diluluskan</label>
                                            </div>
                                            <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="decision" id="tidak_diluluskan" value="Tidak Diluluskan" {{ old('decision', $appeal->pk_decision) == 'Tidak Diluluskan' ? 'checked' : '' }} {{ !$canSubmit ? 'disabled' : '' }}>
                                                                    <label class="form-check-label fw-medium" for="tidak_diluluskan" style="color: #1a1a1a;">Tidak Diluluskan</label>
                                            </div>
                                        </div>
                                        </div>
                                                        
                                                        <!-- Surat Kelulusan KPP Section -->
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold" style="color: #1a1a1a;">Surat Kelulusan KPP (Yang Telah Ditandatangani) <span class="text-danger">*</span></label>
                                                            <p class="text-muted small mb-3">
                                                                <i class="fas fa-info-circle text-info me-1"></i>
                                                                Muat naik surat kelulusan KPP yang telah ditandatangani oleh KPP. 
                                                                Surat ini adalah surat yang telah dicetak menggunakan butang "Jana dan Cetak Surat" di atas, 
                                                                diserahkan kepada KPP untuk ditandatangani, dan dikembalikan kepada anda.
                                                            </p>
                                                            @if(!empty($appeal->surat_kelulusan_kpp))
                                                            <div class="alert alert-success mb-2" style="border-radius: 8px;">
                                                                <i class="fas fa-file-check me-2"></i>
                                                                <strong>Fail telah dimuat naik:</strong> {{ basename($appeal->surat_kelulusan_kpp) }}
                                                                <a href="{{ asset('storage/' . $appeal->surat_kelulusan_kpp) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                                </a>
                                                            </div>
                                                            @endif
                                                            @if($canSubmit)
                                                            <input type="file" class="form-control" name="surat_kelulusan_kpp" id="suratKelulusanKpp" accept=".pdf,.png,.jpg,.jpeg" style="border: 1px solid #d1d5db; border-radius: 8px; padding: 12px;">
                                                            <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 10MB.</small>
                                        @else
                                                            <input type="file" class="form-control" name="surat_kelulusan_kpp" id="suratKelulusanKpp" accept=".pdf,.png,.jpg,.jpeg" style="border: 1px solid #d1d5db; border-radius: 8px; padding: 12px;" disabled>
                                                            <small class="form-text text-muted">Fail tidak boleh dikemaskini selepas dihantar.</small>
                                        @endif
                                                            <div id="fileUploadStatus" class="mt-2" style="display: none;">
                                                                <small class="text-success"><i class="fas fa-check-circle"></i> Fail berjaya dimuat naik!</small>
                                    </div>
                                                        </div>
                                                        
                                                        <!-- No. Rujukan Section -->
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold" style="color: #1a1a1a;">No. Rujukan Surat Kelulusan KPP <span class="text-danger">*</span></label>
                                                            <p class="text-muted small mb-3">
                                                                <i class="fas fa-info-circle text-info me-1"></i>
                                                                Nombor rujukan ini dijana secara automatik apabila anda klik butang "Jana dan Cetak Surat" di atas. 
                                                                Nombor rujukan yang sama akan tertera pada surat yang dicetak.
                                                            </p>
                                                            <input type="text" class="form-control" name="no_rujukan_surat" id="noRujukanSurat" value="{{ old('no_rujukan_surat', $appeal->kpp_ref_no) }}" style="border: 1px solid #d1d5db; border-radius: 8px; padding: 12px;" {{ !$canSubmit ? 'readonly' : '' }} readonly>
                                                            @if(!empty($appeal->kpp_ref_no))
                                                            <small class="text-success mt-1 d-block">
                                                                <i class="fas fa-check-circle me-1"></i>Nombor rujukan telah dijana: <strong>{{ $appeal->kpp_ref_no }}</strong>
                                                            </small>
                                                            @endif
                                                        </div>
                                                        
                                                        <!-- Ulasan Section -->
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold" style="color: #1a1a1a;">Ulasan <span class="text-danger">*</span></label>
                                                            <p class="text-muted small mb-3">Sila nyatakan ulasan berkaitan dengan semakan/keputusan ini</p>
                                                            <textarea class="form-control" name="comments" id="ulasanField" rows="4" placeholder="Masukkan ulasan..." style="border: 1px solid #d1d5db; border-radius: 8px; padding: 12px;" {{ !$canSubmit ? 'readonly' : '' }}>{{ old('comments', $appeal->pk_comments) }}</textarea>
                                                        </div>
                                                        
                                                        <!-- Action Buttons - PK can only use once -->
                                                        <div class="d-flex justify-content-center gap-3 mt-4">
                                                            <button type="button" class="btn btn-sm" style="background-color: #1E293B; color: #fff; border: 1px solid #1E293B; border-radius: 8px; padding: 8px 20px;">
                                            <i class="fas fa-arrow-left me-2" style="color: #fff;"></i>Kembali
                                                            </button>
                                                            @if($canSubmit)
                                                            <button type="button" class="btn btn-sm" style="background-color: #007BFF; color: #fff; border: 1px solid #007BFF; border-radius: 8px; padding: 8px 20px;" id="simpanBtn" onclick="showSaveModal(savePkData)">
                                            <i class="fas fa-save me-2" style="color: #fff;"></i>Simpan
                                        </button>
                                                            <button type="button" class="btn btn-sm" style="background-color: #198754; color: #fff; border: 1px solid #198754; border-radius: 8px; padding: 8px 20px;" id="hantarBtn" onclick="showSubmitModal(submitPkForm)">
                                            <i class="fas fa-paper-plane me-2" style="color: #fff;"></i>Hantar
                                        </button>
                                        @else
                                                            <button type="button" class="btn btn-sm" style="background-color: #6c757d; color: #fff; border: 1px solid #6c757d; border-radius: 8px; padding: 8px 20px;" disabled title="Permohonan telah dihantar pada {{ $appeal->pk_submitted_at ? $appeal->pk_submitted_at->format('d M Y, h:i A') : '' }}">
                                                                <i class="fas fa-check-circle me-2" style="color: #fff;"></i>Telah Dihantar
                                                            </button>
                                        @endif
                                    </div>
                                                        
                                                        {{-- @if(!$canSubmit)
                                                        <div class="alert alert-info mt-3 text-center" style="border-radius: 8px;">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            <strong>Permohonan telah dihantar pada {{ $appeal->pk_submitted_at ? $appeal->pk_submitted_at->format('d M Y, h:i A') : '' }}</strong>
                                                            <br>
                                                            <small>Butang "Simpan" dan "Hantar" telah dilumpuhkan kerana permohonan ini telah dihantar.</small>
                                </div>
                                                        @endif --}}
                                    </form>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var pkForm = document.getElementById('pkReviewForm');
                                    if(pkForm) {
                                        pkForm.addEventListener('submit', function(e) {
                                            var submitButton = e.submitter;
                                            var action = submitButton ? submitButton.value : 'submit';
                                            
                                            // Auto-fill reference number if approved
                                            autoFillAfterSubmission();
                                            
                                            var status = document.querySelector('input[name="decision"]:checked');
                                            var ulasan = document.getElementById('ulasanField').value.trim();
                                            var suratKelulusan = document.getElementById('suratKelulusanKpp').value.trim();
                                            var noRujukan = document.getElementById('noRujukanSurat').value.trim();
                                            
                                            // Only validate for submit action, not save
                                            if (action === 'submit') {
                                            if (status && status.value === 'Tidak Diluluskan' && ulasan === '') {
                                                alert('Ulasan wajib diisi jika permohonan tidak diluluskan.');
                                                e.preventDefault();
                                                    return;
                                            }
                                            if (status && status.value === 'Diluluskan') {
                                                if (!suratKelulusan) {
                                                    alert('Sila muat naik Surat Kelulusan KPP.');
                                                    e.preventDefault();
                                                    return;
                                                }
                                                if (!noRujukan) {
                                                    alert('Sila masukkan No. Rujukan Surat Kelulusan KPP.');
                                                    e.preventDefault();
                                                    return;
                                                    }
                                                }
                                            }
                                        });
                                    }
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
                                                <title>Status Permohonan - PK(SPT)</title>
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

                                // Generate and Print Letter Function
                                function generateAndPrintLetter() {
                                    // Generate a unique reference number
                                    const today = new Date();
                                    const year = today.getFullYear();
                                    const month = String(today.getMonth() + 1).padStart(2, '0');
                                    const day = String(today.getDate()).padStart(2, '0');
                                    const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                                    
                                    const refNumber = `KPP/${year}${month}${day}/${randomNum}`;
                                    
                                    // Auto-fill the reference number
                                    document.getElementById('noRujukanSurat').value = refNumber;
                                    
                                    // Save the reference number to database immediately
                                    fetch('{{ route("appeals.update_reference", $appeal->id) }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                        },
                                        body: JSON.stringify({
                                            reference_number: refNumber
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            
                                            // Set the status to "Diluluskan" automatically
                                            const diluluskanRadio = document.querySelector('input[name="decision"][value="Diluluskan"]');
                                            if (diluluskanRadio) {
                                                diluluskanRadio.checked = true;
                                            }
                                            
                                            // Open the print letter page in a new tab AFTER saving
                                            const printUrl = '{{ route("appeals.KPP_letter", $appeal->id) }}';
                                            window.open(printUrl, '_blank');
                                            
                                            // Show success message with instructions
                                            alert(`✅ Surat kelulusan akan dijana dengan nombor rujukan: ${refNumber}\n\n📋 Arahan:\n1. Cetak surat yang dibuka dalam tab baru\n2. Simpan sebagai PDF\n3. Muat naik fail PDF tersebut dalam medan "Surat Kelulusan KPP"\n4. Klik "Hantar" untuk menyimpan keputusan`);
                                            
                                            // Focus on the file upload field
                                            setTimeout(() => {
                                                const fileInput = document.getElementById('suratKelulusanKpp');
                                                if (fileInput) {
                                                    fileInput.style.border = '2px solid #007bff';
                                                    fileInput.focus();
                                                }
                                            }, 100);
                                        } else {
                                            alert('❌ Ralat semasa menyimpan nombor rujukan. Sila cuba lagi.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error saving reference number:', error);
                                        alert('❌ Ralat semasa menyimpan nombor rujukan. Sila cuba lagi.');
                                    });
                                }

                                                        // Toggle Status Card Function
                                                        function toggleStatusCard(header) {
                                                            const cardBody = header.nextElementSibling;
                                                            const arrow = header.querySelector('.toggle-arrow i');
                                                            
                                                            if (cardBody.style.display === 'none') {
                                                                cardBody.style.display = 'block';
                                                                arrow.classList.remove('fa-chevron-right');
                                                                arrow.classList.add('fa-chevron-down');
                                                            } else {
                                                                cardBody.style.display = 'none';
                                                                arrow.classList.remove('fa-chevron-down');
                                                                arrow.classList.add('fa-chevron-right');
                                                            }
                                }

                                // Auto-fill functionality when form is submitted
                                function autoFillAfterSubmission() {
                                    const status = document.querySelector('input[name="decision"]:checked');
                                    if (status && status.value === 'Diluluskan') {
                                        // Auto-generate reference number if not filled
                                        if (!document.getElementById('noRujukanSurat').value) {
                                            const today = new Date();
                                            const year = today.getFullYear();
                                            const month = String(today.getMonth() + 1).padStart(2, '0');
                                            const day = String(today.getDate()).padStart(2, '0');
                                            const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                                            const refNumber = `KPP/${year}${month}${day}/${randomNum}`;
                                            document.getElementById('noRujukanSurat').value = refNumber;
                                        }
                                    }
                                }

                                // Show feedback when file is uploaded
                                document.getElementById('suratKelulusanKpp').addEventListener('change', function(e) {
                                    if (e.target.files.length > 0) {
                                        document.getElementById('fileUploadStatus').style.display = 'block';
                                        // Remove the highlight
                                        e.target.style.borderColor = '';
                                        e.target.style.borderWidth = '';
                                    }
                                });

                                // Save PK Data Function (AJAX - no page redirect)
                                function savePkData() {
                                    const simpanBtn = document.getElementById('simpanBtn');
                                    const originalText = simpanBtn.innerHTML;
                                    
                                    // Disable button and show loading
                                    simpanBtn.disabled = true;
                                    simpanBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                                    
                                    // Get form data
                                    const formData = new FormData(document.getElementById('pkReviewForm'));
                                    formData.append('action', 'save');
                                    
                                    // Send AJAX request
                                    fetch('{{ route("appeals.pk_submit", $appeal->id) }}', {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Show success message
                                            alert('✅ ' + data.message);
                                            
                                            // Show visual feedback
                                            simpanBtn.style.backgroundColor = '#28a745';
                                            simpanBtn.innerHTML = '<i class="fas fa-check me-2"></i>Disimpan';
                                            
                                            // Reset button after 2 seconds
                                            setTimeout(() => {
                                                simpanBtn.style.backgroundColor = '#007BFF';
                                                simpanBtn.innerHTML = originalText;
                                                simpanBtn.disabled = false;
                                            }, 2000);
                                        } else {
                                            alert('❌ Ralat: ' + (data.message || 'Gagal menyimpan data.'));
                                            simpanBtn.innerHTML = originalText;
                                            simpanBtn.disabled = false;
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('❌ Ralat sistem. Sila cuba lagi.');
                                        simpanBtn.innerHTML = originalText;
                                        simpanBtn.disabled = false;
                                    });
                                }

                                // KPV-08 Permit Approval Functions
                                function approveSelectedPermits() {
                                    const selectedPermits = document.querySelectorAll('.permit-approval:checked');
                                    if (selectedPermits.length === 0) {
                                        alert('Sila pilih sekurang-kurangnya satu permit untuk diluluskan.');
                                        return;
                                    }

                                    if (confirm(`Adakah anda pasti mahu meluluskan ${selectedPermits.length} permit yang dipilih?`)) {
                                        const remarks = document.getElementById('pk_remarks').value;
                                        
                                        selectedPermits.forEach(checkbox => {
                                            const permitId = checkbox.dataset.permitId;
                                            approvePermit(permitId, remarks);
                                        });
                                    }
                                }

                                function rejectSelectedPermits() {
                                    const selectedPermits = document.querySelectorAll('.permit-approval:checked');
                                    if (selectedPermits.length === 0) {
                                        alert('Sila pilih sekurang-kurangnya satu permit untuk ditolak.');
                                        return;
                                    }

                                    if (confirm(`Adakah anda pasti mahu menolak ${selectedPermits.length} permit yang dipilih?`)) {
                                        const remarks = document.getElementById('pk_remarks').value;
                                        
                                        selectedPermits.forEach(checkbox => {
                                            const permitId = checkbox.dataset.permitId;
                                            rejectPermit(permitId, remarks);
                                        });
                                    }
                                }

                                function approvePermit(permitId, remarks) {
                                    fetch(`{{ url('/appeals/approve-permit') }}/${permitId}`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                        },
                                        body: JSON.stringify({
                                            remarks: remarks
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Permit berjaya diluluskan!');
                                            location.reload();
                                        } else {
                                            alert('Ralat: ' + data.message);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Ralat sistem. Sila cuba lagi.');
                                    });
                                }

                                function rejectPermit(permitId, remarks) {
                                    fetch(`{{ url('/appeals/reject-permit') }}/${permitId}`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                        },
                                        body: JSON.stringify({
                                            remarks: remarks
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Permit berjaya ditolak!');
                                            location.reload();
                                        } else {
                                            alert('Ralat: ' + data.message);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Ralat sistem. Sila cuba lagi.');
                                    });
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
<!-- Include Modal Component -->
@include('components.modal_confirm')

<script>
// Form submission functions for PK
function submitPkForm() {
    const form = document.getElementById('pkReviewForm');
    if (form) {
        form.submit();
    }
}

// Keep the existing savePkData function but wrap it with modal
function savePkDataWithModal() {
    showSaveModal(savePkData);
}

// Handle form submission response
document.addEventListener('DOMContentLoaded', function() {
    // Check for success/error messages from server
    @if(session('success'))
        showSuccessModal();
    @endif
    
    @if(session('error'))
        showErrorModal();
    @endif
});
</script>

@endsection 