
{{-- Get ALL documents for this appeal --}}
@php
    $allDocuments = \App\Models\DokumenSokongan::where('appeals_id', $appeal->id)->get();
    $perakuan = \App\Models\Perakuan::where('appeal_id', $appeal->id)->first();
    $amendmentType = $perakuan ? $perakuan->jenis_pindaan_syarat : null;
    $perolehanType = $perakuan ? $perakuan->jenis_perolehan : null;
@endphp

{{-- Show all uploaded documents --}}
@if($allDocuments->count() > 0)
    <div class="mb-4">
        <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Semua Dokumen Yang Dimuat Naik</h6>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Bil</th>
                        <th>Nama Dokumen</th>
                        <th>Jenis Dokumen</th>
                        <th>Saiz Fail</th>
                        <th>Tarikh Muat Naik</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allDocuments as $index => $doc)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $doc->file_name }}</td>
                            <td>
                                @php
                                    $typeLabels = [
                                        'bina_baru' => 'Vesel Bina Baru',
                                        'bina_baru_luar_negara' => 'Vesel Bina Baru Luar Negara',
                                        'terpakai' => 'Vesel Terpakai',
                                        'pangkalan' => 'Pangkalan',
                                        'bahan_binaan' => 'Bahan Binaan Vesel',
                                        'tukar_peralatan' => 'Tukar Peralatan'
                                    ];
                                @endphp
                                <span class="badge bg-secondary">{{ $typeLabels[$doc->file_type] ?? ucfirst($doc->file_type) }}</span>
                            </td>
                            <td>{{ $doc->getFileSizeInMB() }} MB</td>
                            <td>{{ $doc->upload_date ? $doc->upload_date->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <span class="badge bg-success">Dimuat Naik</span>
                            </td>
                            <td>
                                @if($doc->file_path)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">Tiada pautan</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>Tiada dokumen dimuat naik untuk permohonan ini.
    </div>
@endif


<!-- Navigation Buttons -->
<div class="text-center mt-4">
    <button type="button" class="btn btn-sm" style="background-color: #282c34; color: #fff; border: 1px solid #282c34; border-radius: 8px;" onclick="prevTab('butiran-status-tab')">
        <i class="fas fa-arrow-left ms-2" style="color: #fff;"></i> Kembali
    </button>
    <button type="button" class="btn btn-sm" style="background-color: #3c2387; color: #fff; border: 1px solid #3c2387; border-radius: 8px;" onclick="nextTab('perakuan-status-tab')">
        Seterusnya <i class="fas fa-arrow-right ms-2" style="color: #fff;"></i>
    </button>
</div>

<script>
// Tab Navigation Functions
function nextTab(tabId) {
    const tabButton = document.querySelector(`#${tabId}`);
    if (tabButton) {
        const tab = new bootstrap.Tab(tabButton);
        tab.show();
    }
}

function prevTab(tabId) {
    const tabButton = document.querySelector(`#${tabId}`);
    if (tabButton) {
        const tab = new bootstrap.Tab(tabButton);
        tab.show();
    }
}
</script>