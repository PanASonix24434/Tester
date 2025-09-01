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
                        <a class="nav-link disabled"href="#" role="tab" aria-selected="false">Maklumat Aktiviti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill"  href="#" role="tab" aria-selected="true">Maklumat Pendaratan</a>
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
                                <form id="form" method="POST" action="{{ route('landingdeclaration.application.updateWeekBAdd',$landingInfoActivity->id) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="selSpecies">Spesis : <span style="color:red;">*</span></label>
                                                <select class="form-select select2" id="selSpecies" name="selSpecies" autocomplete="off" width="100%" required>
                                                    <option value="">{{ __('app.please_select')}}</option>
                                                    @foreach($species as $s)
                                                        <option value="{{$s->id}}">{{$s->common_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="weight">Berat (Kg) : <span style="color:red;">*</span></label>
                                                <input class="form-control" type="number" id="weight" name="weight" min="0" step="0.01" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="price">Harga (RM per Kg) : <span style="color:red;">*</span></label>
                                                <input class="form-control" type="number" id="price" name="price" min="0" step="0.01" required>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                            <a href="{{ route('landingdeclaration.application.editWeekB', $landingInfo->landing_declaration_id) }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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

    $.extend($.validator.messages, {
        required: "Medan ini diperlukan", // New default required message
        step: "Maksimum 2 tempat perpuluhan" // New default required message
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
                if ($(element).attr("name") == "selSpecies") {
                    $(element).next('.select2-container').find('.select2-selection--single').addClass('error');
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                if ($(element).attr("name") == "selSpecies") {
                    $(element).next('.select2-container').find('.select2-selection--single').removeClass('error');
                }
            },
        });

        // Trigger validation on Select2 change:
        // The validation plugin doesn't automatically re-validate Select2 on change.
        // We need to manually trigger validation when the Select2 value changes.
        $('#selSpecies').on('change', function() {
            $(this).valid();
        });
    });
</script>   
@endpush
