@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')

    <!-- Page Content -->
    <div id="app-content">
        <!-- Container fluid -->
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Page header -->
                        <div class="mb-8">
                            <h3 class="mb-0">Pengisytiharan Pendaratan Perikanan Darat</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
                <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Maklumat Nelayan Darat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#" role="tab" aria-controls="custom-content-b" aria-selected="true">Waktu Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Maklumat Kawasan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" ria-selected="false">Perakuan</a>
                    </li>
                </ul>
                <br />
                <div>
                    <form method="POST" action="{{ route('landingdeclaration.application.updateB',$app->id) }}">
                        @csrf
                        <!-- row -->
                        <div class="row">
                            <div class="col-12">
                                <!-- card -->
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">B. Waktu Pendaratan </h4>
                                    </div>
                                    <div class="card-body">
                                        {{--
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- Nama Pemohon -->
                                                <div class="form-group">
                                                    <label class="col-form-label">1. Nama Pemohon :</label>
                                                    <input type="text" class="form-control" id="AppName"  name="fullname" value="{{ Auth::user()->name }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- No Kad Pengenalan -->
                                                <div class="form-group">
                                                    <label class="col-form-label">2. No Kad Pengenalan :</label>
                                                    <input type="text" class="form-control" id="AppIC" name="icno" value="{{ Auth::user()->username }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- Alamat Surat Menyurat -->
                                                <div class="form-group">
                                                    <label class="col-form-label">4. Alamat :</label>
                                                    <input type="text" class="form-control" id="AppAddress1" value="Auto" readonly>
                                                    <input type="text" class="form-control" id="AppAddress2" value="Auto" readonly>
                                                    <input type="text" class="form-control" id="AppAddress3" value="Auto" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        --}}
                                        
                                        <div class="row">
                                            <div class="col-sm">
                                                <table class="table table-bordered" style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th>Hari</th>
                                                            <th style="width: 45%">4. Tarikh</th>
                                                            <th style="width: 45%">5. Aktiviti Harian</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Isnin</td>
                                                            <td>
                                                                <input type="date" id="txtDate1" name="txtDate1" value="{{ $landingInfo1 != null ? optional($landingInfo1->landing_date)->format('Y-m-d') : '' }}" class="form-control" max="{{ now()->toDateString() }}" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selActivity1" name="selActivity1" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    <option value="Memasang Pukat" @if ($landingInfo1!=null) {{ $landingInfo1->activity == 'Memasang Pukat' ? 'selected' : '' }}  @endif >Memasang Pukat</option>
                                                                    <option value="Tiada Aktiviti" @if ($landingInfo1!=null) {{ $landingInfo1->activity == 'Tiada Aktiviti' ? 'selected' : '' }}  @endif >Tiada Aktiviti</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Selasa</td>
                                                            <td>
                                                                <input type="date" id="txtDate2" name="txtDate2" value="{{ $landingInfo2 != null ? optional($landingInfo2->landing_date)->format('Y-m-d') : '' }}" class="form-control" max="{{ now()->toDateString() }}" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selActivity2" name="selActivity2" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    <option value="Memasang Pukat" @if ($landingInfo2!=null) {{ $landingInfo2->activity == 'Memasang Pukat' ? 'selected' : '' }}  @endif >Memasang Pukat</option>
                                                                    <option value="Tiada Aktiviti" @if ($landingInfo2!=null) {{ $landingInfo2->activity == 'Tiada Aktiviti' ? 'selected' : '' }}  @endif >Tiada Aktiviti</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rabu</td>
                                                            <td>
                                                                <input type="date" id="txtDate3" name="txtDate3" value="{{ $landingInfo3 != null ? optional($landingInfo3->landing_date)->format('Y-m-d') : '' }}" class="form-control" max="{{ now()->toDateString() }}" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selActivity3" name="selActivity3" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    <option value="Memasang Pukat" @if ($landingInfo3!=null) {{ $landingInfo3->activity == 'Memasang Pukat' ? 'selected' : '' }}  @endif >Memasang Pukat</option>
                                                                    <option value="Tiada Aktiviti" @if ($landingInfo3!=null) {{ $landingInfo3->activity == 'Tiada Aktiviti' ? 'selected' : '' }}  @endif >Tiada Aktiviti</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Khamis</td>
                                                            <td>
                                                                <input type="date" id="txtDate4" name="txtDate4" value="{{ $landingInfo4 != null ? optional($landingInfo4->landing_date)->format('Y-m-d') : '' }}" class="form-control" max="{{ now()->toDateString() }}" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selActivity4" name="selActivity4" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    <option value="Memasang Pukat" @if ($landingInfo4!=null) {{ $landingInfo4->activity == 'Memasang Pukat' ? 'selected' : '' }}  @endif >Memasang Pukat</option>
                                                                    <option value="Tiada Aktiviti" @if ($landingInfo4!=null) {{ $landingInfo4->activity == 'Tiada Aktiviti' ? 'selected' : '' }}  @endif >Tiada Aktiviti</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumaat</td>
                                                            <td>
                                                                <input type="date" id="txtDate5" name="txtDate5" value="{{ $landingInfo5 != null ? optional($landingInfo5->landing_date)->format('Y-m-d') : '' }}" class="form-control" max="{{ now()->toDateString() }}" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selActivity5" name="selActivity5" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    <option value="Memasang Pukat" @if ($landingInfo5!=null) {{ $landingInfo5->activity == 'Memasang Pukat' ? 'selected' : '' }}  @endif >Memasang Pukat</option>
                                                                    <option value="Tiada Aktiviti" @if ($landingInfo5!=null) {{ $landingInfo5->activity == 'Tiada Aktiviti' ? 'selected' : '' }}  @endif >Tiada Aktiviti</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sabtu</td>
                                                            <td>
                                                                <input type="date" id="txtDate6" name="txtDate6" value="{{ $landingInfo6 != null ? optional($landingInfo6->landing_date)->format('Y-m-d') : '' }}" class="form-control" max="{{ now()->toDateString() }}" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selActivity6" name="selActivity6" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    <option value="Memasang Pukat" @if ($landingInfo6!=null) {{ $landingInfo6->activity == 'Memasang Pukat' ? 'selected' : '' }}  @endif >Memasang Pukat</option>
                                                                    <option value="Tiada Aktiviti" @if ($landingInfo6!=null) {{ $landingInfo6->activity == 'Tiada Aktiviti' ? 'selected' : '' }}  @endif >Tiada Aktiviti</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ahad</td>
                                                            <td>
                                                                <input type="date" id="txtDate7" name="txtDate7" value="{{ $landingInfo7 != null ? optional($landingInfo7->landing_date)->format('Y-m-d') : '' }}" class="form-control" max="{{ now()->toDateString() }}" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selActivity7" name="selActivity7" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    <option value="Memasang Pukat" @if ($landingInfo7!=null) {{ $landingInfo7->activity == 'Memasang Pukat' ? 'selected' : '' }}  @endif >Memasang Pukat</option>
                                                                    <option value="Tiada Aktiviti" @if ($landingInfo7!=null) {{ $landingInfo7->activity == 'Tiada Aktiviti' ? 'selected' : '' }}  @endif >Tiada Aktiviti</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- button action -->
                                        <div class="card-body">
                                            <div class="row">
                                                <br />
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                    <a href="{{ route('landingdeclaration.application.edit',$app->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Pengisytiharan Pendaratan?</span>').text())">
                                                        <i class="fas fa-save"></i> {{ __('app.save_next') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

       bsCustomFileInput.init();

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        

        

        
        

</script>   
@endpush
