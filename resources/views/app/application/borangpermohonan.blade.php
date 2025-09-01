@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container-fluid py-4 px-3 px-md-4">
            <div class="card border-0 shadow-sm rounded-3">
                {{-- Modern Header --}}
                <div class="card-header text-white fw-semibold rounded-top" style="background-color: #007bff;">
                    Lain-lain Permohonan
                </div>

                {{-- Table --}}
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 text-nowrap">
                            <thead class="table-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="text-center" style="width: 60px;">Bil</th>
                                    <th>Jenis Permohonan</th>
                                    <th class="text-center" style="width: 80px;">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $i => $app)
                                <tr class="align-middle hover-row">
                                    <td class="text-center text-muted">{{ $i + 1 }}</td>
                                    <td class="fw-medium text-dark">{{ $app['name'] }}</td>
                                    <td class="text-center">
                                        @if($app['name'] === 'Permohonan Rayuan Pindaan Syarat')
                                            <a href="{{ route('appeals.borang_permohonan_butiran') }}" class="btn btn-sm btn-light border shadow-sm" title="Edit">
                                                <i class="fas fa-edit text-dark"></i>
                                            </a>
                                        @elseif($app['name'] === 'Permohonan Lanjutan Tempoh Sah Kelulusan Perolehan')
                                            <a href="{{ route('application.lanjutan-tempoh.index') }}" class="btn btn-sm btn-light border shadow-sm" title="Buka">
                                                <i class="fas fa-edit text-dark"></i>
                                            </a>
                                        @else
                                            <a >
                                                -</i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-end p-3">
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">&lt;</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&gt;</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>


{{-- Modern UI Styling --}}
<style>
    .table th,
    .table td {
        padding: 14px 16px;
        font-size: 14px;
    }

    .hover-row:hover {
        background-color: #f8f9fc;
        transition: background-color 0.2s ease;
    }

    .card-header {
        font-size: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-light:hover {
        background-color: #e2e6ea;
    }

    .pagination .page-link {
        border-radius: 6px;
    }

    .table td i {
        font-size: 14px;
    }
</style>

@endsection
