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
                                    <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab"
                                    aria-controls="address" aria-selected="false">Alamat Kru</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                                    aria-controls="contact" aria-selected="false">Maklumat Perhubungan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="document-tab" data-bs-toggle="tab" href="#document" role="tab"
                                    aria-controls="document" aria-selected="false">Maklumat Dokumen</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="payment-tab" data-bs-toggle="tab" href="#payment" role="tab"
                                    aria-controls="payment" aria-selected="false">Maklumat Bayaran</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="log-tab" data-bs-toggle="tab" href="#log" role="tab"
                                    aria-controls="log" aria-selected="false">Status Permohonan</a>
                                </li>
                            </ul>
                            <div class="tab-content p-4" id="tabContent">
                                <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Vesel : </label>
                                                <input type="text" class="form-control" value="{{ $app->vessel_id != null ? App\Models\Vessel::withTrashed()->find($app->vessel_id)->vessel_no : ''}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Kru : </label>
                                                <input type="text" class="form-control" value="{{ $selectedKru->name}} ({{$selectedKru->ic_number}})" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Sebab Penggantian Kad : </label>
                                                <input type="text" class="form-control" value="{{$app->application_type}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('keseluruhanpermohonankru.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- Address -->
                                            <div class="mb-3">
                                                <label class="form-label">Alamat : </label>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$selectedKru->address1}}" disabled />
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$selectedKru->address2}}" disabled/>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$selectedKru->address3}}" disabled/>
                                            </div>
                                            <!-- Postcode -->
                                            <div class="mb-3">
                                                <label class="form-label">Poskod : </label>
                                                <input type="number" class="form-control" value="{{$selectedKru->postcode}}" disabled/>
                                            </div>
                                            <!-- City -->
                                            <div class="mb-3">
                                                <label class="form-label">Bandar : </label>
                                                <input type="text" class="form-control" style="text-transform: uppercase" value="{{$selectedKru->city}}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- Daerah -->
                                                <label class="form-label">Daerah : </label>
                                                <input type="text" class="form-control" value="{{Helper::getCodeMasterNameById($selectedKru->district_id)}}" disabled/>
                                            <!-- Negeri -->
                                            <div class="mb-3">
                                                <label class="form-label">Negeri : </label>
                                                <input type="text" class="form-control" value="{{Helper::getCodeMasterNameById($selectedKru->state_id)}}" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('gantiankadpendaftarannelayan.sokongannegeri.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- Mobile Phone No -->
                                            <div class="mb-3">
                                                <label for="mobilePhoneNumber" class="form-label">Nombor Telefon Bimbit : </label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                    <input type="number" class="form-control" value="{{$selectedKru->mobile_contact_number}}"
                                                    aria-describedby="inputGroupPrepend" disabled>
                                                </div>
                                            </div>
                                            <!-- Email -->
                                            <div class="mb-3">
                                                <label class="form-label">Emel : </label>
                                                <input type="email" class="form-control" disabled value="{{$selectedKru->email}}"/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- Mobile Phone No -->
                                            <div class="mb-3">
                                                <label for="homePhoneNumber" class="form-label">Nombor Telefon Rumah : </label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">+60</span>
                                                    <input type="number" class="form-control" value="{{$selectedKru->home_contact_number}}"
                                                    aria-describedby="inputGroupPrepend" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <a href="{{ route('gantiankadpendaftarannelayan.sokongannegeri.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                                    <div class="row">
                                        <div class="col-sm-12 table-responsive">
                                            <div class="form-group">
                                                <label class="col-form-label">Senarai Dokumen:</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width:1%;">Bil</th>
                                                        <th>Tarikh Dicipta</th>
                                                        <th>Dokumen</th>
                                                        <th>Keterangan</th>
                                                        <th>Dimasukkan Oleh</th>
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
                                                                <td><a href="{{ route('kruhelper.previewKruDoc', $doc->id) }}" target="_blank">{{$doc->file_name}}</a></td>
                                                                <td>{{$doc->description}}</td>
                                                                <td>{{strtoupper(Helper::getUsersNameById($doc->created_by))}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" style="text-align: center;">-Tiada Dokumen-</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <a href="{{ route('gantiankadpendaftarannelayan.sokongannegeri.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
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
                                                    <td colspan="4">-Tiada Maklumat</td>
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
