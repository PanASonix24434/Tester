<div class="tab-pane fade show active" id="enjin" role="tabpanel">

<div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Maklumat Enjin</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <tbody>
                    <tr>
                        <td>Jenama :</td>
                        <td>{{ $pematuhan->jenama ?? 'Tiada' }}</td>
                    </tr>

                    <tr>
                        <td>Model :</td>
                        <td>{{ $pematuhan->model ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Turbo :</td>
                        <td>{{ $pematuhan->turbo ?? 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Kuasa Kuda (hp):</td>
                        <td>{{ $pematuhan->kuasa_kuda ?? 'Tiada' }}</td>
                    </tr>

                    <tr>
                        <td>No Enjin :</td>
                        <td>{{ $pematuhan->no_enjin ?? 'Tiada'}}</td>
                    </tr>

                  
                    <tr>
                        <td>Penandaan Enjin Vessel (PEV):</td>
                        <td>{{ isset($pematuhan->tarikh_enjin_dilesenkan) ? 
                            \Carbon\Carbon::parse($pematuhan->tarikh_enjin_dilesenkan)->format('d-m-Y') : 'Tiada' }}</td>
                    </tr>

                </tbody>
                </table>

                <br><br>

                <h5>Gambar Enjin</h5>


                <table class="table table-bordered table-sm">
                <tbody>    

                    {{-- Gambar Enjin --}}
                    <tr>
                        <td>Gambar Enjin :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->left_side_image_path) }}" class="img-thumbnail" alt="Sisi Kiri"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40" alt="Enjin">
                        </td>
                    </tr>
                    <tr>
                        <td>Gambar No Enjin :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->overall_image_path) }}" class="img-thumbnail" alt="Keseluruhan"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"  alt="No Enjin">
                        </td>
                    </tr>
                    <tr>
                        <td>Gambar Penanda Enjin Vesel (PEV) :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->right_side_image_path) }}" class="img-thumbnail" alt="Sisi Kanan"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"   alt="Penanda Enjin Vesel">
                        </td>
                    </tr>
                    <tr>
                        <td>Gambar Turbo :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->front_image_path) }}" class="img-thumbnail" alt="Hadapan"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"   alt="Turbo">
                        </td>
                    </tr>
                    <tr>
                        <td>Gambar Generator :</td>
                        <td>
                            <!-- <img src="{{ asset('storage/' . $pematuhan->back_image_path) }}" class="img-thumbnail" alt="Belakang"> -->
                            <img src="{{ asset('images/no-image.jpg') }}" class="img-thumbnail w-40"  alt="Generator">
                            
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>