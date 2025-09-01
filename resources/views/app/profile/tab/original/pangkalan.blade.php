<div class="tab-pane fade" id="pangkalan" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">{{ $tab['pangkalan']['description'] }}</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table text-nowrap mb-0 table-centered">
                    <thead class="table-light">
                        <tr>
                            <th>Bil.</th>
                            <th>No. Rujukan Permohonan</th>
                            <th>Nama Pangkalan</th>
                            <th>Jenis Pangkalan</th>
                            <th>Daerah</th>
                            <th>Negeri</th>
                            <th>Tarikh Mula Beroperasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pangkalan as $index => $pangkalan_item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if(Auth::user()->is_pegawai)
                                        <a href="{{ route('permohonan.show', $pangkalan_item->no_rujukan_permohonan) }}">
                                            {{ $pangkalan_item->no_rujukan_permohonan }}
                                        </a>
                                    @else
                                        {{ $pangkalan_item->no_rujukan_permohonan }}
                                    @endif
                                </td>
                                <td>{{ $pangkalan_item->nama_pangkalan ?? 'Tiada' }}</td>
                                <td>{{ $pangkalan_item->jenis_pangkalan ?? 'Tiada' }}</td>
                                <td>{{ $pangkalan_item->daerah ?? 'Tiada' }}</td>
                                <td>{{ $pangkalan_item->negeri ?? 'Tiada' }}</td>
                                <td>{{ $pangkalan_item->tarikh_mula_beroperasi ? \Carbon\Carbon::parse($pangkalan_item->tarikh_mula_beroperasi)->format('d-m-Y') : 'Tiada' }}</td>
                                <td>{{ $pangkalan_item->status ?? 'Tiada' }}</td>
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
