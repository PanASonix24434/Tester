<div class="tab-pane fade" id="kru_asing" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $tabkru['kru_asing']['description'] }}</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table text-nowrap mb-0 table-centered">
                    <thead class="table-light">
                        <tr>
                            <th>Bil.</th>
                            <th>Nama</th>
                            <th>No. Passport</th>
                            <th>No. PLKS</th>
                            <th>Tarikh Tamat PLKS</th>
                            <th>Negara</th>
                            <th>Jawatan</th>
                            <th>Status Aktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kru_asing as $kru_asing_item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kru_asing_item->nama_kru ?? 'Tiada' }}</td>
                                <td>{{ $kru_asing_item->no_passport ?? 'Tiada' }}</td>
                                <td>{{ $kru_asing_item->no_plks ?? 'Tiada' }}</td>
                                <td>
                                    {{ isset($kru_asing_item->tarikh_tamat_plks) ? 
                                    \Carbon\Carbon::parse($kru_asing_item->tarikh_tamat_plks)->format('d-m-Y') : 'Tiada' }}
                                </td>
                                <td>{{ $kru_asing_item->negara ?? 'Tiada' }}</td>
                                <td>{{ $kru_asing_item->jawatan ?? 'Tiada' }}</td>

                                @php
                                    if ( $kru_asing_item->status_kru  == 1) {
                                        $badgeClass = 'badge-success-soft text-dark-success';
                                        $statusText = 'Aktif';
                                    } elseif ( $kru_asing_item->status_kru  == 2) {
                                        $badgeClass = 'badge-warning-soft text-dark-warning';
                                        $statusText = 'Tidak Aktif';
                                    } elseif ( $kru_asing_item->status_kru  == 3) {
                                        $badgeClass = 'badge-danger-soft text-dark-danger';
                                        $statusText = 'Batal';
                                    } else{
                                        $badgeClass = 'badge-default-soft text-dark-default';
                                        $statusText = 'Tiada';
                                    }
                                @endphp

                                <td>
                                    <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                </td>

                                <!-- <td>
                                    @if($kru_asing_item->status_kru == 1)
                                        Aktif
                                    @elseif($kru_asing_item->status_kru == 2)
                                        Tidak Aktif
                                    @elseif($kru_asing_item->status_kru == 3)
                                        Batal
                                    @else
                                        {{ $kru_asing_item->status_kru ?? 'Tiada' }}
                                    @endif
                                </td> -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tiada maklumat tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
