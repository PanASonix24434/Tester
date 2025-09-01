@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <h2 class="mt-3 mb-4">Semakan Stok - Senarai Status</h2>
                    
                    <!-- Year Selection -->
                    <div class="card mb-4">
                        <div class="card-header text-white" style="background-color: #007bff;">
                            <h5 class="mb-0">Pilih Tahun</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('semakan-stok.senarai-status') }}" class="row align-items-end">
                                <div class="col-md-4">
                                    <label for="tahun" class="form-label">Tahun:</label>
                                    <select class="form-control" id="tahun" name="tahun" onchange="this.form.submit()">
                                        <option value="">-- Pilih Tahun --</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Tunjuk Data</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($selectedYear)
                        <!-- Licensing Quota Table -->
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #28a745;">
                                <h5 class="mb-0">
                                    <i class="fas fa-table me-2"></i>
                                    Kuota Pelesenan Mengikut FMA - Tahun {{ $selectedYear }}
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($licensingQuotas && $licensingQuotas->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 200px; background-color: #ffc107;">FMA</th>
                                                    <th class="text-center" style="background-color: #ffc107;">01</th>
                                                    <th class="text-center" style="background-color: #ffc107;">02</th>
                                                    <th class="text-center" style="background-color: #ffc107;">03</th>
                                                    <th class="text-center" style="background-color: #ffc107;">04</th>
                                                    <th class="text-center" style="background-color: #ffc107;">05</th>
                                                    <th class="text-center" style="background-color: #ffc107;">06</th>
                                                    <th class="text-center" style="background-color: #ffc107;">07</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($licensingQuotas as $quota)
                                                    <tr>
                                                        <td class="fw-bold">
                                                            @if($quota->sub_category)
                                                                {{ $quota->category }} {{ $quota->sub_category }}
                                                            @else
                                                                {{ $quota->category }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center {{ $quota->fma_01 > 0 ? 'table-primary' : 'table-secondary' }}">
                                                            {{ $quota->fma_01 > 0 ? $quota->fma_01 : '-' }}
                                                        </td>
                                                        <td class="text-center {{ $quota->fma_02 > 0 ? 'table-primary' : 'table-secondary' }}">
                                                            {{ $quota->fma_02 > 0 ? $quota->fma_02 : '-' }}
                                                        </td>
                                                        <td class="text-center {{ $quota->fma_03 > 0 ? 'table-primary' : 'table-secondary' }}">
                                                            {{ $quota->fma_03 > 0 ? $quota->fma_03 : '-' }}
                                                        </td>
                                                        <td class="text-center {{ $quota->fma_04 > 0 ? 'table-primary' : 'table-secondary' }}">
                                                            {{ $quota->fma_04 > 0 ? $quota->fma_04 : '-' }}
                                                        </td>
                                                        <td class="text-center {{ $quota->fma_05 > 0 ? 'table-primary' : 'table-secondary' }}">
                                                            {{ $quota->fma_05 > 0 ? $quota->fma_05 : '-' }}
                                                        </td>
                                                        <td class="text-center {{ $quota->fma_06 > 0 ? 'table-primary' : 'table-secondary' }}">
                                                            {{ $quota->fma_06 > 0 ? $quota->fma_06 : '-' }}
                                                        </td>
                                                        <td class="text-center {{ $quota->fma_07 > 0 ? 'table-primary' : 'table-secondary' }}">
                                                            {{ $quota->fma_07 > 0 ? $quota->fma_07 : '-' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Legend -->
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Keterangan:</h6>
                                                <ul class="list-unstyled">
                                                    <li><span class="badge bg-primary me-2">Biru</span> - Ada kuota</li>
                                                    <li><span class="badge bg-secondary me-2">Kelabu</span> - Tiada kuota</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">FMA Areas:</h6>
                                                <ul class="list-unstyled small">
                                                    <li><strong>FMA01:</strong> Perlis, Kedah, Pulau Pinang, Perak & Selangor</li>
                                                    <li><strong>FMA02:</strong> Negeri Sembilan, Melaka & Johor Barat</li>
                                                    <li><strong>FMA03:</strong> Kelantan & Terengganu</li>
                                                    <li><strong>FMA04:</strong> Pahang & Johor Timur</li>
                                                    <li><strong>FMA05:</strong> Sarawak</li>
                                                    <li><strong>FMA06:</strong> Limbang Lawas</li>
                                                    <li><strong>FMA07:</strong> Labuan</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Tiada data kuota pelesenan dijumpai untuk tahun {{ $selectedYear }}.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status Stock Summary -->
                        @if($statusStocks && $statusStocks->count() > 0)
                            <div class="card mt-4">
                                <div class="card-header text-white" style="background-color: #17a2b8;">
                                    <h5 class="mb-0">
                                        <i class="fas fa-chart-bar me-2"></i>
                                        Ringkasan Status Stok - Tahun {{ $selectedYear }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-primary">{{ count($statusStocks) }}</h4>
                                                <p class="text-muted mb-0">Jumlah Rekod</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-success">{{ $statusStocks->where('status', 'submitted')->count() }}</h4>
                                                <p class="text-muted mb-0">Dihantar</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-warning">{{ $statusStocks->where('status', 'draft')->count() }}</h4>
                                                <p class="text-muted mb-0">Draft</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-info">{{ $fmas->count() }}</h4>
                                                <p class="text-muted mb-0">FMA Areas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Sila pilih tahun untuk melihat data semakan stok.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when year changes
    const tahunSelect = document.getElementById('tahun');
    if (tahunSelect) {
        tahunSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>
@endsection 