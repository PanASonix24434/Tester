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
                            <h3 class="mb-0">Pengesahan Bayaran</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <!-- Breadcrumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.index') }}">Permohonan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pengesahan Bayaran</li>
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
                                    <a class="nav-link" id="application-tab" data-bs-toggle="tab" href="#application" role="tab"
                                    aria-controls="application" aria-selected="true">Maklumat Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="log-tab" data-bs-toggle="tab" href="#log" role="tab"
                                    aria-controls="log" aria-selected="false">Status Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="action-tab" data-bs-toggle="tab" href="#action" role="tab"
                                    aria-controls="action" aria-selected="false">Tindakan</a>
                                </li>
                            </ul>
                            <div class="tab-content p-4" id="tabContent">
                                <div class="tab-pane fade" id="application" role="tabpanel" aria-labelledby="application-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vessel" class="form-label">Vesel : </label>
                                                <input type="text" class="form-control" value="{{$vessel->no_pendaftaran}}" disabled/>
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
                                                            <th>Kesihatan Kru</th>
                                                            <th>Keputusan</th>
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
                                                                    <td>
                                                                        <a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.showKru',$kru->id) }}" target="_blank">{{$kru->ic_number}}</a>
                                                                    </td>
                                                                    <td>{{$kru->name}}</td>
                                                                    <!-- <td>{{$kru->registration_end}}</td> -->
                                                                    <td>
                                                                        {{ $kru->health_declaration }}
                                                                    </td>
                                                                    <td>{{$kru->selected_for_approval ? 'Diluluskan Pembaharuan' : 'Tidak Diluluskan Pembaharuan'}}</td>
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
                                            <a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                                            <a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" id="action" role="tabpanel" aria-labelledby="action-tab">
                                    <h6 class="section-title" style="font-weight: bold; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 0%;">Pengesahan Bayaran</h6>
                                    <div class="card-body">
                                        <div class="col-sm-12 table-responsive">
                                            <div class="form-group">
                                                <label class="col-form-label">Senarai Bayaran Diterima:</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No. Resit</th>
                                                        <th>Item Bayaran</th>
                                                        <th>RM</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="listReceipt">
                                                    @if ($receipts!=null && !$receipts->isEmpty())
                                                        @foreach ($receipts as $receipt)
                                                            @php
                                                                $receiptItems = App\Models\Payment\ReceiptItem::where('receipt_id',$receipt->id)->get();
                                                                $itemCount = $receiptItems->count()
                                                            @endphp
                                                            <tr>
                                                                <td rowspan="{{$itemCount}}" style="vertical-align: middle; text-align: center;"><a href="{{ route('kruhelper.previewReceipt', $receipt->id) }}" target="_blank">{{$receipt->receipt_number}}</a></td>
                                                                <td>{{ Helper::getCodeMasterNameById($receiptItems[0]->payment_item_id) }}</td>
                                                                <td style="text-align: right;">{{number_format($receiptItems[0]->fee, 2)}}</td>
                                                            </tr>
                                                            @if ($itemCount > 1)
                                                                @for ($i = 1; $i < $itemCount; $i++)
                                                                    <tr>
                                                                        <td>{{ Helper::getCodeMasterNameById($receiptItems[$i]->payment_item_id) }}</td>
                                                                        <td style="text-align: right;">{{number_format($receiptItems[$i]->fee, 2)}}</td>
                                                                    </tr>
                                                                    
                                                                @endfor
                                                            @endif
                                                            
                                                        @endforeach
                                                    @else
                                                        <td colspan="3">-Tiada Maklumat</td>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="payee">Nama Pembayar</label>
                                                    <input type="text" name="payee" class="form-control" style="text-transform: uppercase" id="payee" value="{{$payment!=null?$payment->payee:''}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="paymentAmount">Jumlah Bayaran (RM)</label>
                                                <input type="number" name="paymentAmount" class="form-control" id="paymentAmount" value="{{$paymentTotal}}" step=".01" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <label>Pengesahan Bayaran:</label>
                                        <form id="form" method="POST" action="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.update',$id) }}">
                                            @csrf
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="radio" name="applicationStatus" value="complete" {{$savedLog!=null ? ($savedLog->completed === true ? 'checked' : '') : ''}}>
                                                    <label for="radio" class="custom-control-label" style="font-weight: normal;">Lengkap</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="radio2" name="applicationStatus" value="incomplete" {{$savedLog!=null ? ($savedLog->completed === false ? 'checked' : '') : ''}}>
                                                    <label for="radio2" class="custom-control-label" style="font-weight: normal;">Tidak Lengkap</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="remark">Ulasan</label>
                                                <textarea id="remark" name="remark" class="form-control" rows="4">{{$savedLog!=null ? $savedLog->remark : ''}}</textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-lg-center mt-3">
                                                    <a href="{{ route('pembaharuankadpendaftarannelayan.pengesahanbayaran.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                    <button type="submit" name="action" value="save" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Bayaran?</span>').text())">
                                                        <i class="fas fa-save"></i> Simpan
                                                    </button>
                                                    <button id="btnSubmit" type="submit" name="action" value="submit" class="btn btn-primary btn-sm" onclick="return confirm($('<span>Hantar Maklumat Bayaran?</span>').text())">
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

@endsection

@push('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#btnSubmit').prop("disabled",true);
            
            $('input[type=radio][name=applicationStatus]').change(function() {
                $('#btnSubmit').prop("disabled",false);
                if ($(this).val()=='complete') {
                    $('#remark').prop("required",false);
                }else if ($(this).val()=='incomplete'){
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
