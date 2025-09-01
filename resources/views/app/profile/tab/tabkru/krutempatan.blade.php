<div class="tab-pane fade" id="kru_tempatan" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $tabkru['kru_tempatan']['description'] }}</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table text-nowrap mb-0 table-centered">
                    <thead class="table-light">
                        <tr>
                            <th>Bil.</th>
                            <th>Nama</th>
                            <th>No. KP. Baru</th>
                            <th>No. KP. Lama</th>
                            <th>No. KPN</th> <!-- change from No Kad to No KPN -->
                            <th>Jawatan</th>
                            <th>Tarikh Kemaskini KPN</th>
                            <th>Status Aktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kru_tempatan as $kru_tempatan_item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kru_tempatan_item->nama_kru ?? 'Tiada' }}</td>
                                <td>{{ $kru_tempatan_item->no_kp_baru ?? 'Tiada' }}</td>
                                <td>{{ $kru_tempatan_item->no_kp_lama ?? 'Tiada' }}</td>
                                <td>{{ $kru_tempatan_item->no_kad ?? 'Tiada' }}</td>
                                <td>{{ $kru_tempatan_item->jawatan ?? 'Tiada' }}</td>
                                <td>
                                    {{ isset($kru_tempatan_item->tarikh_kemaskini_mykad) ? 
                                    \Carbon\Carbon::parse($kru_tempatan_item->tarikh_kemaskini_mykad)->format('d-m-Y') : 'Tiada' }}
                                </td>
                                <!-- <td>
                                    @switch($kru_tempatan_item->status_kru ?? '')
                                        @case(1)
                                            Aktif
                                            @break
                                        @case(2)
                                            Tidak Aktif
                                            @break
                                        @case(3)
                                            Batal
                                            @break
                                        @default
                                            Tiada
                                    @endswitch
                                </td> -->

                                @php
                                    if ( $kru_tempatan_item->status_kru  == 1) {
                                        $badgeClass = 'badge-success-soft text-dark-success';
                                        $statusText = 'Aktif';
                                    } elseif ( $kru_tempatan_item->status_kru  == 2) {
                                        $badgeClass = 'badge-warning-soft text-dark-warning';
                                        $statusText = 'Tidak Aktif';
                                    } elseif ( $kru_tempatan_item->status_kru  == 3) {
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
