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
                        <a class="nav-link" href="#" role="tab" aria-selected="false">Waktu Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#" role="tab" aria-selected="true">Maklumat Kawasan</a>
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
                    <form method="POST" action="{{ route('landingdeclaration.application.updateC',$app->id) }}">
                        @csrf
                        <!-- row -->
                        <div class="row">
                            <div class="col-12">
                                <!-- card -->
                                <div class="card mb-4">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0" style="color:white;">C. Maklumat Kawasan Penangkapan Ikan</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm table-responsive">
                                                <table class="table table-bordered" style="text-align: center">
                                                    <thead>
                                                        <tr>
                                                            <th>Hari</th>
                                                            <th>6. Kawasan Penangkapan</th>
                                                            <th>7. Nama Tempat (Kg./Kawasan)</th>
                                                            <th>8. Negeri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                            <th>9. Daerah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                            <th>10. Peralatan Utama</th>
                                                            <th>11. Peralatan Tambahan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Isnin</td>
                                                            <td>
                                                                <input type="text" id="txtCatchLocation1" name="txtCatchLocation1" value="{{ $landingInfo1!=null ? $landingInfo1->catch_location : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtLocationName1" name="txtLocationName1" value="{{ $landingInfo1!=null ? $landingInfo1->location_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selState1" name="selState1" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $states as $s )
                                                                        <option value="{{$s->id}}" @if ($landingInfo1!=null) {{ $landingInfo1->state_id == $s->id ? 'selected' : '' }}  @endif >{{$s->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selDistrict1" name="selDistrict1" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $districts as $d )
                                                                        <option value="{{$d->id}}" @if ($landingInfo1!=null) {{ $landingInfo1->district_id == $d->id ? 'selected' : '' }}  @endif >{{$d->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtMainEquipment1" name="txtMainEquipment1" value="{{ $landingInfo1!=null ? $landingInfo1->main_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtAdditionalEquipment1" name="txtAdditionalEquipment1" value="{{ $landingInfo1!=null ? $landingInfo1->additional_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Selasa</td>
                                                            <td>
                                                                <input type="text" id="txtCatchLocation2" name="txtCatchLocation2" value="{{ $landingInfo2!=null ? $landingInfo2->catch_location : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtLocationName2" name="txtLocationName2" value="{{ $landingInfo2!=null ? $landingInfo2->location_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selState2" name="selState2" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $states as $s )
                                                                        <option value="{{$s->id}}" @if ($landingInfo2!=null) {{ $landingInfo2->state_id == $s->id ? 'selected' : '' }}  @endif >{{$s->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selDistrict2" name="selDistrict2" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $districts as $d )
                                                                        <option value="{{$d->id}}" @if ($landingInfo2!=null) {{ $landingInfo2->district_id == $d->id ? 'selected' : '' }}  @endif >{{$d->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtMainEquipment2" name="txtMainEquipment2" value="{{ $landingInfo2!=null ? $landingInfo2->main_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtAdditionalEquipment2" name="txtAdditionalEquipment2" value="{{ $landingInfo2!=null ? $landingInfo2->additional_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rabu</td>
                                                            <td>
                                                                <input type="text" id="txtCatchLocation3" name="txtCatchLocation3" value="{{ $landingInfo3!=null ? $landingInfo3->catch_location : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtLocationName3" name="txtLocationName3" value="{{ $landingInfo3!=null ? $landingInfo3->location_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selState3" name="selState3" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $states as $s )
                                                                        <option value="{{$s->id}}" @if ($landingInfo3!=null) {{ $landingInfo3->state_id == $s->id ? 'selected' : '' }}  @endif >{{$s->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selDistrict3" name="selDistrict3" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $districts as $d )
                                                                        <option value="{{$d->id}}" @if ($landingInfo3!=null) {{ $landingInfo3->district_id == $d->id ? 'selected' : '' }}  @endif >{{$d->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtMainEquipment3" name="txtMainEquipment3" value="{{ $landingInfo3!=null ? $landingInfo3->main_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtAdditionalEquipment3" name="txtAdditionalEquipment3" value="{{ $landingInfo3!=null ? $landingInfo3->additional_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Khamis</td>
                                                            <td>
                                                                <input type="text" id="txtCatchLocation4" name="txtCatchLocation4" value="{{ $landingInfo4!=null ? $landingInfo4->catch_location : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtLocationName4" name="txtLocationName4" value="{{ $landingInfo4!=null ? $landingInfo4->location_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selState4" name="selState4" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $states as $s )
                                                                        <option value="{{$s->id}}" @if ($landingInfo4!=null) {{ $landingInfo4->state_id == $s->id ? 'selected' : '' }}  @endif >{{$s->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selDistrict4" name="selDistrict4" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $districts as $d )
                                                                        <option value="{{$d->id}}" @if ($landingInfo4!=null) {{ $landingInfo4->district_id == $d->id ? 'selected' : '' }}  @endif >{{$d->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtMainEquipment4" name="txtMainEquipment4" value="{{ $landingInfo4!=null ? $landingInfo4->main_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtAdditionalEquipment4" name="txtAdditionalEquipment4" value="{{ $landingInfo4!=null ? $landingInfo4->additional_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumaat</td>
                                                            <td>
                                                                <input type="text" id="txtCatchLocation5" name="txtCatchLocation5" value="{{ $landingInfo5!=null ? $landingInfo5->catch_location : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtLocationName5" name="txtLocationName5" value="{{ $landingInfo5!=null ? $landingInfo5->location_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selState5" name="selState5" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $states as $s )
                                                                        <option value="{{$s->id}}" @if ($landingInfo5!=null) {{ $landingInfo5->state_id == $s->id ? 'selected' : '' }}  @endif >{{$s->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selDistrict5" name="selDistrict5" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $districts as $d )
                                                                        <option value="{{$d->id}}" @if ($landingInfo5!=null) {{ $landingInfo5->district_id == $d->id ? 'selected' : '' }}  @endif >{{$d->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtMainEquipment5" name="txtMainEquipment5" value="{{ $landingInfo5!=null ? $landingInfo5->main_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtAdditionalEquipment5" name="txtAdditionalEquipment5" value="{{ $landingInfo5!=null ? $landingInfo5->additional_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sabtu</td>
                                                            <td>
                                                                <input type="text" id="txtCatchLocation6" name="txtCatchLocation6" value="{{ $landingInfo6!=null ? $landingInfo6->catch_location : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtLocationName6" name="txtLocationName6" value="{{ $landingInfo6!=null ? $landingInfo6->location_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selState6" name="selState6" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $states as $s )
                                                                        <option value="{{$s->id}}" @if ($landingInfo6!=null) {{ $landingInfo6->state_id == $s->id ? 'selected' : '' }}  @endif >{{$s->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selDistrict6" name="selDistrict6" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $districts as $d )
                                                                        <option value="{{$d->id}}" @if ($landingInfo6!=null) {{ $landingInfo6->district_id == $d->id ? 'selected' : '' }}  @endif >{{$d->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtMainEquipment6" name="txtMainEquipment6" value="{{ $landingInfo6!=null ? $landingInfo6->main_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtAdditionalEquipment6" name="txtAdditionalEquipment6" value="{{ $landingInfo6!=null ? $landingInfo6->additional_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ahad</td>
                                                            <td>
                                                                <input type="text" id="txtCatchLocation7" name="txtCatchLocation7" value="{{ $landingInfo7!=null ? $landingInfo7->catch_location : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtLocationName7" name="txtLocationName7" value="{{ $landingInfo7!=null ? $landingInfo7->location_name : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selState7" name="selState7" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $states as $s )
                                                                        <option value="{{$s->id}}" @if ($landingInfo7!=null) {{ $landingInfo7->state_id == $s->id ? 'selected' : '' }}  @endif >{{$s->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2" id="selDistrict7" name="selDistrict7" autocomplete="off" width="100%" required>
                                                                    <option value="">{{ __('app.please_select')}}</option>
                                                                    @foreach ( $districts as $d )
                                                                        <option value="{{$d->id}}" @if ($landingInfo7!=null) {{ $landingInfo7->district_id == $d->id ? 'selected' : '' }}  @endif >{{$d->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtMainEquipment7" name="txtMainEquipment7" value="{{ $landingInfo7!=null ? $landingInfo7->main_equipment : '' }}" class="form-control" required />
                                                            </td>
                                                            <td>
                                                                <input type="text" id="txtAdditionalEquipment7" name="txtAdditionalEquipment7" value="{{ $landingInfo7!=null ? $landingInfo7->additional_equipment : '' }}" class="form-control" required />
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
                                                    <a href="{{ route('landingdeclaration.application.editB',$app->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
