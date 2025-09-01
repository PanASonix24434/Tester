<div class="tab-pane fade show active" id="vesel" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Maklumat Vesel</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <tbody>
                    <tr>
                        <td>Paku Penanda Lebar :</td>
                        <td></td>
                        <td>{{ $pematuhan->paku_penanda_lebar ? 'Ada' : 'Tiada' }}</td>
                    </tr>

                    <tr>
                        <td rowspan="4">Rumah Kemudi</td>
                        <td>Dicat dengan betul :</td>
                        <td>{{ $pematuhan->correctly_painted ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                    <tr>
                        <td>Dicat dengan terang :</td>
                        <td>{{ $pematuhan->brightly_painted ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                    <tr>
                        <td>Kod Zon :</td>
                        <td>{{ $pematuhan->zone_code ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Di Atas Bumbung :</td>
                        <td>{{ $pematuhan->di_atas_bumbung ? 'Ya' : 'Tidak' }}</td>
                    </tr>

                    <tr>
                        <td rowspan="2">Tanda Penukul Besi</td>
                        <td>Tanda di Bahagian Laluan :</td>
                        <td>{{ $pematuhan->tanda_di_bahagian_laluan ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Huruf Kod Tanda :</td>
                        <td>{{ $pematuhan->huruf_kod_tanda ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td rowspan="2">No. Pendaftaran Vesel</td>
                        <td>Ditebuk :</td>
                        <td>{{ $pematuhan->drilled ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                    <tr>
                        <td>Dicat Dengan Terang :</td>
                        <td>{{ $pematuhan->no_reg_brigthly_painted ? 'Ya' : 'Tidak' }}</td>
                    </tr>

                    <tr>
                        <td rowspan="2">Quick Response (QR) Code</td>
                        <td>Dipasang :</td>
                        <td>{{ $pematuhan->qr_code_image_path ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                    <tr>
                        <td>Imbasan :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->qr_code_image_path) }}" class="img-thumbnail" alt="QR Code"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40" alt="QR Code">
                        </td>
                    </tr>

                    {{-- Ukuran Dimensi Vesel (UDV) --}}
                    <tr>
                        <td rowspan="5">Ukuran Dimensi Vesel (UDV)</td>
                        <td>Panjang (m) :</td>
                        <td>{{ $pematuhan->length ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Lebar (m) :</td>
                        <td>{{ $pematuhan->width ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Dalam (m) :</td>
                        <td>{{ $pematuhan->depth ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Muatan (GRT) :</td>
                        <td>{{ $pematuhan->capacity ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Muatan (GT) :</td>
                        <td>{{ $pematuhan->capacity ?? 'Tiada' }}</td>
                    </tr>

                    {{-- Ukuran Geometri Vesel (UGV) --}}
                    <tr>
                        <td rowspan="7">Ukuran Geometri Vesel (UGV)</td>
                        <td>Saiz</td>
                        <td>{{ $pematuhan->size ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>A :</td>
                        <td>{{ $pematuhan->size_A ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>B :</td>
                        <td>{{ $pematuhan->size_B ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>C :</td>
                        <td>{{ $pematuhan->size_C ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>D :</td>
                        <td>{{ $pematuhan->size_D ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>E :</td>
                        <td>{{ $pematuhan->size_E ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>F :</td>
                        <td>{{ $pematuhan->size_F ?? 'Tiada' }}</td>
                    </tr>

                    {{-- Gambar Vesel --}}
                    <tr>
                        <td rowspan="5"></td>
                        <td>Sisi Kiri :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->left_side_image_path) }}" class="img-thumbnail" alt="Sisi Kiri"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40" alt="Sisi Kiri">
                        </td>
                    </tr>
                    <tr>
                        <td>Keseluruhan :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->overall_image_path) }}" class="img-thumbnail" alt="Keseluruhan"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"  alt="Keseluruhan">
                        </td>
                    </tr>
                    <tr>
                        <td>Sisi Kanan :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->right_side_image_path) }}" class="img-thumbnail" alt="Sisi Kanan"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"   alt="Sisi Kanan">
                        </td>
                    </tr>
                    <tr>
                        <td>Hadapan :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->front_image_path) }}" class="img-thumbnail" alt="Hadapan"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"   alt="Hadapan">
                        </td>
                    </tr>
                    <tr>
                        <td>Belakang :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->back_image_path) }}" class="img-thumbnail" alt="Belakang"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"  alt="Belakang">
                            
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
