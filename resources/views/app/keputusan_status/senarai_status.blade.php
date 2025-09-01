@php
    $selectedYear = request('tahun');
    $statusStocks = $selectedYear 
        ? \App\Models\StatusStock::with('fishType')->where('tahun', $selectedYear)->whereNotNull('fish_type_id')->get()
        : collect();
    
    // Get unique FMAs
    $fmas = $statusStocks->pluck('fma')->unique()->sort()->values();
@endphp

<div class="mb-2" style="border-bottom: 3px solid #007bff; width: fit-content; margin-left:16px;">
    <span class="fw-bold" style="color:#007bff;">Senarai Status Stok untuk Keputusan</span>
</div>

@if($selectedYear)
    <div class="table-responsive" style="padding-left:16px; padding-right:16px;">
        <table class="table table-bordered" style="background:#fff; border:1.5px solid #e3e6f0;">
            <thead class="table-light">
                <tr>
                    <th rowspan="2" class="align-middle text-center" style="min-width:180px; border:1.5px solid #e3e6f0; background:#fff;">Kumpulan Ikan</th>
                    <th colspan="{{ count($fmas) }}" class="text-center" style="border:1.5px solid #e3e6f0; background:#fff;">Bilangan Stok</th>
                </tr>
                <tr>
                    @foreach($fmas as $fma)
                        <th class="text-center" style="border:1.5px solid #e3e6f0; background:#fff;">{{ $fma }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if(count($statusStocks) > 0)
                    @foreach($fishTypes as $fishType)
                    <tr>
                        <td style="border:1.5px solid #e3e6f0; background:#fff;">{{ $fishType->name }}</td>
                        @foreach($fmas as $fma)
                            @php
                                $stock = $statusStocks->first(function($item) use ($fishType, $fma) {
                                    return $item->fish_type_id === $fishType->id && $item->fma === $fma;
                                });
                            @endphp
                            <td style="border:1.5px solid #e3e6f0; background:#fff;">
                                <input type="text" class="form-control text-center" value="{{ $stock ? $stock->bilangan_stok : '' }}" readonly style="background:#f5f6fa;">
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="{{ 1 + count($fmas) }}" class="text-center" style="border:1.5px solid #e3e6f0; background:#fff;">Tiada data untuk tahun ini.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Navigation Buttons -->
    <div class="d-flex justify-content-center align-items-center mt-4" style="padding-left:16px; padding-right:16px;">
        <div class="me-3">
            <button type="button" class="btn btn-outline-secondary" onclick="goBack()" style="background-color: white; color: #6c757d; border-color: #6c757d;">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
        </div>
        <div class="me-3">
            <button type="button" class="btn btn-outline-primary" onclick="saveData()" style="background-color: white; color: #007bff; border-color: #007bff;">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
        <div>
            <button type="button" class="btn btn-primary" onclick="goNext()" style="background-color: #007bff; color: white; border-color: #007bff;">
                Seterusnya <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>
@else
    <div class="text-center py-5" style="padding-left:16px; padding-right:16px;">
        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">Sila Pilih Tahun</h5>
        <p class="text-muted">Pilih tahun untuk melihat senarai status stok</p>
    </div>
@endif

<script>
function goBack() {
    window.history.back();
}

function saveData() {
    Swal.fire({
        icon: 'success',
        title: 'Berjaya!',
        text: 'Data telah berjaya disimpan.',
        confirmButtonText: 'OK'
    });
}

function goNext() {
    const currentYear = '{{ $selectedYear }}';
    if (currentYear) {
        window.location.href = `?tab=dokumen_permohonan&tahun=${currentYear}`;
    } else {
        alert('Sila pilih tahun terlebih dahulu');
    }
}
</script> 