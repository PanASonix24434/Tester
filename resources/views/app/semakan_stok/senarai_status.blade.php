
<div class="mb-2" style="border-bottom: 3px solid #007bff; width: fit-content; margin-left:16px;">
    <span class="fw-bold" style="color:#007bff;">Senarai Status Stok Semasa</span>
</div>

@if($selectedYear)
<div class="table-responsive" style="padding-left:16px; padding-right:16px;">
    <style>
        .grouped-table {
            border-collapse: collapse;
        }
        .grouped-table th {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 12px 8px;
            font-weight: bold;
            border: 1.5px solid #e3e6f0;
        }
        .grouped-table td {
            padding: 12px 8px;
            vertical-align: middle;
            border: 1.5px solid #e3e6f0;
            background: #fff;
        }
        .fish-type-header {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #1976d2;
        }
        .fma-cell {
            background-color: #f8f9fa;
            text-align: center;
            font-weight: bold;
            color: #424242;
        }
        .stock-cell {
            text-align: center;
            font-weight: 500;
            background-color: #f8f9fa;
        }
        .row-number {
            background-color: #e9ecef;
            text-align: center;
            font-weight: bold;
            color: #495057;
        }
        .grouped-table tbody tr:hover {
            background-color: #f5f5f5;
        }
        .grouped-table tbody tr:hover td {
            background-color: #f5f5f5;
        }
    </style>
    <table class="table table-bordered grouped-table">
        <thead>
            <tr>
                <th style="width: 60px;">Bil</th>
                <th style="min-width: 180px;">Kumpulan Ikan</th>
                <th style="min-width: 100px;">FMA</th>
                <th style="min-width: 120px;">Jenis</th>
                <th style="min-width: 150px;">Butiran</th>
                <th style="min-width: 120px;">Jenis Sumber</th>
                <th style="min-width: 120px;">Bilangan Stok</th>
                <th style="min-width: 100px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @if(count($statusStocks) > 0)
                @php 
                    $rowNumber = 1;
                    $groupedStatusStocks = $statusStocks->groupBy('fish_type_id')->sortBy(function ($stocks, $fishTypeId) {
                        return $stocks->first()->fishType->name;
                    });
                @endphp
                @forelse($groupedStatusStocks as $fishTypeId => $stocks)
                    @php 
                        $validStocks = $stocks->filter(function($stock) {
                            return $stock && $stock->fishType && $stock->fma;
                        });
                        $firstStock = $validStocks->first();
                    @endphp
                    @if($firstStock && $firstStock->fishType && $validStocks->count() > 0)
                        @php $stockCount = $validStocks->count(); @endphp
                        @foreach($validStocks as $index => $stock)
                            <tr>
                                @if($index === 0)
                                    <td rowspan="{{ $stockCount }}" class="row-number">
                                        {{ $rowNumber }}
                                    </td>
                                    <td rowspan="{{ $stockCount }}" class="fish-type-header">
                                        <strong>{{ $stock->fishType->name ?? 'N/A' }}</strong>
                                    </td>
                                @endif
                                <td class="fma-cell">
                                    {{ $stock->fma }}
                                </td>
                                <td class="text-center">
                                    @if($stock->selection_type === 'vesel')
                                        Vesel
                                    @elseif($stock->selection_type === 'zon')
                                        Zon
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($stock->selection_type === 'vesel')
                                        {{ $stock->vesel_type ?? '-' }}
                                    @elseif($stock->selection_type === 'zon')
                                        {{ $stock->zon_type ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $stock->jenis_sumber ?? '-' }}
                                </td>
                                <td class="stock-cell">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="fw-bold me-1">{{ number_format($stock->bilangan_stok) }}</span>
                                        <small class="text-muted">unit</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($stock->status === 'draft')
                                        <span class="badge bg-warning text-dark">Draf</span>
                                    @elseif($stock->status === 'submitted')
                                        <span class="badge bg-info">Dihantar</span>
                                    @elseif($stock->pengesahan_status === 'approved')
                                        <span class="badge bg-success">Diluluskan</span>
                                    @elseif($stock->pengesahan_status === 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @php $rowNumber++; @endphp
                    @endif
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <br>
                            <span class="text-muted">Tiada data untuk tahun ini.</span>
                        </td>
                    </tr>
                @endforelse
            @else
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                        <br>
                        <span class="text-muted">Tiada data untuk tahun ini.</span>
                    </td>
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
    // Go back to previous page or specific route
    window.history.back();
}

function saveData() {
    // Show success message
    Swal.fire({
        icon: 'success',
        title: 'Berjaya!',
        text: 'Data telah berjaya disimpan.',
        confirmButtonText: 'OK'
    });
}

function goNext() {
    // Navigate to dokumen_permohonan tab
    const currentYear = '{{ $selectedYear }}';
    window.location.href = `?tab=dokumen_permohonan&tahun=${currentYear}`;
}
</script> 