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
                <!-- <form method="POST" enctype="multipart/form-data" action="#">
                    @csrf -->
                <!-- row -->
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
                                                <input type="text" class="form-control" value="{{ $subApplication->fullname}}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">No. Kad Pengenalan</label>
                                                <input type="text" class="form-control" value="{{ $subApplication->icno}}" readonly>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Tarikh Permohonan</label>
                                                <input type="text" class="form-control" value="{{ $subApplication->created_at}}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">No. Rujukan Permohonan</label>
                                                <input type="text" class="form-control" value="{{ $subApplication->registration_no}}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs mt-4">
                                        <li class="nav-item"><a class="nav-link" href="#">Butiran Pemohon</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Butiran Pekerjaan</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Butiran Tanggungan</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Tahap Pendidikan</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Dokumen Permohonan</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Status Permohonan</a></li>
                                        <li class="nav-item"><a class="nav-link active" href="#">Semakan</a></li>
                                    </ul>

                                    <div class="container">
                                            <h5 class="mb-3"></h5>

                                            <!-- Semakan Laporan Pendaratan -->
                                            <div class="mb-3">
                                                <h5>Semakan Laporan Pendaratan</h5>
                                                <hr>
                                                @foreach ($landings as $landing)
                                                    <div class="d-flex justify-content-center">
                                                        <a class="btn btn-info" href="{{ route('landinghelper.exportExcel',['userId'=>$landing->user_id, 'year'=>$landing->year, 'month'=>$landing->month]) }}">
                                                            <i class="fas fa-file-alt"></i> Semak Laporan Pendaratan
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Kemaskini Kesalahan -->
                                            <!-- <div class="mb-3">
                                                <h5>Kemaskini Kesalahan</h5>
                                                <hr>
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-info">
                                                        <i class="fas fa-plus"></i> Kemaskini Kesalahan di Modul Rekod Kesalahan
                                                    </button>
                                                </div>
                                            </div> -->

                                            <!-- Semakan Permohonan -->
                                             <form method="POST" enctype="multipart/form-data" action="{{ route('subsistence-allowance.storeCheck') }}">
                                                @csrf
                                                <input type="hidden" id="application_id" name="application_id" value="{{ $subApplication->id }}">
                                            <div class="mb-3">
                                                <h5>Semakan Permohonan</h5>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Perakuan oleh JKK :</label>
                                                    <div>
                                                        <input type="radio" id="peraku" name="jkk" value="peraku" required {{ $subApplication->is_approved_jkk ? 'checked' : '' }}  @if(!empty ($subApplication->is_approved_jkk)) disabled @endif>
                                                        <label for="peraku">Diperaku</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" id="tidakperaku" name="jkk" value="tidakperaku"  {{ $subApplication->is_approved_jkk === false ? 'checked' : '' }}  @if(!empty ($subApplication->is_approved_jkk)) disabled @endif>
                                                        <label for="tidakperaku">Tidak Diperaku</label>
                                                    </div>
                                                </div>
                                                @if($subApplication->sub_application_status == 'Permohonan Dihantar Semula' || $subApplication->sub_application_status == 'Permohonan Disemak KDP (TIDAK LENGKAP)')
                                                <div class="form-group">
                                                    <label>Maklumat dan Dokumen Permohonan :</label>
                                                    <div>
                                                        <input type="radio" id="lengkap" name="dokumen" value="lengkap" required {{ $subApplication->status_checked == "Permohonan Disemak (LENGKAP)" ? 'checked' : '' }} >
                                                        <label for="lengkap">Lengkap</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" id="tidak_lengkap" name="dokumen" value="tidak_lengkap" {{ $subApplication->status_checked == "Permohonan Disemak (TIDAK LENGKAP)" ? 'checked' : '' }} >
                                                        <label for="tidak_lengkap">Tidak Lengkap</label>
                                                    </div>
                                                </div>

                                                <!-- Ulasan -->
                                                <div class="form-group mt-3">
                                                    <label for="ulasan">Ulasan</label>
                                                    <textarea id="ulasan" name="ulasan" class="form-control" rows="3" >{{ $subApplication->checked_remarks ?? '' }}</textarea>
                                                </div>

                                                @else
                                                <div class="form-group">
                                                    <label>Maklumat dan Dokumen Permohonan :</label>
                                                    <div>
                                                        <input type="radio" id="lengkap" name="dokumen" value="lengkap" {{ $subApplication->status_checked == "Permohonan Disemak (LENGKAP)" ? 'checked' : '' }}  @if(!empty ($subApplication->status_checked)) disabled @endif >
                                                        <label for="lengkap">Lengkap</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" id="tidak_lengkap" name="dokumen" value="tidak_lengkap" {{ $subApplication->status_checked == "Permohonan Disemak (TIDAK LENGKAP)" ? 'checked' : '' }} @if(!empty ($subApplication->status_checked)) disabled @endif>
                                                        <label for="tidak_lengkap">Tidak Lengkap</label>
                                                    </div>
                                                </div>

                                                <!-- Ulasan -->
                                                <div class="form-group mt-3">
                                                    <label for="ulasan">Ulasan</label>
                                                    <textarea id="ulasan" name="ulasan" class="form-control" rows="3" @if(!empty ($subApplication->checked_remarks)) disabled @endif>{{ $subApplication->checked_remarks ?? '' }}</textarea>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        

                                         <!-- button action -->
                                        <div class="card-body">
                                            <div class="row">
                                                <br />
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                    <a href="{{ route('subsistence-allowance.detailsStatus' , $subApplication->id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Semakan ?</span>').text())">
                                                        <i class="fas fa-paper-plane"></i> Hantar
                                                    </button>
                                                    <!-- <a href="{{ route('subsistence-allowance.detailscheck', $subApplication->id) }}" class="btn btn-dark btn-sm">{{ __('app.next') }} <i class="fas fa-arrow-right"></i> </a> -->
                                                
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
