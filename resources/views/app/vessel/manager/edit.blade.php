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
                            <h3 class="mb-0">Kemaskini Pengurus Vesel</h3>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- row -->
                    @include('inc.alert')
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="{{ route('profile.vesselmanager.update', $application->id) }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <ul class="nav nav-line-bottom" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-card-info-tab" data-bs-toggle="pill" href="#pills-card-info" role="tab" aria-controls="pills-card-info" aria-selected="true">
                                                Maklumat Pengurus Vesel{!! $application->isVerified() ? ' &nbsp;<i class="fas fa-check-circle"></i>' : '' !!}
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-4" id="pills-tabContent">
                                        <div class="tab-pane fade active show" id="pills-card-info" role="tabpanel" aria-labelledby="pills-card-info-tab">
                                            <div class="row">
                                                <div class="col-12 mb-4">
                                                    <label class="form-label text-info">Butiran Am</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="select_manager" class="form-label">Pengerus Sedia Ada?</label>
                                                        <select id="select_manager" class="form-control select2bs4" name="select_manager">
                                                            <option value="">Pengurus Baru</option>
                                                            @foreach ($managers as $manager)
                                                                <option value="{{ $manager->id }}"{{ $manager->id == $profile->id ? ' selected' : '' }}>{{ $manager->name.' ('.$manager->ref.')' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="name" class="form-label">Nama Pengurus Vesel</label>
                                                        <input id="name" type="text" class="form-control" name="name" placeholder="Nama Pengurus Vesel" value="{{ old('name', $profile->name) }}" required>
                                                        @error('name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="icno" class="form-label">No. Kad Pengenalan</label>
                                                        <input id="icno" type="number" class="form-control" name="icno" placeholder="No. Kad Pengenalan" value="{{ old('icno', $profile->ref) }}" required maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)">
                                                        @error('icno')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="phone" class="form-label">No. Telefon Bimbit</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text" id="phone">+60</span>
                                                            <input id="phone" type="tel" class="form-control" name="phone" placeholder="No. Telefon Bimbit" value="{{ old('phone', $profile->phone) }}" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                                                        </div>
                                                        @error('phone')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="vessel" class="form-label">No. Pendaftaran Vesel Yang Diuruskan</label>
                                                        <select id="vessel" class="form-control select2bs4" name="vessel[]" required multiple>
                                                            @foreach ($vessels as $vessel)
                                                                <option value="{{ $vessel->id }}"{{ in_array($vessel->id, old('vessel', $application->vessels()->pluck('id')->toArray())) ? ' selected' : '' }}>{{ $vessel->vessel_no.' (Zon '.$vessel->zone.')' }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('vessel')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="email" class="form-label">Alamat Emel</label>
                                                        <input id="email" type="email" class="form-control" name="email" placeholder="Alamat Emel"  value="{{ old('email', $profile->email) }}" required>
                                                        @error('email')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-5 mt-5">
                                                        <label class="form-label text-danger">
                                                            Emel ini akan digunakan untuk semua urusan pelesenan. Sila pastikan emel ini sentiasa aktif. Sebarang perubahan emel perlu dikemaskini di bahagian profil.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label class="form-label">Status Bumiputera</label>
                                                        <div class="form-check">
                                                            <input id="bumiputera_status1" class="form-check-input" type="radio" name="bumiputera_status" value="yes" required{{ old('bumiputera_status') == 'yes' || $profile->is_bumiputera ? ' checked' : '' }}>
                                                            <label for="bumiputera_status1" class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input id="bumiputera_status2" class="form-check-input" type="radio" name="bumiputera_status" value="no" required{{ old('bumiputera_status') == 'no' || !$profile->is_bumiputera ? ' checked' : '' }}>
                                                            <label for="bumiputera_status2" class="form-check-label">Tidak</label>
                                                        </div>
                                                        @error('bumiputera_status')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 mb-4">
                                                    <label class="form-label text-info">Dokumen yang Perlu Dimuatnaik</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label for="ic_copy" class="form-label">Salinan Kad Pengenalan</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input id="ic_copy" type="file" class="form-control" name="ic_copy"{{ $application->ic_copy_url ? '' : ' required' }}>
                                                    @if ($application->ic_copy_url)
                                                        <a href="{{ $application->ic_copy_url }}" target="_blank">
                                                            {{ basename($application->ic_copy_url) }}
                                                        </a>
                                                    @endif
                                                    @error('ic_copy')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label for="surat_wakil_kuasa" class="form-label">Surat Wakil Kuasa daripada Pemilik kepada Pengurus Vesel<br />(bagi vesel A/B)</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <a href="{{ $application->surat_wakil_kuasa_daripada_pemilik_kepada_pengurus_vesel_url }}" class="uploaded-file{{ $application->surat_wakil_kuasa_daripada_pemilik_kepada_pengurus_vesel_url ? '' : ' d-none' }}" target="_blank">
                                                        {{ basename($application->surat_wakil_kuasa_daripada_pemilik_kepada_pengurus_vesel_url) }}&nbsp;&nbsp;
                                                    </a>
                                                    @if (!$application->isSubmitted())
                                                        <a href="javascript:void(0);" class="uploaded-file{{ $application->surat_wakil_kuasa_daripada_pemilik_kepada_pengurus_vesel_url ? '' : ' d-none' }}" onclick="deleteDocument(this);"
                                                            data-url="{{ route('attachment.destroy', $application->surat_wakil_kuasa_daripada_pemilik_kepada_pengurus_vesel_id) }}"
                                                            data-text="Surat wakil kuasa ini akan dipadam.">
                                                            <i class="fas fa-times text-danger"></i>
                                                        </a>
                                                    @endif
                                                    <input id="surat_wakil_kuasa" type="file" class="form-control upload-file{{ $application->surat_wakil_kuasa_daripada_pemilik_kepada_pengurus_vesel_url ? ' d-none' : '' }}" name="surat_wakil_kuasa">
                                                    @error('surat_wakil_kuasa')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <a href="{{ route('profile.vesselmanager.index') }}" class="btn btn-light">Kembali</a>
                                            @if ($application->isSubmitted() || $application->isVerified())
                                                <button type="button" class="btn btn-success" disabled>Hantar Semula</button>
                                            @else
                                                <button type="submit" class="btn btn-success">Hantar Semula</button>
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
    @include('inc.form_script')
    @include('inc.sweetalert')
    <script type="text/javascript">
        function deleteDocument(element) {
            var url = $(element).data('url');
            var text = $(element).data('text');
            if (url) {
                SwalDelete.fire({
                    title: 'Adakah anda pasti?',
                    text: text
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                            url: url,
                            method: 'DELETE',
                            cache: false,
                            success: function (result) {
                                if (result.success) {
                                    $('.uploaded-file').addClass('d-none');
                                    $('.upload-file').removeClass('d-none');
                                } else {
                                    if (result.message) {
                                        saa_alert('error', result.message);
                                    }
                                }
                            },
                            error: function () {
                                saa_error();
                            }
                        });
                    }
                });
            }
        }
    </script>
@endpush
