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
                            <h3 class="mb-0">Pengesahan Pengurus Vesel</h3>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="{{ route('profile_verification.vesselmanager.update', $application->id) }}" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <ul class="nav nav-line-bottom" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-card-info-tab" data-bs-toggle="pill" href="#pills-card-info" role="tab" aria-controls="pills-card-info" aria-selected="true">Maklumat Pengurus Vesel</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pills-card-approval-tab" data-bs-toggle="pill" href="#pills-card-approval" role="tab" aria-controls="pills-card-approval" aria-selected="false" tabindex="-1">Pengesahan</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-4" id="pills-tabContent">
                                        <div class="tab-pane active show" id="pills-card-info" role="tabpanel" aria-labelledby="pills-card-info-tab">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <label class="form-label text-info">Butiran Am</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="name" class="form-label">Nama Pengurus Vesel</label>
                                                        <div class="text-muted">{{ $profile->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="icno" class="form-label">No. Kad Pengenalan</label>
                                                        <div class="text-muted">{{ $profile->ref }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="phone" class="form-label">No. Telefon Bimbit</label>
                                                        <div class="text-muted">{{ $profile->phone_code.$profile->phone }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="vessel" class="form-label">No. Pendaftaran Vesel Yang Diuruskan</label>
                                                        {{-- <div class="text-muted">{{ $application->vessels()->pluck('vessel_no')->implode(', ') }}</div> --}}
                                                        <div class="text-muted">
                                                            {{ $application->vessels()->get()->map(function ($vessel) {
                                                                return $vessel->vessel_no.' (Zon '.$vessel->zone.')';
                                                            })->implode(', ') }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="email" class="form-label">Alamat Emel</label>
                                                        <div class="text-muted">{{ $profile->email }}</div>
                                                    </div>
                                                    <div class="mb-5 mt-5">
                                                        <label class="form-label text-danger">
                                                            Emel ini akan digunakan untuk semua urusan pelesenan. Sila pastikan emel ini sentiasa aktif. Sebarang perubahan emel perlu dikemaskini di bahagian profil.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="bumiputera_status" class="form-label">Status Bumiputera</label>
                                                        <div class="text-muted">{{ $profile->is_bumiputera ? 'Ya' : 'Tidak' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <label class="form-label text-info">Dokumen yang Perlu Dimuatnaik</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label for="ic_copy" class="form-label">Salinan Kad Pengenalan</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    @if ($application->ic_copy_url)
                                                        <a href="{{ $application->ic_copy_url }}" target="_blank">
                                                            {{ basename($application->ic_copy_url) }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">- Tiada -</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label for="surat_wakil_kuasa" class="form-label">Surat Wakil Kuasa daripada Pemilik kepada Pengurus Vesel</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    @if ($application->surat_wakil_kuasa_daripada_pemilik_kepada_pengurus_vesel_url)
                                                        <a href="{{ $application->surat_wakil_kuasa_daripada_pemilik_kepada_pengurus_vesel_url }}" target="_blank">
                                                            {{ basename($application->surat_wakil_kuasa_daripada_pemilik_kepada_pengurus_vesel_url) }}</a>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">- Tiada -</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="pills-card-approval" role="tabpanel" aria-labelledby="pills-card-approval-tab">
                                            <div class="row">
                                                <div class="col-12 mb-4">
                                                    <label class="form-label text-info">Pengesahan Pengurus Vesel Baru</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-5">
                                                        <label class="form-label">Maklumat yang diberikan berkenaan pengurus vesel</label>
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
                                            <a href="{{ route('profile_verification.vesselmanager.index') }}" class="btn btn-light">Kembali</a>
                                            @if ($application->isVerified())
                                                <button type="button" class="btn btn-success" disabled>Hantar</button>
                                            @else
                                                <button type="submit" class="btn btn-success">Hantar</button>
                                            @endif
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
        });
    </script>
@endpush
