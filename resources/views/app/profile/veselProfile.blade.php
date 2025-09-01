@extends('layouts.app')

@push('styles')
<link href="{{ asset('node_modules/dropzone/dist/dropzone.css') }}" rel="stylesheet">
@endpush

@section('content')

<!-- Page Content -->
<div id="app-content">
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="mb-5">
                        <h3 class="mb-0">Senarai Vesel</h3>
                    </div>
                </div>
            </div>

            <!-- Search/Filter Section -->
            <div class="card mb-4">
                <div class="card-body">
                <form method="GET" action="{{ route('profile.veselProfile') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label>No. Pendaftaran Vesel:</label>
                                <input type="text" name="no_pendaftaran" class="form-control" value="{{ request('no_pendaftaran') }}">
                            </div>
                            <div class="col-md-3">
                                <label>No. IC/No. Pendaftaran Syarikat :</label>
                                <input type="text" name="no_ic_syarikat" class="form-control" value="{{ request('no_ic_syarikat') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Negeri:</label>
                                <input type="text" name="negeri" class="form-control" value="{{ request('negeri') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Daerah:</label>
                                <input type="text" name="daerah" class="form-control" value="{{ request('daerah') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Pangkalan:</label>
                                <input type="text" name="pangkalan" class="form-control" value="{{ request('pangkalan') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Zon:</label>
                                <input type="text" name="zon" class="form-control" value="{{ request('zon') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Status Vesel:</label>
                                <select name="status_vesel" class="form-control">
                                    <option value="">Pilih Status</option>
                                    <option value="1" {{ request('status_vesel') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status_vesel') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ route('profile.veselProfile') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 text-nowrap table-centered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bil</th>
                                        <th>No. Pendaftaran Vesel</th>
                                        <th>No. IC/No. Pendaftaran Syarikat</th>
                                        <th>Negeri</th>
                                        <th>Daerah</th>
                                        <th>Pangkalan</th>
                                        <th>Zon</th>
                                        <th>Bil. Enjin</th>
                                        <th>Tarikh Mula</th>
                                        <th>Tarikh Tamat Lesen</th>
                                        <th>Baki Tempoh Sah LPI 1B/95</th>
                                        <th>Status Vesel</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vessels as $index => $vessel)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $vessel->no_pendaftaran }}</td>
                                        <td>{{ $vessel->no_ic_atau_syarikat}}</td>
                                        <td>{{ $vessel->negeri }}</td>
                                        <td>{{ $vessel->daerah }}</td>
                                        <td>{{ $vessel->pangkalan }}</td>
                                        <td>{{ $vessel->zon }}</td>
                                        <td>{{ $vessel->bil_enjin }}</td>
                                        <td>{{ $vessel->tarikh_mula ? $vessel->tarikh_mula->format('d-m-Y') : '-' }}</td>
                                        <td>{{ $vessel->tarikh_tamat_lesen ? $vessel->tarikh_tamat_lesen->format('d-m-Y') : '-' }}</td>
                                        <td>5 Bulan 15 Hari</td>
                                        <td>

                                            @php
                                                if ( $vessel->status_vesel == 1) {
                                                    $badgeClass = 'badge-success-soft text-dark-success';
                                                    $statusText = 'Aktif';
                                                } elseif ( $vessel->status_vesel == 0) {
                                                    $badgeClass = 'badge-warning-soft text-dark-warning';
                                                    $statusText = 'Tidak Aktif';
                                                } else {
                                                    $badgeClass = 'badge-danger-soft text-dark-danger';
                                                    $statusText = 'Batal';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('profile.veselProfile.show', $vessel->id) }}" class="btn btn-primary btn-icon">
                                                <i class="fas fa-search" style="color: #ffffff;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">Tiada data vesel tersedia.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $vessels->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('node_modules/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('node_modules/flatpickr/dist/flatpickr.min.js') }}"></script>
<script src="{{ asset('node_modules/quill/dist/quill.min.js') }}"></script>
@endpush