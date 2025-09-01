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
                                    <a class="nav-link" id="kru-tab" data-bs-toggle="tab" href="#kru" role="tab"
                                    aria-controls="kru" aria-selected="false">Senarai Kru Bukan Warganegara Yang Ingin Dibatalkan</a>
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
                                                <label class="form-label">Nama Majikan / Syarikat : </label>
                                                <input type="text" class="form-control" value="{{ $vesselOwner->name }}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('keseluruhanpermohonankru.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="kru" role="tabpanel" aria-labelledby="kru-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vessel" class="form-label">Vesel: </label>
                                                <input type="text" class="form-control" value="{{ $app->vessel_id != null ? App\Models\Vessel::withTrashed()->find($app->vessel_id)->no_pendaftaran : ''}}" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 table-responsive">
                                            <div class="form-group">
                                                <label class="col-form-label">Senarai Kru:</label>
                                                <div class="float-right">
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="col-sm-12 table-responsive">
                                            <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Bil</th>
                                                    <th>Nama Kru</th>
                                                    <th>Warganegara</th>
                                                    <th>Umur</th>
                                                    <th>Jantina</th>
                                                    <th>Nombor Pasport</th>
                                                    <th>Tarikh Tamat Pasport</th>
                                                    <th>Jawatan</th>
                                                    <!-- <th>Status Keberadaan Kru</th> -->
                                                </tr>
                                            </thead>
                                            <tbody id="listKru">
                                                @php
                                                    $count = 0;
                                                @endphp
                                                @foreach ($foreignKrus as $foreignKru)
                                                    <tr>
                                                        <td>{{++$count}}</td>
                                                        <td>{{$foreignKru->name}}</td>
                                                        <td>{{Helper::getCodeMasterNameById($foreignKru->source_country_id)}}</td>
                                                        <td>{{$foreignKru->birth_date->age}}</td>
                                                        <td>{{$foreignKru->gender_id != null ? Helper::getCodeMasterNameById($foreignKru->gender_id) : ''}}</td>
                                                        <td>{{$foreignKru->passport_number}}</td>
                                                        <td>{{optional($foreignKru->passport_end_date)->format('d/m/Y')}}</td>
                                                        <td>{{$foreignKru->foreign_kru_position_id != null ? Helper::getCodeMasterNameById($foreignKru->foreign_kru_position_id) : ''}}</td>
                                                        <!-- <td>{{$foreignKru->crew_whereabout}}</td> -->
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br\>
                                    <div class="row">
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
                                                        @if ($log->created_at->format('d/m/Y') > $date)
                                                            @php
                                                                $date = $log->created_at->format('d/m/Y');
                                                            @endphp
                                                            <div class="time-label">
                                                                <span class="bg-white">{{$log->created_at->format('d/m/Y')}}</span>
                                                            </div>
                                                        @endif
                                                        
                                                        <!-- Timeline Item 2 -->
                                                        <div>
                                                            <div class="timeline-item">
                                                            <span class="time"><i class="fas fa-clock"></i> {{$log->created_at->format('h:i:s A')}}</span>
                                                            
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
                                                                <i class="fas fa-angle-down"></i>
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
        const nextTabButtons = document.querySelectorAll('.next-tab-btn');
        const tabList = document.getElementById('myTab');

        nextTabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const nextTabId = this.dataset.nextTab;
                const nextTabTrigger = tabList.querySelector(`#${nextTabId}`);

                if (nextTabTrigger) {
                const nextTabBootstrap = bootstrap.Tab.getOrCreateInstance(nextTabTrigger);
                nextTabBootstrap.show();
                }
            });
        });

        $(document).ready(function () {
            
            $('#btnSubmit').prop("disabled",true);
            
            $('input[type=radio][name=isComplete]').change(function() {
                $('#btnSubmit').prop("disabled",false);
                if ($(this).val()=='yes') {
                    $('#remark').prop("required",false);
                }else if ($(this).val()=='no'){
                    $('#remark').prop("required",true);
                }
            });

        });
  
        function toggleDetails(detailsId, button) {
            var details = document.getElementById(detailsId);
            if (details.style.display === "none") {
            details.style.display = "block";
            button.innerHTML = '<i class="fas fa-angle-up"></i>';
            } else {
            details.style.display = "none";
            button.innerHTML = '<i class="fas fa-angle-down"></i>';
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
