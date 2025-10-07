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
                            <div class="card border-0 shadow-sm rounded-3 mb-4">
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
                                                    {{ $appeal->id ?? 'RUJ-2025-001' }}
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

                            <!-- Tab Navigation for Officer View -->
                            <div class="card border-0 shadow-sm rounded-3 mb-4">
                                <div class="card-body">
                                    <ul class="nav nav-tabs mb-4" id="officerTab" role="tablist">
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

                                    <div class="tab-content" id="officerTabContent">
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
                                    @foreach($allFields as $field => $label)
                                        @if(!empty($perakuan->$field))
                                        <tr>
                                            <th width="200">{{ $label }}:</th>
                                            <td>{{ $perakuan->$field }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
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
                                            
                                            <div class="card border-0 shadow-sm rounded-3">
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
                                                                                    <a href="{{ $document['route'] }}" target="_blank" class="btn btn-sm" style="background-color: #1E40AF; color: #fff; border: 1px solid #1E40AF; border-radius: 6px; padding: 6px 12px;" title="Lihat Dokumen">
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


                                        </div>

                                        <!-- Tindakan Tab -->
                                        <div class="tab-pane fade" id="tindakan" role="tabpanel" aria-labelledby="tindakan-tab">
                                            <h5 class="mb-3 fw-bold" style="color: #1a1a1a;">Tindakan: Semakan Ulasan</h5>
                                            <p class="text-muted mb-4">Bahagian ini membolehkan anda memilih dan mengemaskini status semakan dokumen permohonan yang telah diterima.</p>
                                            
                                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body bg-white">
                                    <form method="POST" action="{{ route('appeals.ppl_submit', $appeal->id) }}" id="pplReviewForm">
                                        @csrf
                                                        
                                                        <!-- Semakan Section -->
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold" style="color: #1a1a1a;">Semakan <span class="text-danger">*</span></label>
                                                            <p class="text-muted small mb-3">Sila pilih semakan untuk permohonan ini</p>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="status" id="lengkap" value="Lengkap" {{ old('status', $appeal->ppl_status) == 'Lengkap' ? 'checked' : '' }}>
                                                                    <label class="form-check-label fw-medium" for="lengkap" style="color: #1a1a1a;">Lengkap</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="status" id="tidak_lengkap" value="Tidak Lengkap" {{ old('status', $appeal->ppl_status) == 'Tidak Lengkap' ? 'checked' : '' }}>
                                                                    <label class="form-check-label fw-medium" for="tidak_lengkap" style="color: #1a1a1a;">Tidak Lengkap</label>
                                            </div>
                                            </div>
                                        </div>
                                                        
                                                        <!-- Ulasan Section -->
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold" style="color: #1a1a1a;">Ulasan <span class="text-danger">*</span></label>
                                                            <p class="text-muted small mb-3">Sila nyatakan ulasan berkaitan dengan semakan ini</p>
                                                            <textarea class="form-control" name="comments" id="ulasanField" rows="4" placeholder="Masukkan ulasan..." style="border: 1px solid #d1d5db; border-radius: 8px; padding: 12px;">{{ old('comments', $appeal->ppl_comments) }}</textarea>
                                        </div>
                                                        
                                                        <!-- Action Buttons -->
                                                        <div class="d-flex justify-content-center gap-3 mt-4">
                                                            <button type="button" class="btn btn-sm" style="background-color: #1E293B; color: #fff; border: 1px solid #1E293B; border-radius: 8px; padding: 8px 20px;">
                                                <i class="fas fa-arrow-left me-2" style="color: #fff;"></i>Kembali
                                            </button>
                                                            <button type="button" class="btn btn-sm" style="background-color: #007BFF; color: #fff; border: 1px solid #007BFF; border-radius: 8px; padding: 8px 20px;">
                                                <i class="fas fa-save me-2" style="color: #fff;"></i>Simpan
                                            </button>
                                                            <button type="submit" class="btn btn-sm" style="background-color: #198754; color: #fff; border: 1px solid #198754; border-radius: 8px; padding: 8px 20px;" id="hantarBtn">
                                                <i class="fas fa-paper-plane me-2" style="color: #fff;"></i>Hantar
                                            </button>
                                        </div>
                                    </form>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            document.getElementById('pplReviewForm').addEventListener('submit', function(e) {
                                                var status = document.querySelector('input[name="status"]:checked');
                                                var ulasan = document.getElementById('ulasanField').value.trim();
                                                if (status && status.value === 'Tidak Lengkap' && ulasan === '') {
                                                    alert('Ulasan wajib diisi jika permohonan tidak lengkap.');
                                                    e.preventDefault();
                                                }
                                            });
                                        });

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
                                                        <title>Status Permohonan - PPL</title>
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