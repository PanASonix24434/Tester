

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0" style="color: white;">Maklumat Penuh</h4>
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
                        <!-- <tr>
                            <td class="fw-bold bg-light">Status Kulit</td>
                            <td>{{ $kulit->status_kulit ?? 'Tiada' }}</td>
                        </tr> -->
                        <tr>
                            <td class="fw-bold bg-light">Catatan</td>
                            <td>{{ $kulit->catatan ?? 'Tiada' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Status Aktif</td>
                            @php
                                if ($kulit->status_kulit === 'Aktif') {
                                    $badgeClass = 'badge-success-soft text-dark-success';
                                    $statusText = 'Aktif';
                                } elseif ($kulit->status_kulit === 'Tidak Aktif') {
                                    $badgeClass = 'badge-warning-soft text-dark-warning';
                                    $statusText = 'Tidak Aktif';
                                } else {
                                    $badgeClass = 'badge-danger-soft text-dark-danger';
                                    $statusText = 'Batal';
                                }
                            @endphp

                            <td>
                                <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                            </td>

                        </tr>
                    </tbody>
                </table>

                <br><br>
               <!--13052025 Arifah - Tambah gambar kulit -->
                <h5>Gambar Kulit</h5>

                <table class="table table-bordered table-striped table-hover">
                <tbody>    

                    {{-- Gambar Kulit --}}
                    <tr>
                        <td>Sisi Kiri :</td>
                        <td>
                          
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40" alt="Sisi Kiri">
                        </td>
                    </tr>
                    <tr>
                        <td>Keseluruhan:</td>
                        <td>
                            
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"  alt="Keseluruhan">
                        </td>
                    </tr>
                    <tr>
                        <td>Sisi Kanan :</td>
                        <td>
                            
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"   alt="Sisi Kanan">
                        </td>
                    </tr>
                    <tr>
                        <td>Hadapan :</td>
                        <td>
                           
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"   alt="Hadapan">
                        </td>
                    </tr>
                    <tr>
                        <td>Belakang :</td>
                        <td>
                           
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"  alt="Belakang">
                            
                        </td>
                    </tr>

                </tbody>
            </table>

            </div>


            <!-- Muatan Details (if exists) -->
            <!--25042025 Arifah - Tambah apabila zon c3 baru paparkan -->
            @if($muatan && $vessel->zon == 'C3')
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

