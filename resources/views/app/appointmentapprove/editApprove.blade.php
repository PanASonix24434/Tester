@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/jstree/dist/themes/default/style.min.css') }}">
@endpush
@section('content')

    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="form-container">
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4"> 
                        <div class="tab-content p-4" id="pills-tabContent-javascript-behavior">
                          <div class="tab-pane tab-example-design fade show active" id="pills-javascript-behavior-design"
                            role="tabpanel" aria-labelledby="pills-javascript-behavior-design-tab">
                                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="role-tab" data-bs-toggle="tab" href="#role" role="tab"
                                  aria-controls="role" aria-selected="true">Profil Pemohon</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" id="access-tab" data-bs-toggle="tab" href="#access" role="tab"
                                    aria-controls="access" aria-selected="false">Tindakan</a>
                                    </li>
                                </ul>
                        </div>
                        <div class="tab-pane fade show active" id="role" role="tabpanel" aria-labelledby="role-tab">                            
                        <form id="export-appointments-pdf" method="GET" action="{{ route('appointment.approval.appointments.approval.export.pdf', $id) }}" target="_blank" class="hidden">
                                <input type="text" class="form-control" name="q" value="">
                        </form>
                        
                       <!-- <form method="GET" action="{{ route('appointment.approval.editApprove', $id) }}">                            
                        @csrf -->
                        <input type="hidden" id="hide_appt" name="hide_appt"  value="{{ $id }}">
                        <input type="hidden" id="hide_username" name="hide_username" value="{{ $appt[0]->username }}">
                        <input type="hidden" id="hide_peranan" name="hide_peranan" value="{{ $appt[0]->role }}">  
                        
                            <div class="card-body row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Nama Individu : </label>
                                        <input type="text" id="txtName" name="txtName" value="{{ $appt[0]->name}}" class="form-control" disabled/>
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtRole" class="form-label">Peranan : </label>
                                        <input type="text" id="txtRole" name="txtRole" value="{{ $appt[0]->role}}" class="form-control" disabled />
                                    </div>
                                    <div class="mb-3">
                                            <label for="txtEmail" class="form-label">Emel : </label>
                                            <input type="email" id="txtEmail" name="txtEmail" value="{{ $appt[0]->email}}" class="form-control" disabled />
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtReportDate" class="form-label">Tarikh Pelantikan/Pertukaran : </label>
                                        <input type="text" id="txtReportDate" name="txtReportDate" value="{{ $appt[0]->report_date}}" class="form-control"  disabled/>
                                    </div>  
                                    <div class="col-lg-12">
                                       <label for="icDoc">Salinan Kad Pengenalan Kakitangan: </label>
                                        <div class="custom-file">
                                           <a href="{{ route('appointment.approval.downloadDoc', $appt[0]->id) }}">
                                            {{ $appt[0]->ic_file_name }}
                                          </a>
                                        </div>
                                    </div>                                                           
                                </div>
                                <div class="col-lg-6">
                                <div class="mb-3">
                                        <label for="txtICNO" class="form-label">No Kad Pengenalan ( Tanpa '-' ) : </label>
                                        <input type="text" id="txtICNO" name="txtICNO" value="{{ $appt[0]->icno}}" class="form-control"  disabled/>
                                    </div>                                        
                                    <div class="mb-3">
                                        <label for="txtLevel" class="form-label">Peringkat : </label>
                                        <input type="text" id="txtLevel" name="txtLevel" value="{{ $appt[0]->level}}" class="form-control"  disabled/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="txtDuty">Pejabat Bertugas : </label>
                                        <input type="text" id="txtDuty" name="txtDuty" value="{{ $appt[0]->office_duty}}" class="form-control"  disabled/>
								    </div>                                     
                                    <div class="mb-3">
                                        <label for="txtUnit" class="form-label">Cawangan : </label>
                                        <input type="text" id="txtUnit" name="txtUnit" value="{{ $appt[0]->department }}" class="form-control"  disabled/>
                                    </div> 
                                    <div class="col-lg-12">
                                        <label for="letterDoc">Surat Pelantikan/Surat Pertukaran Penempatan/Surat Penangguhan Kerja:</label>
                                        <div class="custom-file">
                                          <a href="{{ route('appointment.approval.letterDownloadDoc', $appt[0]->id) }}">
                                            {{ $appt[0]->letter_file_name }}
                                          </a>
                                        </div> 
                                    </div>
                                    </div>               
                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-left:-8px !important;">
                                        <button class="btn btn-success btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-file-export"></i> Eksport
                                        </button>
                                   
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('export-appointments-pdf').submit();">PDF</a>
                                    </div>    
                                    </div>       
                    </form>
                </div>                    
            </div>
            <div class="tab-pane fade" id="access" role="tabpanel" aria-labelledby="access-tab">
             <!--   <div class="mb-5">
                    <h5 class="mb-0">Kelulusan</h3>
                </div> -->
             <!--   <form method="POST" action="{{ route('appointment.approval.store') }}">      --> 
                
                <form method="POST" enctype="multipart/form-data" action="{{ route('appointment.approval.store') }}">                          
                @csrf
                <input type="hidden" id="hide_aid2" name="hide_aid2" value="{{ Helper::uuid() }}"> 
                <input type="hidden" id="hide_appt" name="hide_appt"  value="{{ $id }}">
                <input type="hidden" id="hide_username" name="hide_username" value="{{ $appt[0]->username }}"> 
                <input type="hidden" id="hide_name" name="hide_name" value="{{ $appt[0]->name }}"> 
                <input type="hidden" id="hide_email" name="hide_email" value="{{ $appt[0]->email }}">                 
                <input type="hidden" id="hide_peranan" name="hide_peranan" value="{{ $appt[0]->role }}"> 
                <input type="hidden" id="hide_role" name="hide_role" value="{{ $role[0]->quota}}">
                <input type="hidden" id="userid" name="userid" value="{{ Helper::uuid() }}">
                @if (($user == '') || ($user == 'NULL'))
                <input type="hidden" id="olduser" name="olduser" value="{{ $user[0]->id }}">
                @else
                <input type="hidden" id="olduser" name="olduser" value="">
                @endif
                <div class="card-body row">
                     <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="fileDoc">Surat Kelulusan KPP : <small>Maksimum Saiz : 5MB <span style="color:red;">*</span></small></label>
                                <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileDoc" name="fileDoc">
                                    <label class="custom-file-label" for="fileDoc">Choose file</label>
                                </div>
                                </div>
                            </div>
                            @error('fileDoc')
                                <span id="fileDoc_error" class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>      
                        <div class="mb-3">
                            <label for="txtFile" class="form-label">Tarikh Kelulusan KPP : <span style="color:red;">*</span></label>
                            <input type="date" id="txtDate" name="txtApproveDate" class="form-control" required />
                        </div>
                        <div class="mb-3" id="txtField">
                        <label for="txtResultLabel" class="form-label">Keputusan Permohonan : <span style="color:red;">*</span></label>
                        <br />
                            <label>
                                <input type="radio" name="txtResult" id="txtResult" value="Diluluskan" checked> Diluluskan
                            </label>
                            <label>
                                <input type="radio" name="txtResult" id="txtResult" value="Tidak Diluluskan"> Tidak Diluluskan
                            </label>
                            <br />
                            <br />
                        <div class="mb-3" id="txtKPPField" style="display:none;">
                            <label for="KPPNote" class="form-label">Ulasan KPP <label style="color:red;">(Sila masukkan ulasan yang telah dibuat oleh KPP) </label></label>
                            <br />
                            <textarea style="width: 100%; height: 100px;" id="txtKPPNote" name="txtKPPNote"></textarea>
                        </div>
                        </div>
                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                            <a href="{{ route('appointment.approval.indexapprove') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <!--<form action="{{ route('button.action') }}" method="POST">
                            @csrf-->
                         <!--   <button type="submit" name="action" value="save" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Simpan Maklumat ?</span>').text())">
                                <i class="fas fa-save"></i> {{ __('app.save') }}
                            </button> -->
                            <button type="submit" name="action" value="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Hantar Kelulusan ?</span>').text())">
                            <i class="fas fa-paper-plane"></i> {{ __('app.submit') }}
                            </button><br/>
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
   <script type="text/javascript">

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        //bsCustomFileInput.init();

        document.addEventListener("DOMContentLoaded", function () {
            let radios = document.querySelectorAll('input[name="txtResult"]');
            let noteField = document.getElementById("txtKPPField");

            radios.forEach(radio => {
                radio.addEventListener("change", function () {
                    if (this.value === "Diluluskan") {
                        noteField.style.display = "none";
                    } else {
                        noteField.style.display = "block";
                    }
                });
            });
        });

        bsCustomFileInput.init();

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        } 

    </script>
@endpush
