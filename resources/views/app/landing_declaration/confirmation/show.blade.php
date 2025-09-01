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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="mb-0" style="color:white;">Pengesahan Daerah</h4>
                            </div>
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
                                            <label>Pejabat Permohonan</label>
                                            <input type="text" class="form-control" value="{{ $entity->entity_name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Status Permohonan</label>
                                            <input type="text" class="form-control" value="{{ $monthly->landing_status_id != null ? Helper::getCodeMasterNameById($monthly->landing_status_id) : '' }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active disabled" id="application-tab" data-bs-toggle="tab" href="#application" role="tab"
                                        aria-controls="application" aria-selected="true">Senarai Pendaratan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="summary-tab" data-bs-toggle="tab" href="#summary" role="tab"
                                        aria-controls="summary" aria-selected="false">Ringkasan Pendaratan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="doc-tab" data-bs-toggle="tab" href="#doc" role="tab"
                                        aria-controls="doc" aria-selected="false">Maklumat Dokumen</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="log-tab" data-bs-toggle="tab" href="#log" role="tab"
                                        aria-controls="log" aria-selected="false">Status Permohonan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="action-tab" data-bs-toggle="tab" href="#action" role="tab"
                                        aria-controls="action" aria-selected="false">Tindakan</a>
                                    </li>
                                </ul>
                                <div class="row">
                                    <div class="tab-content p-4" id="tabContent">
                                        <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Bulan :</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="{{ Carbon\Carbon::create($monthly->year, $monthly->month, 1)->isoFormat('MMMM') }} {{ $monthly->year }}" readonly>
                                                            <a href="{{ route('landinghelper.exportExcel',['userId'=>$monthly->user_id, 'year'=>$monthly->year, 'month'=>$monthly->month]) }}" class="btn btn-info" title="Cetak">
                                                                <i class="fas fa-print"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Minggu</th>
                                                                <th style="width: 0%;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="listDoc">
                                                            @if (!$apps->isEmpty())
                                                                @foreach ($apps as $app)
                                                                    <tr>
                                                                        <td>{{$app->week}} ({{$app->startDay}} - {{$app->endDay}}hb)</td>
                                                                        <td>
                                                                            <a href="{{ route('landingdeclaration.confirmation.showWeek',$app->id) }}" class="btn btn-sm btn-primary" title="Lihat">
                                                                                <i class="fas fa-search"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="2" style="text-align: center;">-Tiada Maklumat-</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                    <a href="{{ route('landingdeclaration.confirmation.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="summary-tab"><i class="fas fa-arrow-right"></i> Seterusnya</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">TAHUN</label>
                                                        <input type="text" class="form-control" id="searchedYear" value="{{ $monthly->year }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">BULAN</label>
                                                        <input type="text" class="form-control" id="searchedMonth" value="{{ $monthly->month }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">HARI OPERASI</label>
                                                        <input type="text" class="form-control" id="searchedOperatedDays" value="{{ $operatedDays }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">JUMLAH PENDARATAN (KG)</label>
                                                        <input type="text" class="form-control" id="searchedTotalLanding" value="{{ $totalLanding }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (!$summaryData->isEmpty())
                                                @foreach ($summaryData as $sD)
                                                    <hr/>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">SENARAI SPESIES: {{ $sD->location }}, {{ $sD->district }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Spesies</th>
                                                                        <th>Jumlah Berat (KG)</th>
                                                                        <th>Jumlah Harga (RM)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="listSpecies">
                                                                    @if (!$sD->species->isEmpty())
                                                                        @foreach ($sD->species as $sps)
                                                                            <tr>
                                                                                <td>{{ $sps->speciesName }}</td>
                                                                                <td>{{ $sps->totalWeight }}</td>
                                                                                <td>{{ $sps->totalPrice }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="3">-</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <br\>
                                            <div class="row">
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                    <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="application-tab"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="doc-tab"><i class="fas fa-arrow-right"></i> Seterusnya</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="doc" role="tabpanel" aria-labelledby="doc-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Senarai Dokumen:</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:1%;">Bil</th>
                                                                <th>Tarikh Dicipta</th>
                                                                <th>Dokumen</th>
                                                                <th>Tindakan Oleh</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="listDoc">
                                                            @if (!$docs->isEmpty())
                                                                @php
                                                                    $count = 0;
                                                                @endphp
                                                                @foreach ($docs as $doc)
                                                                    <tr>
                                                                        <td>{{++$count}}</td>
                                                                        <td>{{$doc->created_at->format('d/m/Y h:i:s A')}}</td>
                                                                        <td><a href="{{ route('landinghelper.previewDoc', $doc->id) }}" target="_blank">{{$doc->description}}</a></td>
                                                                        <td>{{strtoupper(Helper::getUsersNameById($doc->created_by))}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="4" style="text-align: center;">-Tiada Dokumen-</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br\>
                                            <div class="row">
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                    <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="application-tab"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="log-tab"><i class="fas fa-arrow-right"></i> Seterusnya</a>
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
                                                                
                                                                <!-- Timeline Item 2 -->
                                                                <div>
                                                                    <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i> {{$log->updated_at->format('h:i:s A')}}</span>
                                                                    
                                                                    <!-- Status and Ulasan at the top -->
                                                                    <h3 class="timeline-header" style="color: black; font-weight: bold; border-bottom: 1px solid #D3D3D3; font-size: 100%; padding-top: 1%; padding-bottom: 1%;">
                                                                        Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                                        @if ($redStatusIds->contains('id',$log->landing_status_id))
                                                                            <span class="badge bg-danger">{{Helper::getCodeMasterNameById($log->landing_status_id)}}</span>
                                                                        @elseif ($orangeStatusIds->contains('id',$log->landing_status_id))
                                                                            <span class="badge bg-warning">{{Helper::getCodeMasterNameById($log->landing_status_id)}}</span>
                                                                        @else
                                                                            <span class="badge bg-success">{{Helper::getCodeMasterNameById($log->landing_status_id)}}</span>
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
                                                <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                                    <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="doc-tab"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="action-tab"><i class="fas fa-arrow-right"></i> Seterusnya</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="action" role="tabpanel" aria-labelledby="action-tab">
                                            <form method="POST" action="{{ route('landingdeclaration.confirmation.update',$monthly->id) }}">
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" id="application_id" name="application_id" value="{{ $monthly->id }}">
                                                    <!-- Sokongan Permohonan -->
                                                    <div class=" mt-3 pb-3">
                                                        <h5 class="text-primary"><b>Pengesahan Pengisytiharan</b></h5>
                                                        <hr>
                                                        <div class="mt-2">
                                                            <strong>Tindakan :</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="applicationStatus" id="sah" value="sah" >
                                                                <label class="form-check-label" for="sah">Disahkan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="applicationStatus" id="tidak_sah" value="tidak_sah" >
                                                                <label class="form-check-label" for="tidak_sah">Tidak Disahkan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="applicationStatus" id="tidak_lengkap" value="tidak_lengkap" >
                                                                <label class="form-check-label" for="tidak_lengkap">Tidak Lengkap</label>
                                                            </div>
                                                        </div>
                                                        <!-- Ulasan -->
                                                        <div class="mt-3">
                                                            <label for="remark" class="form-label"><strong>Ulasan</strong></label>
                                                            <textarea class="form-control" id="remark" name = "remark" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br\>
                                                <div class="row">
                                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                                        <a class="btn btn-dark btn-sm next-tab-btn" data-next-tab="log-tab"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm($('<span>Hantar Pengesahan?</span>').text())">
                                                            <i class="fas fa-paper-plane"></i> Hantar
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
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
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

    $(document).on('input', "input[type=text]", function () {
        $(this).val(function (_, val) {
            return val.toUpperCase();
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
    $(document).ready(function () {
        $('#btnSubmit').prop("disabled",true);
        
        $('input[type=radio][name=applicationStatus]').change(function() {
            $('#btnSubmit').prop("disabled",false);
            if ($(this).val()=='sah') {
                $('#remark').prop("required",false);
            }else if ($(this).val()=='tidak_sah' || $(this).val()=='tidak_lengkap'){
                $('#remark').prop("required",true);
            }
        });
    });
    
</script>   
@endpush
