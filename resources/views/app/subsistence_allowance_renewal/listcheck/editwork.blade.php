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
                        <h3 class="mb-0">Sokongan Pembaharuan </h3>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            
            <div>
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
								<h4 class="mb-0" style="color:white;">Elaun Sara Hidup Nelayan</h4>
                            </div>

                                <div class="card-body">

                                    <div class="card p-4">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Nama Pemilik Vesel</label>
                                                <input type="text" class="form-control" value="{{$subApplication->fullname}}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">No. Kad Pengenalan</label>
                                                <input type="text" class="form-control" value="{{$subApplication->icno}}" readonly>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Tarikh Permohonan</label>
                                                <input type="text" class="form-control" value="{{$subApplication->created_at}}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">No. Rujukan Permohonan</label>
                                                <input type="text" class="form-control" value="{{$subApplication->registration_no}}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs mt-4">
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Butiran Pemohon</a></li>
                                        <li class="nav-item"><a class="nav-link active" href="#">Butiran Pekerjaan</a></li>
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Butiran Tanggungan</a></li>
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Tahap Pendidikan</a></li>
                                        <!-- <li class="nav-item"><a class="nav-link" href="#">Butiran Kesalahan</a></li> -->
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Dokumen Permohonan</a></li>
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Status Permohonan</a></li>
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Semakan</a></li>
                                    </ul>

                                    <div class="card p-4 mt-3">
                                        <h5>B. Butiran Pekerjaan</h5>
                                        <hr>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Status Nelayan</label>
                                                <input type="text" class="form-control" value="Auto" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Tahun Mula Menjadi Nelayan</label>
                                                <input type="text" class="form-control" value="Auto" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Tempoh Menjadi Nelayan</label>
                                                <input type="text" class="form-control" value="Auto" readonly>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Bilangan hari menangkap ikan dalam sebulan</label>
                                                <input type="text" class="form-control" value="Auto" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tangkapan Bulanan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">RM</span>
                                                    <input type="text" class="form-control" value="Auto" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">15. Pendapatan Sebulan:</label>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">a. Hasil daripada menangkap ikan</label>
                                                </div>
                                                <div class="col-md-6 d-flex">
                                                    <span class="input-group-text">RM</span>
                                                    <input type="text" class="form-control" name="fishing_income" id="fishing_income" value="{{ $subApplication->tot_incomefish ?? '0' }}"  readonly>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">b. Hasil daripada pekerjaan lain (*jika ada)</label>
                                                </div>
                                                <div class="col-md-6 d-flex">
                                                    <span class="input-group-text">RM</span>
                                                    <input type="text" class="form-control" name="other_income" id="other_income" value="{{ $subApplication->tot_incomeother ?? '0' }}"   readonly>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 fw-bold">
                                                    <label class="form-label">Jumlah:</label>
                                                </div>
                                                <div class="col-md-6 d-flex">
                                                    <span class="input-group-text">RM</span>
                                                    <input type="text" class="form-control fw-bold" name="total_income" id="total_income" value="{{ $subApplication->tot_allincome ?? '' }}" readonly>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 fw-bold">
                                                    <label class="form-label">Peratus Pendapatan Hasil Daripada Menangkap Ikan:</label>
                                                </div>
                                                <div class="col-md-6 d-flex">
                                                    <input type="text" class="form-control fw-bold" name="total_income" id="total_income" value="{{ ($subApplication->tot_incomefish / $subApplication->tot_allincome) * 100 }}%" readonly>
                                                </div>
                                            </div>

                                        
                                        

                                         <!-- button action -->
                                        <div class="card-body">
                                            <div class="row">
                                                <br />
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                    <a href="{{ route('subsistence-allowance-renewal.kdpdetails', $subApplication->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <a href="{{ route('subsistence-allowance-renewal.kdpdetailsdependent', $subApplication->id) }}" class="btn btn-dark btn-sm">{{ __('app.next') }} <i class="fas fa-arrow-right"></i> </a>
                                                
                                                </div>
                                            </div>
                                        </div>
                                

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
<script type="text/javascript">

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        $(document).ready(function () {  

            //No Kad Pengenalan - Validation
            $('#txtPostcodeBaru').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 5)    
                    return false;                        
            }); 

            //No Telefon Bimbit - Validation
            $('#txtMobileNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)    
                    return false;                        
            }); 

            //No Telefon Pejabat - Validation
            $('#txtOfficePhoneNo').keypress(function (e) { 
                var charCode = (e.which) ? e.which : event.keyCode    
                if (String.fromCharCode(charCode).match(/[^0-9]/g)|| $(this).val().length >= 10)    
                    return false;                        
            }); 

        });

        function selAppTypeFunction() {
            var appTypeValue = document.getElementById("selAppType").value;

            if(appTypeValue == '1'){
                document.getElementById("divRowBaru").style.visibility = "visible";
                //$("#divRowBaru").show();
                //$("#divRowGanti").hide();
            }
            else{
                document.getElementById("divRowBaru").style.visibility = "hidden";
                // $("#divRowBaru").hide();
                // $("#divRowGanti").show();
            }
        }

        function selJawatanBaruFunction() {
            var e1 = document.getElementById("selPositionBaru");
            var eText1 = e1.options[e1.selectedIndex].text;

            if(eText1 == 'PEMILIK VESEL'){
                $("#divName1").show();
                $("#divICNo1").show();
                $("#divName2").hide();
                $("#divICNo2").hide();
                document.getElementById("divVesselBaru").style.visibility = "hidden";
                
            }
            else{
                $("#divName1").hide();
                $("#divICNo1").hide();
                $("#divName2").show();
                $("#divICNo2").show();
                document.getElementById("divVesselBaru").style.visibility = "visible";
                
            }
        }

</script>   
@endpush
