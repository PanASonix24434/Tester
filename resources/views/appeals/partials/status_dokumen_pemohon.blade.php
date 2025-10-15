
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
                    @foreach($allDocuments as $index => $doc)
                        <tr>
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">
                                @php
                                    $typeLabels = [
                                        'bina_baru' => 'Vesel Bina Baru',
                                        'bina_baru_luar_negara' => 'Vesel Bina Baru Luar Negara',
                                        'terpakai' => 'Vesel Terpakai',
                                        'pangkalan' => 'Pangkalan',
                                        'bahan_binaan' => 'Bahan binaan',
                                        'tukar_peralatan' => 'Tukar Peralatan'
                                    ];
                                @endphp
                                {{ $typeLabels[$doc->file_type] ?? ucfirst(str_replace('_', ' ', $doc->file_type)) }}
                            </td>
                            <td class="py-3 px-4">{{ $doc->file_name }}</td>
                            <td class="py-3 px-4">{{ $doc->created_at ? $doc->created_at->format('d M Y') : 'N/A' }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="btn-group" role="group">
                                    @if($doc->file_path)
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm me-2" style="background-color: #1E40AF; color: #fff; border: 1px solid #1E40AF; border-radius: 6px; padding: 6px 12px;" title="Lihat Dokumen">
                                            <i class="fas fa-search" style="color: #fff;"></i>
                                        </a>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" download class="btn btn-sm" style="background-color: #059669; color: #fff; border: 1px solid #059669; border-radius: 6px; padding: 6px 12px;" title="Muat Turun Dokumen">
                                            <i class="fas fa-download" style="color: #fff;"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">Tiada pautan</span>
                                    @endif
                                </div>
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
    <button type="button" class="btn btn-sm" style="background-color: #F0F4F5; color: #000; border: 1px solid #F0F4F5; border-radius: 8px;" onclick="nextTab('perakuan-status-tab')">
        Seterusnya <i class="fas fa-arrow-right ms-2" style="color: #000;"></i>
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