<div class="tab-pane fade" id="kesalahan" role="tabpanel">
    <div class="row">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $tab['kesalahan']['description'] }}</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Bil.</th>
                                <th scope="col">Pemilik</th> <!-- Tukar Pesalah jadi Pemilik -->
                                <th scope="col">No. KP.</th>
                                <th scope="col">Akta</th>
                                <th scope="col">Seksyen</th>
                                <th scope="col">Kesalahan</th>
                                <th scope="col">Tarikh Tangkapan</th> <!-- Tukar Tarikh jadi Tarikh Tangkapan -->
                                <th scope="col">Keputusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kesalahan as $kesalahan_item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kesalahan_item->pesalah ?? 'Tiada' }}</td>
                                    <td>{{ $kesalahan_item->no_ic_pesalah ?? 'Tiada' }}</td>
                                    <td>{{ $kesalahan_item->akta ?? 'Tiada' }}</td>
                                    <td>{{ $kesalahan_item->seksyen ?? 'Tiada' }}</td>
                                    <td>{{ $kesalahan_item->kesalahan ?? 'Tiada' }}</td>
                                    <td>
                                        {{ isset($kesalahan_item->tarikh) ? \Carbon\Carbon::parse($kesalahan_item->tarikh)->format('d-m-Y') : 'Tiada' }}
                                    </td>
                                    <td>{{ $kesalahan_item->keputusan ?? 'Tiada' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tiada Rekod Kesalahan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <a href="javascript:history.back()" class="btn btn-outline-white btn-sm me-2">
                        Kembali <i class="icon-xxs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
