

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Maklumat Penuh</h4>
        </div>

        <div class="card-body">
            <!-- Kulit Details -->
            <h5 class="mb-3 text-primary">Maklumat Kulit</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td class="fw-bold bg-light">No. Rujukan Permohonan</td>
                            <td>
                                @if($user->is_admin && isset($kulit->no_rujukan_permohonan))
                                    <a href="{{ route('permohonan.show', $kulit->no_rujukan_permohonan) }}" class="text-decoration-none text-primary">
                                        {{ $kulit->no_rujukan_permohonan }}
                                    </a>
                                @else
                                    {{ $kulit->no_rujukan_permohonan ?? 'Tiada' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">No. Pendaftaran Kapal</td>
                            <td>{{ $kulit->no_pendaftaran_kapal ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Panjang (m)</td>
                            <td>{{ $kulit->panjang ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Lebar (m)</td>
                            <td>{{ $kulit->lebar ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Dalam (m)</td>
                            <td>{{ $kulit->dalam ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Jenis Kulit</td>
                            <td>{{ $kulit->jenis_kulit ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Tarikh Kulit Dilesenkan</td>
                            <td>{{ $kulit->tarikh_kulit_dilesenkan ? \Carbon\Carbon::parse($kulit->tarikh_kulit_dilesenkan)->format('d-m-Y') : 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Status Kulit</td>
                            <td>{{ $kulit->status_kulit ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Catatan</td>
                            <td>{{ $kulit->catatan ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Status Aktif</td>
                            <td>
                                <span class="badge {{ $kulit->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $kulit->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Muatan Details (if exists) -->
            @if($muatan)
            <h5 class="mt-4 text-primary">Maklumat Muatan</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td class="fw-bold bg-light">GT 1</td>
                            <td>{{ $muatan->gt_1 ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">GT 2</td>
                            <td>{{ $muatan->gt_2 ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">GRT 1</td>
                            <td>{{ $muatan->grt_1 ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">GRT 2</td>
                            <td>{{ $muatan->grt_2 ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Status Aktif</td>
                            <td>
                                <span class="badge {{ $muatan->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $muatan->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
            <h5 class="mt-4 text-primary">Maklumat Muatan</h5>
            <div class="alert alert-warning">Tiada maklumat muatan.</div>
            @endif
        </div>
    </div>
</div>

