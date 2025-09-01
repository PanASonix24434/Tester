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
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Maklumat Dokumen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Perakuan</a>
                    </li>
                </ul>
                <br />
                <div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <!-- card -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0" style="color:white;">Tambah Maklumat</h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('landingdeclaration.application.updateCAdd',$landingInfo->id) }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="selActivity">Aktiviti : <span style="color:red;">*</span></label>
                                                    <select class="form-select select2" id="selActivity" name="selActivity" autocomplete="off" width="100%" required>
                                                        <option value="">{{ __('app.please_select')}}</option>
                                                        @foreach($activityTypes as $at)
                                                            <option value="{{$at->id}}">{{$at->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="time">Masa : <span style="color:red;">*</span></label>
                                                <input class="form-control" type="time" id="time" name="time" required>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="selEquipment">Peralatan : <span style="color:red;">*</span></label>
                                                    <select class="form-select select2" id="selEquipment" name="selEquipment" autocomplete="off" width="100%" required>
                                                        <option value="">{{ __('app.please_select')}}</option>
                                                        @foreach($equipments as $eq)
                                                            <option value="{{$eq->name}}">{{ strtoupper($eq->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{--
                                            <div class="col-6">
                                                <label class="form-label" for="equipment">Peralatan : <span style="color:red;">*</span></label>
                                                <input class="form-control" type="text" id="equipment" name="equipment" required>
                                            </div>
                                            --}}
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="selState">Negeri : <span style="color:red;">*</span></label>
                                                    <select class="form-select select2" id="selState" name="selState" autocomplete="off" width="100%" required>
                                                        <option value="">{{ __('app.please_select')}}</option>
                                                        @foreach($states as $s)
                                                            <option value="{{$s->id}}">{{$s->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="selDistrict">Daerah : <span style="color:red;">*</span></label>
                                                    <select class="form-select select2" id="selDistrict" name="selDistrict" autocomplete="off" width="100%" required>
                                                        <option value="">{{ __('app.please_select')}}</option>
                                                        {{--
                                                        @foreach($districts as $d)
                                                            <option value="{{$d->id}}">{{$d->name}}</option>
                                                        @endforeach
                                                        --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="selWaterType">Jenis Perairan : <span style="color:red;">*</span></label>
                                                    <select class="form-select select2" id="selWaterType" name="selWaterType" autocomplete="off" width="100%" required>
                                                        <option value="">{{ __('app.please_select')}}</option>
                                                        @foreach($waterTypes as $wt)
                                                            <option value="{{$wt->id}}">{{$wt->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label" for="location">Nama Tempat (Kg./Kawasan) : <span style="color:red;">*</span></label>
                                                <input class="form-control" type="text" id="location" name="location" required>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                <a href="{{ route('landingdeclaration.application.editC', $landingInfo->landing_declaration_id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Maklumat?</span>').text())">
                                                    <i class="fas fa-save"></i> Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

    $(document).ready(function() {
        $('#selState').on('change', function() {
            var stateId = $(this).val();
            if (stateId) {
                $.ajax({
                    url: '{{ route('helper.getDistricts') }}',
                    type: 'GET',
                    data: { state_id: stateId },
                    dataType: 'json',
                    success: function(data) {
                        $('#selDistrict').empty();
                        $('#selDistrict').append('<option value="">- Sila Pilih -</option>');
                        $.each(data, function(key, value) {
                            $('#selDistrict').append('<option value="' + key + '">' + value + '</option>');
                        });
                        $('#selDistrict').trigger('change'); // Enable and update Select2

                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", error);
                    }
                });
            } else {
                $('#selDistrict').empty();
                $('#selDistrict').append('<option value="">- Sila Pilih -</option>');
            }
        });
    });

</script>   
@endpush
