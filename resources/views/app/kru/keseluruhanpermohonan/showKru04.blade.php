@extends('layouts.app')


@section('content')

    <!-- Page Content -->
    <div id="app-content">
        <!-- Container fluid -->
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <!-- Page header -->
                        <div class="mb-5">
                            <h3 class="mb-0">Permohonan</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <!-- Breadcrumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('keseluruhanpermohonankru.index') }}">Keseluruhan Permohonan</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Card -->
                    <div class="card">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Pemohon</label>
                                        <input type="text" class="form-control" value="{{ $applicant->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>No. Kad Pengenalan</label>
                                        <input type="text" class="form-control" value="{{ $applicant->username }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Jenis Permohonan</label>
                                        <input type="text" class="form-control" value="{{ App\Models\Kru\KruApplicationType::find($app->kru_application_type_id)->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nombor Rujukan</label>
                                        <input type="text" class="form-control" value="{{$app->reference_number}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Pejabat Permohonan</label>
                                        <input type="text" class="form-control" value="{{ $app->entity_id != null ? strtoupper(Helper::getEntityNameById($app->entity_id)) : '' }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" value="{{ Helper::getCodeMasterNameById($app->kru_application_status_id) }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tarikh Permohonan</label>
                                        <input type="text" class="form-control" value="{{  $app->submitted_at!=null ? $app->submitted_at->format('d/m/Y h:i:s A') : '' }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="application-tab" data-bs-toggle="tab" href="#application" role="tab"
                                    aria-controls="application" aria-selected="true">Maklumat Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="log-tab" data-bs-toggle="tab" href="#log" role="tab"
                                    aria-controls="log" aria-selected="false">Status Permohonan</a>
                                </li>
                            </ul>
                            <div class="tab-content p-4" id="tabContent">
                                <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                    <div class="row">
                                        <!-- Vessel -->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vessel" class="form-label">Vesel : </label>
                                                <input type="text" class="form-control" value="{{ $app->vessel_id != null ? App\Models\Vessel::withTrashed()->find($app->vessel_id)->vessel_no : ''}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:1%;">Bil</th>
                                                            <th>No. Kad Pengenalan</th>
                                                            <th>Nama</th>
                                                            @if ( $decisionStatusIds->contains('id',$app->kru_application_status_id) )
                                                                <th>Keputusan</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listKru">
                                                        @if (!$selectedKrus->isEmpty())
                                                            @php
                                                                $count = 0;
                                                            @endphp
                                                            @foreach ($selectedKrus as $kru)
                                                                <tr>
                                                                    <td>{{++$count}}</td>
                                                                    <td>{{$kru->ic_number}}</td>
                                                                    <td>{{$kru->name}}</td>
                                                                    @if ( $decisionStatusIds->contains('id',$app->kru_application_status_id) )
                                                                        <td>{{$kru->selected_for_approval ? 'Diluluskan Pembatalan' : 'Tidak Diluluskan Pembatalan'}}</td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="5" style="text-align: center;">-Tiada Kru-</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('keseluruhanpermohonankru.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- The time line -->
                                            <div class="timeline">
                                                @if (!$logs->isEmpty())
                                                    @php
                                                        $count=0;
                                                        $date=0;
                                                    @endphp
                                                    @foreach ($logs as $log)
                                                        @php
                                                            $count++;
                                                            $userlog = App\Models\User::find($log->created_by);
                                                            $roles = $userlog->roles;
                                                        @endphp
                                                        @if ($log->updated_at->format('d/m/Y') > $date)
                                                            @php
                                                                $date = $log->updated_at->format('d/m/Y');
                                                            @endphp
                                                            <div class="time-label">
                                                                <span class="bg-white">{{$log->updated_at->format('d/m/Y')}}</span>
                                                            </div>
                                                        @endif
                                                        
                                                        <!-- Timeline Item -->
                                                        <div>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="fas fa-clock"></i> {{$log->updated_at->format('h:i:s A')}}</span>
                                                                
                                                                <!-- Status and Ulasan at the top -->
                                                                <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                    Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    @if ($redStatusIds->contains('id',$log->kru_application_status_id))
                                                                        <span class="badge bg-danger">{{Helper::getCodeMasterNameById($log->kru_application_status_id)}}</span>
                                                                    @elseif ($orangeStatusIds->contains('id',$log->kru_application_status_id))
                                                                        <span class="badge bg-warning">{{Helper::getCodeMasterNameById($log->kru_application_status_id)}}</span>
                                                                    @else
                                                                        <span class="badge bg-success">{{Helper::getCodeMasterNameById($log->kru_application_status_id)}}</span>
                                                                    @endif
                                                                </h3>
                                                                <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                    Ulasan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                                    <br><br>
                                                                    <span style="color: black; font-weight: normal; text-align: justify; line-height: 1.6; font-size: 105%;">
                                                                        {{$log->remark}}
                                                                    </span>
                                                                </h3>
                                                            
                                                                <!-- Hidden Nama and Peranan section -->
                                                                <div id="{{'details'.$count}}" style="display: none;">
                                                                    <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                        &nbsp;&nbsp;&nbsp;Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <a href="#" 
                                                                        style="color: black; font-weight: normal;" 
                                                                        onmouseover="this.style.color='blue';" 
                                                                        onmouseout="this.style.color='black';">
                                                                        {{$log->name}}
                                                                        </a>
                                                                    </h3>
                                                                    <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                        &nbsp;&nbsp;&nbsp;Peranan&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                                        <a href="#" 
                                                                            style="color: black; font-weight: normal;" >{{$userlog->roles->sortBy('name')->pluck('name')->implode(', ')}}
                                                                        </a>
                                                                    </h3>
                                                                </div>
                                                                <div style="text-align: right;">
                                                                    <button onclick="toggleDetails('{{'details'.$count}}', this)" class="btn btn-link" style="text-decoration: none;">
                                                                        View More
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.timeline-label -->
                                                    @endforeach
                                                    
                                                @endif
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-clock bg-gray"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br\>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('keseluruhanpermohonankru.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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

        $(document).ready(function () {
            
            $('#btnSubmit').prop("disabled",true);
            
            $('input[type=radio][name=applicationStatus]').change(function() {
                $('#btnSubmit').prop("disabled",false);
                if ($(this).val()=='approved') {
                    $('#remark').prop("required",false);
                }else if ($(this).val()=='rejected' || $(this).val()=='incomplete'){
                    $('#remark').prop("required",true);
                }
            });

        });
  
        function toggleDetails(detailsId, button) {
            var details = document.getElementById(detailsId);
            if (details.style.display === "none") {
            details.style.display = "block";
            button.textContent = "View Less";
            } else {
            details.style.display = "none";
            button.textContent = "View More";
            }
        }

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }

        //Peranan tidak dipilih
        var msg2 = '{{Session::get('alert2')}}';
        var exist2 = '{{Session::has('alert2')}}';
        if(exist2){
            alert(msg2);
        }

    </script>
@endpush
