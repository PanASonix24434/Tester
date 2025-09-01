<div class="tab-pane fade " id="pendaftaran_antarabangsa" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">{{ $tab['pendaftaran_antarabangsa']['description'] }}</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table text-nowrap mb-0 table-centered">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Vesel</th>
                            <th>No. Pendaftaran (Jabatan Laut)</th>
                            <th>No. IRCS</th>
                            <th>No. RFMO</th>
                            <th>No. IMO</th>
                            <th>Kawasan Penangkapan</th>
                            <th>Spesis Sasaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftaran_antarabangsa as $item)
                            <tr>
                                <td>{{ $item->nama_vesel ?? 'Tiada' }}</td>
                                <td>{{ $item->no_pendaftaran_vesel ?? 'Tiada' }}</td>
                                <td>{{ $item->no_ircs ?? 'Tiada' }}</td>
                                <td>{{ $item->no_rfmo ?? 'Tiada' }}</td>
                                <td>{{ $item->no_imo ?? 'Tiada' }}</td>
                                <td>{{ $item->kawasan_penangkapan ?? 'Tiada' }}</td>
                                <td>{{ $item->spesis_sasaran ?? 'Tiada' }}</td>
                              
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tiada maklumat tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-center mt-2">
            <a href="javascript:history.back()" class="btn btn-outline-white btn-sm me-2">Kembali</a>
        </div>
    </div>
</div>
