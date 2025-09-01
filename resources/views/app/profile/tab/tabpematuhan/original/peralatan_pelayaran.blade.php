<div class="tab-pane fade show active" id="peralatan_pelayaran" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Maklumat Peralatan Pelayaran</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <tbody>
                    {{-- Lampu Pelayaran --}}
                    <tr>
                        <td rowspan="3">Lampu Pelayaran (Hijau/Merah)</td>
                        <td>Status :</td>
                        <td>{{ $pematuhan->navigation_light_status ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Kuantiti :</td>
                        <td>{{ $pematuhan->navigation_light_quantity ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Keadaan :</td>
                        <td>{{ $pematuhan->navigation_light_condition ?? 'Tiada' }}</td>
                    </tr>

                    {{-- MTU --}}
                    <tr>
                        <td rowspan="3">MTU</td>
                        <td>Status :</td>
                        <td>{{ $pematuhan->mtu_status ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Kuantiti :</td>
                        <td>{{ $pematuhan->mtu_quantity ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Keadaan :</td>
                        <td>{{ $pematuhan->mtu_condition ?? 'Tiada' }}</td>
                    </tr>

                    {{-- AIS --}}
                    <tr>
                        <td rowspan="3">AIS</td>
                        <td>Status :</td>
                        <td>{{ $pematuhan->ais_status ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Kuantiti :</td>
                        <td>{{ $pematuhan->ais_quantity ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Keadaan :</td>
                        <td>{{ $pematuhan->ais_condition ?? 'Tiada' }}</td>
                    </tr>

                    {{-- GPS --}}
                    <tr>
                        <td colspan="2">GPS :</td>
                        <td>{{ $pematuhan->is_gps ? 'Ada' : 'Tiada' }}</td>
                    </tr>

                    {{-- Gambar MTU/AIS --}}
                    <tr>
                        <td colspan="2">Gambar MTU :</td>
                        <td>
                            @if($pematuhan->mtu_image_path)
                                <img src="{{ asset('storage/' . $pematuhan->mtu_image_path) }}" class="img-thumbnail" alt="MTU">
                            @else
                                Tiada Gambar
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Gambar AIS :</td>
                        <td>
                            @if($pematuhan->ais_image_path)
                                <img src="{{ asset('storage/' . $pematuhan->ais_image_path) }}" class="img-thumbnail" alt="AIS">
                            @else
                                Tiada Gambar
                            @endif
                        </td>
                    </tr>

                    {{-- Gambar Lampu Pelayaran --}}
                    <tr>
                        <td colspan="2">Gambar Lampu Pelayaran :</td>
                        <td>
                            @if($pematuhan->navigation_light_image_path)
                                <img src="{{ asset('storage/' . $pematuhan->navigation_light_image_path) }}" class="img-thumbnail" alt="Lampu Pelayaran">
                            @else
                                Tiada Gambar
                            @endif
                        </td>
                    </tr>

                    {{-- Gambar QR Code --}}
                    <tr>
                        <td colspan="2">Gambar QR Code :</td>
                        <td>
                            @if($pematuhan->peralat_pelayaran_qr_code_image_path)
                                <img src="{{ asset('storage/' . $pematuhan->peralat_pelayaran_qr_code_image_path) }}" class="img-thumbnail" alt="QR Code">
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
