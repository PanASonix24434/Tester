@extends('layouts.app')
@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-white fw-semibold rounded-top" style="background-color: #007bff;">
                            Semakan Permohonan - PK(SPT)
                        </div>
                        <div class="card-body">
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
                                        <td><span class="badge bg-info text-white">{{ $appeal->status }}</span></td>
                                    </tr>
                                </table>
                            </div>
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
                                    <ul class="nav nav-tabs mb-4" id="pkTab" role="tablist">
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

                                    <div class="tab-content" id="pkTabContent">
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
                        </div>
                    </div>
                        </div>
                    </div>
                    
                    <!-- KPV-08 Permit Approval Section -->
                    @if($perakuan->type === 'kvp08')
                    <div class="card border-0 shadow-sm rounded-3 mt-4">
                        <div class="card-body bg-white">
                            <h6 class="fw-bold mb-0" style="color: #1976d2;">Kelulusan Permit Lanjutan Tempoh</h6>
                            <div style="border-bottom: 3px solid #1976d2; margin-bottom: 24px; margin-top: 2px;"></div>
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Maklumat:</strong> Sila pilih permit yang diluluskan untuk lanjutan tempoh.
                            </div>
                            
                            @php
                                $kvp08Applications = \App\Models\Kpv08Application::where('appeal_id', $perakuan->appeal_id)->get();
                            @endphp
                            
                            @if($kvp08Applications->count() > 0)
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Bil</th>
                                                <th>No. Permit</th>
                                                <th>Jenis Permit</th>
                                                <th>Zon</th>
                                                <th>Tempoh Lanjutan</th>
                                                <th>Tarikh Luput Baru</th>
                                                <th>Status</th>
                                                <th>Kelulusan PK(SPT)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($kvp08Applications as $index => $kvp08App)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $kvp08App->permit->permit_number }}</td>
                                                    <td>{{ $kvp08App->permit->permit_type }}</td>
                                                    <td>{{ $kvp08App->permit->zone }}</td>
                                                    <td>{{ $kvp08App->extension_period }}</td>
                                                    <td>{{ $kvp08App->new_expiry_date->format('d/m/Y') }}</td>
                                                    <td>
                                                        @if($kvp08App->status === 'submitted')
                                                            <span class="badge bg-warning">Menunggu Semakan</span>
                                                        @elseif($kvp08App->status === 'approved')
                                                            <span class="badge bg-success">Diluluskan</span>
                                                        @elseif($kvp08App->status === 'rejected')
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($kvp08App->status === 'submitted')
                                                            <div class="form-check">
                                                                <input class="form-check-input permit-approval" 
                                                                       type="checkbox" 
                                                                       id="approve_permit_{{ $kvp08App->id }}"
                                                                       data-permit-id="{{ $kvp08App->id }}"
                                                                       value="1">
                                                                <label class="form-check-label" for="approve_permit_{{ $kvp08App->id }}">
                                                                    Lulus
                                                                </label>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">
                                                                {{ $kvp08App->is_approved_by_pk ? 'Diluluskan' : 'Ditolak' }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="pk_remarks" class="form-label fw-bold">Ulasan PK(SPT)</label>
                                    <textarea class="form-control" id="pk_remarks" name="pk_remarks" rows="3" placeholder="Masukkan ulasan jika perlu..."></textarea>
                                </div>
                                
                                <div class="text-center mb-3">
                                    <button type="button" class="btn btn-success me-2" onclick="approveSelectedPermits()">
                                        <i class="fas fa-check me-2"></i>Lulus Permit Terpilih
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="rejectSelectedPermits()">
                                        <i class="fas fa-times me-2"></i>Tolak Permit Terpilih
                                    </button>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Tiada permohonan lanjutan tempoh ditemui.
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Review Form -->
                    <div class="card border-0 shadow-sm rounded-3 mt-4">
                        <div class="card-body bg-white">
                            <h6 class="fw-bold mb-0" style="color: #1976d2;">Keputusan Permohonan</h6>
                            <div style="border-bottom: 3px solid #1976d2; margin-bottom: 24px; margin-top: 2px;"></div>
                            <form method="POST" action="{{ route('appeals.pk_submit', $appeal->id) }}" enctype="multipart/form-data" id="pkReviewForm">
                                        @csrf
                                        <div class="mb-3 mt-3">
                                            <label class="form-label fw-bold">Surat Kelulusan KPP :</label>
                                    <input type="file" class="form-control" name="surat_kelulusan_kpp" id="suratKelulusanKpp" accept=".pdf,.png,.jpg,.jpeg" @if(!$canEdit) disabled @endif>
                                    <small class="form-text text-muted">Hanya PDF, PNG, JPG, atau JPEG. Saiz maksimum 5MB.</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">No. Rujukan Surat Kelulusan KPP</label>
                                    <input type="text" class="form-control" name="no_rujukan_surat" id="noRujukanSurat" value="{{ old('no_rujukan_surat', $appeal->pk_no_rujukan_surat) }}" @if(!$canEdit) disabled @endif>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Keputusan Permohonan :</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="diluluskan" value="Diluluskan" {{ old('status', $appeal->pk_status) == 'Diluluskan' ? 'checked' : '' }} @if(!$canEdit) disabled @endif>
                                                <label class="form-check-label" for="diluluskan">Diluluskan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="tidak_diluluskan" value="Tidak Diluluskan" {{ old('status', $appeal->pk_status) == 'Tidak Diluluskan' ? 'checked' : '' }} @if(!$canEdit) disabled @endif>
                                                <label class="form-check-label" for="tidak_diluluskan">Tidak Diluluskan</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ulasan KPP</label>
                                    <textarea name="comments" class="form-control" id="ulasanKppField" rows="4" placeholder="Masukkan ulasan anda..." @if(!$canEdit) disabled @endif>{{ old('comments', $appeal->pk_comments) }}</textarea>
                                        </div>
                                <div class="d-flex justify-content-end gap-2 bg-white p-2" style="border-radius: 0 0 0.5rem 0.5rem;">
                                    <a href="{{ route('appeals.amendment') }}" class="btn btn-outline-secondary">Kembali</a>
                                            @if($canEdit)
                                        <button type="submit" name="action" value="save" class="btn btn-outline-primary">Simpan</button>
                                        <button type="submit" name="action" value="submit" class="btn btn-primary" id="hantarPkBtn">Hantar</button>
                                            @else
                                                <span class="text-muted">Permohonan tidak boleh diedit kerana status bukan "Tidak Lengkap".</span>
                                            @endif
                                        </div>
                                    </form>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var pkForm = document.getElementById('pkReviewForm');
                                    if(pkForm) {
                                        pkForm.addEventListener('submit', function(e) {
                                            var status = document.querySelector('input[name="status"]:checked');
                                            var ulasan = document.getElementById('ulasanKppField').value.trim();
                                            var suratKelulusan = document.getElementById('suratKelulusanKpp').value.trim();
                                            var noRujukan = document.getElementById('noRujukanSurat').value.trim();
                                            if (status && status.value === 'Tidak Diluluskan' && ulasan === '') {
                                                alert('Ulasan wajib diisi jika permohonan tidak diluluskan.');
                                                e.preventDefault();
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
                                        });
                                    }
                                });

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
                                    fetch(`/appeals/approve-permit/${permitId}`, {
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
                                    fetch(`/appeals/reject-permit/${permitId}`, {
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
@endsection 