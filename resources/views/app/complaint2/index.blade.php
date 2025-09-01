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
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Senarai Aduan</h3>
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <form method="GET" action="{{ route('complaint2.complaintlist') }}">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtComplaintNo" class="form-label">No Aduan : </label>
                                            <input type="text" id="txtComplaintNo" name="txtComplaintNo" value="{{ $filterComplaintNo }}" class="form-control" />
                                        </div>
                                        <div class="mb-6">
                                            <label for="selStatus" class="form-label">Status : </label>
                                            <select class="form-control" id="selStatus" name="selStatus" autocomplete="off" width="100%">
                                                <option value="">-- PAPAR SEMUA --</option>
                                                @if ($filterStatus == 1)
                                                <option value="1" selected>DIHANTAR</option>
                                                @else
                                                <option value="1">DIHANTAR</option>
                                                @endif

                                                @if ($filterStatus == 2)
                                                <option value="2" selected>DITUGASKAN</option>
                                                @else
                                                <option value="2">DITUGASKAN</option>
                                                @endif
                                                
                                                @if ($filterStatus == 3)
                                                <option value="3" selected>SELESAI</option>
                                                @else
                                                <option value="3">SELESAI</option>
                                                @endif
                                                											
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 align-items-center">
                                        <div class="mb-6">
                                            <label for="txtName" class="form-label" for="selectOne">Nama Pengadu : </label>
                                            <input type="text" id="txtName" name="txtName" value="{{ $filterComplaintName }}" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                        <br/>
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                                        <!--<a href="#!" class="btn btn-success btn-sm"><i class="fas fa-file-export"></i> Eksport</a>-->
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                    @if (!$complaints->isEmpty())
                                        <thead class="table-light">
                                            <tr>
                                                <th><b>No. Aduan</b></th>
                                                <th><b>Tarikh Aduan</b></th>
                                                <th><b>Status</b></th>
                                                <th><b>Jenis Aduan</b></th>
                                                <th><b>Tajuk</b></th>
                                                <th><b>Butiran</b></th>
                                                <th><b>Aduan Oleh</b></th>
                                                <th><b>Tarikh Penutupan Aduan</b></th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($complaints as $a)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('complaint2.complaintview', $a->id) }}">
                                                        #{{ sprintf('%06d', $a->complaint_no) }}
                                                    </a>
                                                </td>
                                                <td>{{ $a->created_at->format('d/m/Y h:i:s A') }}</td>
                                                @if ($a->complaint_status == 1)
                                                <td>DIHANTAR</td>
                                                @elseif ($a->complaint_status == 2)
                                                <td>DITUGASKAN</td>
                                                @elseif($a->complaint_status == 3)
                                                <td>SELESAI</td>
                                                @endif
                                                <td>{{ $a->complaint_type }}</td>
                                                <td>{{ $a->title }}</td>
                                                <td>{{ $a->description }}</td>
                                                <td>{{ $a->name }}</td>

                                                @if (empty($a->close_date) || $a->close_date == null)
                                                    <td></td>
                                                @else
                                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $a->close_date)->format('d/m/Y') }}</td>
                                                @endif
 
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead>
                                            <tr>
                                                <th>No. Aduan</th>
                                                <th>Jenis Aduan</th>
                                                <th>Tajuk</th>
                                                <th>Butiran</th>
                                                <th>Aduan Oleh</th>
                                                <th>Tarikh Aduan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="7">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                    </table>
                                </div>
                            </div>
                            <div
                                class="card-footer d-md-flex justify-content-between align-items-center">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        {!! $complaints->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$complaints->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $complaints->firstItem(), 'last' => $complaints->lastItem(), 'total' => $complaints->total() ]) }}
                                        </span>
                                    </div>
                                @endif
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

</script>   
@endpush
