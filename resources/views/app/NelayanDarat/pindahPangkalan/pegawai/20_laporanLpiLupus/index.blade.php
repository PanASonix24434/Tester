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
                        <h3 class="mb-0">{{ $applicationType->name_ms }}</h3>
                        <small>{{$moduleName->name}} - {{$roleName}}</small>
                    </div>

                </div>
                <div class="col-md-6 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex   justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item active">
                                {{ \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">

                                <div class="card-header">
                                    <div class="p-3"></div>
                                </div>

                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%" scope="col">Bil.</th>
                                                <th scope="col">Tarikh Permohonan</th>
                                                <th scope="col">No. Kad Pengenalan</th>
                                                <th scope="col">Jenis Permohonan</th>
                                                <th scope="col">Status Permohonan</th>
                                                <th scope="col">No. Rujukan</th>
                                                <th scope="col">Tindakan</th> <!-- Action Column -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($applications->count())
                                            @foreach ($applications as $key => $application)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $application->user->username ?? 'Tidak Diketahui' }}</td>
                                                <td>{{ $application->applicationType->name ?? 'Tidak Diketahui' }}</td>
                                                <td>
                                                    <span class="btn col-md
                                                        @if ($application->applicationStatus->code == 0) bg-danger
                                                        @elseif (in_array($application->applicationStatus->code, $negativeFeedback)) btn-warning
                                                        @else bg-success @endif
                                                        " style="pointer-events: none; cursor: default;">
                                                        {{ $application->applicationStatus->name ?? 'Tidak Diketahui' }}
                                                    </span>
                                                </td>
                                                <td>{{ $application->no_rujukan }}</td>
                                                <td class="text-center">
                                                    @if (in_array($application->applicationStatus->code, $negativeFeedback))
                                                    <button class="btn btn-warning col-md" onclick="window.location.href='{{ route('pindahPangkalan.laporanLpi-03.create', $application->id) }}'">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @else
                                                    @if ($application->owns_transportation == 0)
                                                    <button class="btn btn-success col-md" onclick="window.location.href='{{ route('pindahPangkalan.laporanLpi-03.create', $application->id) }}'">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    @else
                                                    <button class="btn btn-success col-md" onclick="window.location.href='{{ route('pindahPangkalan.laporanLpi-03.create', $application->id) }}'">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    @endif
                                                    @endif
                                                </td>

                                            </tr>
                                            <tr></tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="text-center" colspan="6">Tiada permohonan ditemui.</td>
                                            </tr>
                                            <tr></tr>
                                            @endif
                                        </tbody>
                                    </table>



                                    <br>
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
            $(document).ready(function() {
                // Convert all prefilled input and textarea values to uppercase
                $("input[type=text], textarea").each(function() {
                    const currentVal = $(this).val();
                    if (currentVal && typeof currentVal === "string") {
                        $(this).val(currentVal.toUpperCase());
                    }
                });

                // Dynamic input conversion as the user types
                $(document).on('input', "input[type=text], textarea", function() {
                    $(this).val(function(_, val) {
                        return val.toUpperCase();
                    });
                });
            });

        </script>

        <script>
            // Display success message from Laravel session
            var msgSuccess = @json(Session::get('success'));
            var existSuccess = @json(Session::has('success'));

            if (existSuccess) {
                alert(msgSuccess);
            }

            // Display error message from Laravel session
            var msgError = @json(Session::get('error'));
            var existError = @json(Session::has('error'));

            if (existError) {
                alert(msgError);
            }

        </script>

        @endpush
