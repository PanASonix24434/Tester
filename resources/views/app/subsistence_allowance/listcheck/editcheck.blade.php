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
                        <h3 class="mb-0">Semakan Permohonan </h3>
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
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Butiran Pekerjaan</a></li>
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Butiran Tanggungan</a></li>
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Tahap Pendidikan</a></li>
                                        <!-- <li class="nav-item"><a class="nav-link" href="#">Butiran Kesalahan</a></li> -->
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Dokumen Permohonan</a></li>
                                        <li class="nav-item"><a class="nav-link disabled" href="#">Status Permohonan</a></li>
                                        <li class="nav-item"><a class="nav-link active" href="#">Semakan</a></li>
                                    </ul>

                                    <div class="container">
                                            <h5 class="mb-3"></h5>

                                            <div class="container mt-4">
                                                <!-- Semakan Laporan Pendaratan -->
                                                <div class="pb-2">
                                                    <h5 class="text-primary"><b>Semakan Laporan Pendaratan</b></h5>
                                                    <hr>
                                                    @foreach ($landings as $landing)
                                                        <div class="d-flex justify-content-center">
                                                            <a class="btn btn-info" href="{{ route('landinghelper.exportExcel',['userId'=>$landing->user_id, 'year'=>$landing->year, 'month'=>$landing->month]) }}">
                                                                <i class="fas fa-file-alt"></i> Semak Laporan Pendaratan
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <form method="POST" enctype="multipart/form-data" action="{{ route('subsistence-allowance.storeSupport') }}">
                                                @csrf
                                                <input type="hidden" id="application_id" name="application_id" value="{{ $subApplication->id }}">
                                                <!-- Sokongan Permohonan -->
                                                <div class="border-bottom mt-3 pb-3">
                                                    <h5 class="text-primary"><b>Sokongan Permohonan</b></h5>
                                                    <hr>
                                                    <!-- Maklumat Permohonan -->
                                                    @if($subApplication->status_supported == 'Permohonan Disemak KDP (TIDAK LENGKAP)')
                                                    <div class="mt-2">
                                                        <strong>Maklumat dan Dokumen Permohonan :</strong>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="dokumen" id="disokong" value = "disokong" {{ $subApplication->status_supported == "Permohonan Disokong KDP" ? 'checked' : '' }}  >
                                                            <label class="form-check-label" for="disokong">Disokong</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="dokumen" id="tidak_disokong" value="tidak_disokong" {{ $subApplication->status_supported == "Permohonan Tidak Disokong KDP" ? 'checked' : '' }} >
                                                            <label class="form-check-label" for="tidak_disokong">Tidak Disokong</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="dokumen" id="tidak_lengkap" value="tidak_lengkap" {{ $subApplication->status_supported == "Permohonan Disemak KDP (TIDAK LENGKAP)" ? 'checked' : '' }} >
                                                            <label class="form-check-label" for="tidak_lengkap">Tidak Lengkap</label>
                                                        </div>
                                                    </div>

                                                    <!-- Ulasan -->
                                                    <div class="mt-3">
                                                        <label for="ulasan" class="form-label"><strong>Ulasan</strong></label>
                                                        <textarea class="form-control" id="ulasan" name = "ulasan" rows="3" >{{ $subApplication->supported_remarks ?? '' }}</textarea>
                                                    </div>
                                                    
                                                    @else
                                                    <div class="mt-2">
                                                        <strong>Maklumat dan Dokumen Permohonan :</strong>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="dokumen" id="disokong" value = "disokong" {{ $subApplication->status_supported == "Permohonan Disokong KDP" ? 'checked' : '' }}  @if(!empty ($subApplication->status_supported )) disabled @endif >
                                                            <label class="form-check-label" for="disokong">Disokong</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="dokumen" id="tidak_disokong" value="tidak_disokong" {{ $subApplication->status_supported == "Permohonan Tidak Disokong KDP" ? 'checked' : '' }}  @if(!empty ($subApplication->status_supported )) disabled @endif>
                                                            <label class="form-check-label" for="tidak_disokong">Tidak Disokong</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="dokumen" id="tidak_lengkap" value="tidak_lengkap" {{ $subApplication->status_supported == "Permohonan Disemak KDP (TIDAK LENGKAP)" ? 'checked' : '' }}  @if(!empty ($subApplication->status_supported )) disabled @endif>
                                                            <label class="form-check-label" for="tidak_lengkap">Tidak Lengkap</label>
                                                        </div>
                                                    </div>

                                                    <!-- Ulasan -->
                                                    <div class="mt-3">
                                                        <label for="ulasan" class="form-label"><strong>Ulasan</strong></label>
                                                        <textarea class="form-control" id="ulasan" name = "ulasan" rows="3"  @if(!empty ($subApplication->supported_remarks)) disabled @endif>{{ $subApplication->supported_remarks ?? '' }}</textarea>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        

                                         <!-- button action -->
                                        <div class="card-body">
                                            <div class="row">
                                                <br />
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                    <a href="{{ route('subsistence-allowance.kdpdetailsStatus', $subApplication->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Sokongan ?</span>').text())">
                                                        <i class="fas fa-paper-plane"></i> Hantar
                                                    </button>
                                                    <!-- <a href="#" class="btn btn-dark btn-sm">{{ __('app.next') }} <i class="fas fa-arrow-right"></i> </a> -->
                                                
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
