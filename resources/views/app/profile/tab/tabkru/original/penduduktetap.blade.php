<div class="tab-pane fade" id="penduduk_tetap" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $tabkru['penduduk_tetap']['description'] }}</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table text-nowrap mb-0 table-centered">
                    <thead class="table-light">
                        <tr>
                            <th>Bil.</th>
                            <th>Nama</th>
                            <th>No. MyPR</th>
                            <th>No. Permit</th>
                            <th>Jawatan</th>
                            <th>Tarikh Kemaskini MyKad</th>
                            <th>Status Kru</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penduduk_tetap as $penduduk_tetap_item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $penduduk_tetap_item->nama_kru ?? 'Tiada' }}</td>
                                <td>{{ $penduduk_tetap_item->no_kp_baru ?? 'Tiada' }}</td>
                                <td>{{ $penduduk_tetap_item->no_sijil ?? 'Tiada' }}</td>
                                <td>{{ $penduduk_tetap_item->jawatan ?? 'Tiada' }}</td>
                                <td>
                                    {{ isset($penduduk_tetap_item->tarikh_kemaskini_mykad) ? 
                                    \Carbon\Carbon::parse($penduduk_tetap_item->tarikh_kemaskini_mykad)->format('d-m-Y') : 'Tiada' }}
                                </td>
                                <td>
                                    @if($penduduk_tetap_item->status_kru == 1)
                                        Aktif
                                    @elseif($penduduk_tetap_item->status_kru == 2)
                                        Tidak Aktif
                                    @elseif($penduduk_tetap_item->status_kru == 3)
                                        Batal
                                    @else
                                        Tiada
                                    @endif
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
