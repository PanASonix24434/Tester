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
                            {{-- <li class="breadcrumb-item">
                                <a href="http://127.0.0.1:8000/lesenBaharu/sokonganUlasan-1-01">{{
                                    \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a>
                            </li> --}}
                            <li class="breadcrumb-item active">
                                {{ \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}
                            </li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">{{$moduleName->name}}</a></li>
                            --}}
                            {{-- <li class="breadcrumb-item active" aria-current="page">Permohonan</a></li> --}}

                        </ol>
                    </nav>
                </div>
                <div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-tabs mb-4">

                                <div class="card-header">
                                    Senarai Permohonan
                                </div>

                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%" scope="col">Bil.</th>
                                                <th scope="col">Tarikh Permohonan</th>
                                                <th scope="col">Jenis Permohonan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">No. Rujukan</th>
                                                <th scope="col">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($applications->count())
                                            @foreach ($applications as $application)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                                <!-- Updated Date Format -->
                                                <td>{{ $application->applicationType->name ?? 'Tidak Diketahui' }}</td>
                                                <td>
                                                    <span class="btn col-md
                                                            @if (in_array($application->applicationStatus->code, $positiveFeedback)) bg-success
                                                            @elseif (in_array($application->applicationStatus->code, $negativeFeedback)) btn-warning
                                                            @else bg-secondary @endif
                                                        " style="pointer-events: none; cursor: default;">
                                                        {{ $application->applicationStatus->name ?? 'Tidak Diketahui' }}
                                                    </span>
                                                </td>
                                                <td>{{ $application->no_rujukan }}</td>
                                                <td>
                                                    <!-- Only show the button if the status code matches one of the feedback arrays -->
                                                    @if (in_array($application->applicationStatus->code,
                                                    $negativeFeedback))
                                                    <button class="btn btn-warning col-md"
                                                        onclick="window.location.href='{{ route('lesenBaharu.sokonganUlasan-1-01.tidakLengkap', $application->id) }}'">
                                                        <i class="far fa-edit pr-1"></i>
                                                    </button>
                                                    @elseif (in_array($application->applicationStatus->code,
                                                    $positiveFeedback))
                                                    <button class="btn btn-success col-md"
                                                        onclick="window.location.href='{{ route('lesenBaharu.sokonganUlasan-1-01.create', $application->id) }}'">
                                                        <i class="fa fa-search pr-1"></i>
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="text-center" colspan="6">Tiada permohonan ditemui.</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>

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
            document.addEventListener("DOMContentLoaded", function() {
                // Display success message from Laravel session
                var msgSuccess = @json(Session::get('success'));
                if (msgSuccess) {
                    alert(msgSuccess);
                }

                // Display error message from Laravel session
                var msgError = @json(Session::get('error'));
                if (msgError) {
                    alert(msgError);
                }
            });

        </script>
        @endpush
