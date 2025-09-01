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
                        <a class="nav-link active" id="custom-content-a-tab" data-toggle="pill" href="#custom-content-a" role="tab" aria-controls="custom-content-a" aria-selected="true">Maklumat Nelayan Darat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="custom-content-e-tab" href="#" role="tab" aria-controls="custom-content-e" aria-selected="false">Maklumat Dokumen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="custom-content-f-tab" href="#" role="tab" aria-controls="custom-content-f" aria-selected="false">Perakuan</a>
                    </li>
                </ul>
                <br />
                <form id="form" method="POST" action="{{ route('landingdeclaration.application.store') }}">
                    @csrf
                    <input type="hidden" id="year" name="year">
                    <input type="hidden" id="month" name="month">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0" style="color:white;">Butiran Pemohon </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="selMonth">Bulan : <span  style="color: red;">*</span></label>
                                                <select class="form-select select2" id="selMonth" name="selMonth" autocomplete="off" width="100%" required>
                                                    <option value="">{{ __('app.please_select')}}</option>
                                                    @foreach ( $months as $m)
                                                        @if ($m->available)
                                                            <option value="{{$m->month}}"
                                                                data-year="{{$m->year}}"
                                                                >
                                                                    {{ $m->monthTxt }} {{ $m->year }}
                                                            </option>
                                                        @else
                                                            <option value="{{$m->month}}"
                                                                data-year="{{$m->year}}" disabled
                                                                >
                                                                    {{ $m->monthTxt }} {{ $m->year }} (Sudah Dipilih)
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Pemohon :</label>
                                                <input type="text" class="form-control" id="AppName"  name="fullname" value="{{ Auth::user()->name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">No Kad Pengenalan :</label>
                                                <input type="text" class="form-control" id="AppIC" name="icno" value="{{ Auth::user()->username }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <a href="{{ route('landingdeclaration.application.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Pengisytiharan Pendaratan?</span>').text())">
                                                <i class="fas fa-save"></i> {{ __('app.save_next') }}
                                            </button>
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

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

    document.getElementById('selMonth').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const year = selectedOption.dataset.year;
        const month = selectedOption.dataset.month;

        document.getElementById('year').value = year;
        document.getElementById('month').value = month;
    });

    $(document).ready(function() {
        $('#selMonth').change(function() {
            var selectedOption = $(this).find(':selected'); // Get the selected option

            var year = selectedOption.data('year');
            var month = selectedOption.data('month');

            $('#year').val(year);
            $('#month').val(month);
        });
        $("#form").validate({
            rules: {
                selMonth: {
                    required: true,
                },
            },
            messages: {
                selMonth: {
                    required: "Medan ini diperlukan",
                },
            },
            // errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('text-danger');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                if ($(element).attr("name") == "selMonth") {
                    // Add error class to the Select2 container
                    $(element).next('.select2-container').find('.select2-selection--single').addClass('error');
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                if ($(element).attr("name") == "selMonth") {
                    // Remove error class from the Select2 container
                    $(element).next('.select2-container').find('.select2-selection--single').removeClass('error');
                }
            },
        });

        // Trigger validation on Select2 change:
        // The validation plugin doesn't automatically re-validate Select2 on change.
        // We need to manually trigger validation when the Select2 value changes.
        $('#selMonth').on('change', function() {
            $(this).valid(); // Re-validate the 'country' field
        });
    });

    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
    
</script>   
@endpush
