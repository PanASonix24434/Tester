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
            <div class="card mb-10 row">
              <!--  <div class="card-header bg-primary"> -->
                <div>
                    <!-- Page header -->
                    <div class="mb-5">
                        <br />
                      <label style="font:#007bff;">Senarai Watikah Pelantikan</label>
                    </div>
                </div>
            <br />
            <div>
            <div class="form-container">
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-body">
                          <!--  <form id="export-appointments-pdf" method="GET" action="{{ route('appointment.download.appointments.download.export.pdf') }}" target="_blank" class="hidden"> -->
                             
                            <form id="export-appointments-pdf" method="GET" action="{{ route('appointment.download.appointments.download.export.pdf') }}" target="_blank" class="hidden">
                                    <input type="text" class="form-control" name="q" value="">
                            </form>
                            <form method="GET" action="{{ route('appointment.download.index') }}">
                              <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">
                                    @if (!$apptApprove->isEmpty())
                                        <thead class="table-light">
                                           </td></tr>
                                            <tr>
                                                <th><b>Nama</b></th>
                                                <th><b>No. Kad Pengenalan</b></th>
                                                <th><b>Tindakan</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($apptApprove as $a)
                                            <tr>                          
                                                <td>{{ $a->name }}</td>
                                                <td>{{ $a->icno }}</td>
                                                <td> <!-- <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-file-export"></i> Download
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('export-appointments-pdf').submit();">PDF</a>
                                                    </div> -->
                                                    <a href="{{ route('appointment.download.downloadDoc', $a->id) }}">
                                                        Muat Turun
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    @else
                                        <thead class="table-light">
                                             <tr>
                                                <th><b>Nama</b></th>
                                                <th><b>No. Kad Pengenalan</b></th>
                                                <th><b>Tindakan</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="8">{{ __('app.no_record_found') }}</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                    </table>
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
    <script src="{{ asset('plugins/jstree/dist/jstree.min.js') }}"></script>
    <script type="text/javascript">

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

    </script>
@endpush
