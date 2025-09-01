@extends('layouts.app_new')

@section('content')
    <!-- Page Content -->
    <div id="app-content">
        <!-- Container fluid -->
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page header -->
                        <div class="mb-5">
                            <h3 class="mb-0">Pentadbir Harta / Pewaris</h3>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="{{ route('profile_verification.inheritance.admin.update', $profile->id) }}" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <ul class="nav nav-line-bottom" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-card-info-tab" data-bs-toggle="pill" href="#pills-card-info" role="tab" aria-controls="pills-card-info" aria-selected="true">Maklumat Pentadbir Harta / Pewaris</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pills-card-verify-tab" data-bs-toggle="pill" href="#pills-card-verify" role="tab" aria-controls="pills-card-verify" aria-selected="false">Pengesahan</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-4" id="pills-tabContent">
                                        <div class="tab-pane active show" id="pills-card-info" role="tabpanel" aria-labelledby="pills-card-info-tab">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <label class="form-label text-info">Butiran Am Individu</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="name" class="form-label">Nama Individu</label>
                                                        <div class="text-muted">{{ $profile->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="icno" class="form-label">No. Kad Pengenalan</label>
                                                        <div class="text-muted">{{ $profile->icno }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="address" class="form-label">Alamat Semasa</label>
                                                        <div class="text-muted">{!! nl2br($profile->address) !!}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="phone" class="form-label">No. Telefon Bimbit</label>
                                                        <div class="text-muted">{{ $profile->phone }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="email" class="form-label">Alamat Emel</label>
                                                        <div class="text-muted">{{ $profile->email }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="vessel_owner" class="form-label">Nama Pemilik Vesel yang Terlibat</label>
                                                        <div class="text-muted">
                                                            {{ $profile->pemilik_vesel }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-12 mb-2 mt-5">
                                                    <label class="form-label text-info">Hubungkait Antara Pemilik Vesel</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="user_status" class="form-label">Status Pengguna</label>
                                                        <div class="text-muted">{{ Str::title(str_replace('_', ' ', $profile->status_pengguna)) }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="vessel" class="form-label">Vesel Yang Terlibat</label>
                                                        <div class="text-muted">{{ $profile->no_vesel }}</div>
                                                    </div>
                                                </div>
                                                <div id="div_relationship" class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="relationship" class="form-label">Hubungan Bersama Pemilik Vesel</label>
                                                        <div class="text-muted">{{ Str::title(str_replace('_', ' ', $profile->hubungan)) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 mb-2 mt-5">
                                                    <label class="form-label text-info">Dokumen yang Perlu Dimuatnaik</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label id="doc1-label" for="doc1" class="form-label">Surat Amanahraya (Pelantikan Pentadbir Pusaka / Keputusan Waris Pemilik)</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <a href="{{ asset('storage/'.$profile->dokumen_sokongan_1) }}" class="{{ $profile->dokumen_sokongan_1 ? '' : 'd-none' }}" target="_blank">
                                                        {{ basename($profile->dokumen_sokongan_1) }}&nbsp;&nbsp;
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label id="doc2-label" for="doc2" class="form-label">Surat Majistret</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <a href="{{ asset('storage/'.$profile->dokumen_sokongan_2) }}" class="{{ $profile->dokumen_sokongan_2 ? '' : 'd-none' }}" target="_blank">
                                                        {{ basename($profile->dokumen_sokongan_2) }}&nbsp;&nbsp;
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label id="doc3-label" for="doc3" class="form-label">Surat (Jabatan Ketua Pengarah Tanah & Galian Persekutuan)</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <a href="{{ asset('storage/'.$profile->dokumen_sokongan_3) }}" class="{{ $profile->dokumen_sokongan_3 ? '' : 'd-none' }}" target="_blank">
                                                        {{ basename($profile->dokumen_sokongan_3) }}&nbsp;&nbsp;
                                                    </a>
                                                </div>
                                            </div>
                                            {{-- <div class="row mb-4">
                                                <div class="col-lg-4">
                                                    <label for="doc4" class="form-label">Dokumen Sokongan</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <a href="{{ asset('storage/'.$profile->dokumen_sokongan_4) }}" class="{{ $profile->dokumen_sokongan_4 ? '' : 'd-none' }}" target="_blank">
                                                        {{ basename($profile->dokumen_sokongan_4) }}&nbsp;&nbsp;
                                                    </a>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="tab-pane" id="pills-card-verify" role="tabpanel" aria-labelledby="pills-card-verify-tab">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <label class="form-label text-info">Pengesahan Maklumat Pentadbir Harta / Pewaris</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-5">
                                                        <label class="form-label">Maklumat yang diberikan berkenaan pentadbir harta / pewaris</label>
                                                        <div class="form-check">
                                                            <input id="approval_status1" class="form-check-input" type="radio" name="approval_status" value="verified" required{{ old('approval_status') == 'verified' ? ' checked' : '' }}>
                                                            <label for="approval_status1" class="form-check-label">Disahkan</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input id="approval_status2" class="form-check-input" type="radio" name="approval_status" value="unverified" required{{ old('approval_status') == 'unverified' ? ' checked' : '' }}>
                                                            <label for="approval_status2" class="form-check-label">Tidak Disahkan</label>
                                                        </div>
                                                        @error('approval_status')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-5">
                                                        <label for="approval_remarks" class="form-label">Ulasan</label>
                                                        <textarea id="approval_remarks" class="form-control" name="approval_remarks" rows="5" required>{{ old('approval_remarks') }}</textarea>
                                                        @error('approval_remarks')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <a href="{{ route('profile_verification.inheritance.admin.index') }}" class="btn btn-light">Kembali</a>
                                            <button type="submit" class="btn btn-success">Hantar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('inc.sweetalert')
    <script type="text/javascript">
        $(document).ready(function () {
            $('a[data-bs-toggle="pill"]').on('show.bs.tab', function (e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#pills-tab a[href="' + activeTab + '"]').tab('show');
            }

            userStatusChange('#user_status');
            $('#user_status').on('change', function () {
                userStatusChange(this);
            });
        });

        function userStatusChange(user_status_id) {
            var user_status = '{{ $profile->status_pengguna }}';
            if (user_status == 'waris') {
                $('#div_relationship').removeClass('d-none');
                $('#doc1-label').text('Sijil Faraid (Mahkamah Syariah)');
                $('#doc2-label').text('Salinan Kad Pengenalan');
                $('#doc3-label').text('Dokumen Sokongan');
            } else if (user_status == 'pentadbir_harta') {
                $('#div_relationship').addClass('d-none');
                $('#doc1-label').text('Surat Pelantikan Pentadbir Harta (Mahkamah Majistret/Jabatan Ketua Pengarah Tanah & Galian Persekutuan/Amanahraya)');
                $('#doc2-label').text('Salinan Kad Pengenalan');
                $('#doc3-label').text('Dokumen Sokongan');
            }
        }
    </script>
@endpush
