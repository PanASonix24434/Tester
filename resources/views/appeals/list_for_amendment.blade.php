@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container-fluid py-4 px-3 px-md-4">
            <div class="card border-0 shadow-sm rounded-3">
                {{-- Header --}}
                <div class="card-header text-white fw-semibold rounded-top" style="background-color: #007bff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if($applicationType === 'kvp07')
                                Senarai Permohonan Rayuan Pindaan Syarat (KPV-07)
                            @elseif($applicationType === 'kvp08')
                                Senarai Permohonan Lanjut Tempoh Sah Kelulusan Perolehan (KPV-08)
                            @else
                                Lain-lain Permohonan
                            @endif
                        </div>
                        @if($applicationType)
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-arrow-left me-2"></i>
                                Kembali ke Laman Utama
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <div class="card-body p-0">
                    <div id="amendment-list">
                        @include('appeals.list_for_amendment_table', ['appeals' => $applications])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th, .table td {
        padding: 14px 16px;
        font-size: 14px;
    }
    @media (max-width: 575.98px) {
        .table th, .table td {
            font-size: 12px;
            padding: 8px 6px;
        }
        .card-header {
            font-size: 14px;
        }
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

<script>
    window.Echo.channel('amendments')
        .listen('AppealUpdated', (e) => {
            fetch('{{ url("/amendments/list") }}')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('amendment-list').innerHTML = html;
                });
        });
</script>

@endsection
