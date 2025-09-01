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
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <!-- Page header -->
                    <div>
                        <h3 class="mb-0">{{ $applicationType->name_ms }}</h3>
                        <small>{{$moduleName->name}} - {{$roleName}}</small>
                    </div>

                    <!-- Empty div or content can be added here for spacing -->
                    <button class="btn btn-success col-md-1"
                        onclick="window.location.href='{{ route('lebihTahun.permohonan-07.create') }}'">MOHON
                    </button>
                </div>

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
                                            <th scope="col">No. Kad Pengenalan</th>
                                            <th scope="col">Jenis Permohonan</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">No. Rujukan</th>
                                            <th scope="col">Tindakan</th>
                                            @if (!empty($noPin))
                                            <th scope="col">No Pin</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if ($applications->count())
                                        @foreach ($applications as $key => $application)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $application->user->username }}</td>
                                            <td>{{ $application->applicationType->name ?? 'Tidak Diketahui' }}</td>
                                            <td>
                                                <span class="btn col-md
                        @if (in_array($application->applicationStatus->code, $appealFeedback)) bg-danger
                        @elseif (in_array($application->applicationStatus->code, $draftFeedback)) btn-warning
                        @elseif (in_array($application->applicationStatus->code, $negativeFeedback)) btn-warning
                        @else bg-success @endif" style="pointer-events: none; cursor: default;">
                                                    {{ $application->applicationStatus->name ?? 'Tidak Diketahui' }}
                                                </span>
                                            </td>
                                            <td>{{ $application->no_rujukan }}</td>
                                            <td>
                                                @if (in_array($application->applicationStatus->code, $negativeFeedback))
                                                <button class="btn btn-warning col-md"
                                                    onclick="window.location.href='{{ route('lebihTahun.permohonan-07.create', $application->id) }}'">
                                                    <i class="far fa-edit pr-1"></i>
                                                </button>
                                                @elseif (in_array($application->applicationStatus->code,
                                                $draftFeedback))
                                                <button class="btn btn-warning col-md"
                                                    onclick="window.location.href='{{ route('lebihTahun.permohonan-07.negativeFeedback', $application->id) }}'">
                                                    <i class="fa fa-search pr-1"></i>
                                                </button>
                                                @elseif (in_array($application->applicationStatus->code,
                                                $appealFeedback))
                                                <button class="btn btn-danger col-md"
                                                    onclick="window.location.href='{{ route('lebihTahun.permohonan-07.appealFeedback', $application->id) }}'">
                                                    <i class="fas fa-redo pr-1"></i>
                                                </button>
                                                @endif
                                            </td>

                                            @if (!empty($noPin))
                                            <td>{{ $noPin ?? '-' }}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="{{ !empty($noPin) ? 8 : 7 }}">Tiada
                                                permohonan ditemui.</td>
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
