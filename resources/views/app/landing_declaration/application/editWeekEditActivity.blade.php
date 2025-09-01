@extends('layouts.app')

@push('styles')
    <style type="text/css">
        /* Error styling for Select2 */
        .select2-container--default .select2-selection--single.error {
            border-color: #ef4444; /* red-500 */
        }
    </style>
@endpush

@section('content')
    <div id="app-content">
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-8">
                            <h3 class="mb-0">Pengisytiharan Pendaratan Perikanan Darat</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
                <ul class="nav nav-tabs" id="custom-content-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#" role="tab" aria-selected="true">Maklumat Aktiviti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Maklumat Pendaratan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" role="tab" aria-selected="false">Ringkasan Maklumat</a>
                    </li>
                </ul>
                <br />
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
                                <h4 class="mb-0" style="color:white;">Tambah Maklumat</h4>
                            </div>
                            <div class="card-body">
                                <form id="form" method="POST" action="{{ route('landingdeclaration.application.updateWeekEditActivity',$landingInfoActivity->id) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="selActivity">Aktiviti : <span style="color:red;">*</span></label>
                                                <select class="form-select select2" id="selActivity" name="selActivity" autocomplete="off" width="100%" required>
                                                    <option value="">{{ __('app.please_select')}}</option>
                                                    @foreach($activityTypes as $at)
                                                        <option value="{{$at->id}}" @if($landingInfoActivity->landing_activity_type_id == $at->id) selected @endif>{{$at->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="time">Masa : <span style="color:red;">*</span></label>
                                                <input class="form-control" type="time" id="time" name="time" value="{{ $landingInfoActivity->time }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="selEquipment">Peralatan : <span style="color:red;">*</span></label>
                                                <select class="form-select select2" id="selEquipment" name="selEquipment" autocomplete="off" width="100%" required>
                                                    <option value="">{{ __('app.please_select')}}</option>
                                                    @foreach($equipments as $eq)
                                                        <option value="{{$eq->name}}" @if ($landingInfoActivity->equipment == strtoupper($eq->name)) selected @endif>{{ strtoupper($eq->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{--
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="equipment">Peralatan : <span style="color:red;">*</span></label>
                                                <input class="form-control" type="text" id="equipment" name="equipment" value="{{ $landingInfoActivity->equipment }}" required>
                                            </div>
                                        </div>
                                        --}}
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="selState">Negeri : <span style="color:red;">*</span></label>
                                                <select class="form-select select2" id="selState" name="selState" autocomplete="off" width="100%" required>
                                                    <option value="">{{ __('app.please_select')}}</option>
                                                    @foreach($states as $s)
                                                        <option value="{{$s->id}}" @if($landingInfoActivity->state_id == $s->id) selected @endif>{{$s->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="selDistrict">Daerah : <span style="color:red;">*</span></label>
                                                <select class="form-select select2" id="selDistrict" name="selDistrict" autocomplete="off" width="100%" required>
                                                    <option value="">{{ __('app.please_select')}}</option>
                                                    @foreach($districts as $d)
                                                        <option value="{{$d->id}}" @if($landingInfoActivity->district_id == $d->id) selected @endif>{{$d->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="selWaterType">Jenis Perairan : <span style="color:red;">*</span></label>
                                                <select class="form-select select2" id="selWaterType" name="selWaterType" autocomplete="off" width="100%" required>
                                                    <option value="">{{ __('app.please_select')}}</option>
                                                    @foreach($waterTypes as $wt)
                                                        <option value="{{$wt->id}}" @if($landingInfoActivity->landing_water_type_id == $wt->id) selected @endif>{{$wt->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="location">Nama Tempat (Kg./Kawasan) : <span style="color:red;">*</span></label>
                                                <input class="form-control" type="text" id="location" name="location" value="{{ $landingInfoActivity->location_name }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                            <a href="{{ route('landingdeclaration.application.editWeek', $landingInfo->landing_declaration_id) }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
    });

    $.extend($.validator.messages, {
        required: "Medan ini diperlukan" // New default required message
        // You can also change other defaults here, e.g.:
        // email: "Please enter a valid email address.",
        // minlength: $.validator.format("Please enter at least {0} characters.")
    });

    $(document).ready(function() {
        $("#form").validate({
            errorPlacement: function (error, element) {
                error.addClass('text-danger');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                if (
                    $(element).attr("name") == "selActivity" ||
                    $(element).attr("name") == "selEquipment" ||
                    $(element).attr("name") == "selState" ||
                    $(element).attr("name") == "selDistrict" ||
                    $(element).attr("name") == "selWaterType"
                ) {
                    $(element).next('.select2-container').find('.select2-selection--single').addClass('error');
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                if (
                    $(element).attr("name") == "selActivity" ||
                    $(element).attr("name") == "selEquipment" ||
                    $(element).attr("name") == "selState" ||
                    $(element).attr("name") == "selDistrict" ||
                    $(element).attr("name") == "selWaterType"
                ) {
                    $(element).next('.select2-container').find('.select2-selection--single').removeClass('error');
                }
            },
        });

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

        // Trigger validation on Select2 change:
        // The validation plugin doesn't automatically re-validate Select2 on change.
        // We need to manually trigger validation when the Select2 value changes.
        $('#selActivity').on('change', function() {
            $(this).valid();
        });
        $('#selEquipment').on('change', function() {
            $(this).valid();
        });
        $('#selState').on('change', function() {
            $(this).valid();
        });
        $('#selDistrict').on('change', function() {
            $(this).valid();
        });
        $('#selWaterType').on('change', function() {
            $(this).valid();
        });
    });  

</script>   
@endpush
