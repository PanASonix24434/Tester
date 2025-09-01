<div class="tab-pane fade show active" id="kru_aktif" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $tabkru['kru_aktif']['description'] }}</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table text-nowrap mb-0 table-centered">
                    <thead class="table-light">
                        <tr>
                            <th>Bil.</th>
                            <th>Nama</th>
                            <th>No. KP/MyPR/No.Passport</th>
                            <th>No. Kad Pendaftaran Nelayan (No. KPN)</th>
                            <th>Negara</th>
                            <th>Jawatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kru_aktif as $kru_item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kru_item->nama_kru ?? 'Tiada' }}</td>
                                <td>{{ $kru_item->no_kp_baru ?? $kru_item->no_kp_lama ?? $kru_item->no_passport ?? 'Tiada' }}</td>
                                <td>{{ $kru_item->no_plks ?? null }}</td>
                                <td>{{ $kru_item->negara ?? 'Tiada' }}</td>
                                <td>{{ $kru_item->jawatan ?? 'Tiada' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tiada maklumat tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
