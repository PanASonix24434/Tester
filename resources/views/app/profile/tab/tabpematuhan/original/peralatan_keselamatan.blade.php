<div class="tab-pane fade show active" id="peralatan_keselamatan" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Maklumat Peralatan Keselamatan</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <tbody>
                    {{-- Jaket Keselamatan --}}
                    <tr>
                        <td rowspan="3">Jaket Keselamatan</td>
                        <td>Status :</td>
                        <td>{{ $pematuhan->safety_jacket_status ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Kuantiti :</td>
                        <td>{{ $pematuhan->safety_jacket_quantity ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Keadaan :</td>
                        <td>{{ $pematuhan->safety_jacket_condition ?? 'Tiada' }}</td>
                    </tr>

                    {{-- Boya Keselamatan --}}
                    <tr>
                        <td rowspan="3">Boya Keselamatan</td>
                        <td>Status :</td>
                        <td>{{ $pematuhan->life_buoy_status ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Kuantiti :</td>
                        <td>{{ $pematuhan->life_buoy_quantity ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Keadaan :</td>
                        <td>{{ $pematuhan->life_buoy_condition ?? 'Tiada' }}</td>
                    </tr>

                    {{-- Alat Pemadam Api --}}
                    <tr>
                        <td rowspan="3">Alat Pemadam Api</td>
                        <td>Status :</td>
                        <td>{{ $pematuhan->fire_extinguisher_status ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Kuantiti :</td>
                        <td>{{ $pematuhan->fire_extinguisher_quantity ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Keadaan :</td>
                        <td>{{ $pematuhan->fire_extinguisher_condition ?? 'Tiada' }}</td>
                    </tr>

                    {{-- Rakit Keselamatan --}}
                    <tr>
                        <td rowspan="3">Rakit Keselamatan</td>
                        <td>Status :</td>
                        <td>{{ $pematuhan->life_raft_status ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Kuantiti :</td>
                        <td>{{ $pematuhan->life_raft_quantity ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Keadaan :</td>
                        <td>{{ $pematuhan->life_raft_condition ?? 'Tiada' }}</td>
                    </tr>

                    {{-- Radio Wireless --}}
                    <tr>
                        <td rowspan="3">Radio Wireless</td>
                        <td>Status :</td>
                        <td>{{ $pematuhan->radio_status ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Kuantiti :</td>
                        <td>{{ $pematuhan->radio_quantity ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Keadaan :</td>
                        <td>{{ $pematuhan->radio_condition ?? 'Tiada' }}</td>
                    </tr>

                    {{-- Gambar Jaket Keselamatan --}}
                    <tr>
                        <td>Gambar Jaket Keselamatan :</td>
                        <td colspan="2">
                            @if($pematuhan->safety_jacket_image_path)
                                <img src="{{ asset('storage/' . $pematuhan->safety_jacket_image_path) }}" class="img-thumbnail" alt="Gambar Jaket Keselamatan">
                            @else
                                Tiada Gambar
                            @endif
                        </td>
                    </tr>

                    {{-- Gambar Alat Pemadam Api --}}
                    <tr>
                        <td>Gambar Alat Pemadam Api :</td>
                        <td colspan="2">
                            @if($pematuhan->fire_extinguisher_condition)
                                <img src="{{ asset('storage/' . $pematuhan->fire_extinguisher_condition) }}" class="img-thumbnail" alt="Gambar Alat Pemadam Api">
                            @else
                                Tiada Gambar
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
