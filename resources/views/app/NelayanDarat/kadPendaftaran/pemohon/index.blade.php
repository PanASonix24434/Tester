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
                        <h3 class="mb-0">{{ $applicationType->name }}</h3>
                        <small>{{$moduleName->name}} - {{$roleName}}</small>
                    </div>

                    <!-- MOHON Button -->
                    <div class="btn-group col-md-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#mohonModal">
                            MOHON
                        </button>
                    </div>

                    <!-- MOHON Modal -->
                    <div class="modal fade" id="mohonModal" tabindex="-1" aria-labelledby="mohonModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mohonModalLabel">Pilih Jenis Permohonan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body text-center">

                                    <div class="row justify-content-center">
                                        <!-- Sambilan Button -->
                                        <div class="col-5">
                                            <a href="{{ route('kadPendaftaran.permohonan-08.create', ['type' => 'sambilan']) }}"
                                                class="btn btn-secondary w-100">
                                                Sambilan
                                            </a>
                                        </div>
                                        <!-- Tulen Button -->
                                        <div class="col-5">
                                            {{-- <button type="button" class="btn btn-primary w-100"
                                                onclick="handleTulenClick()">
                                                Tulen
                                            </button> --}}

                                             <a href="{{ route('kadPendaftaran.permohonan-08.create', ['type' => 'tulen']) }}"
                                                class="btn btn-primary w-100">
                                                Tulen
                                            </a>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @push('scripts')
                    <script>
                        function handleTulenClick() {
                            const landingMet = @json($landingRequirementMet);
                            if (landingMet) {
                                window.location.href = "{{ route('kadPendaftaran.permohonan-08.create', ['type' => 'tulen']) }}";
                            } else {
                            alert("Anda perlu melengkapkan maklumat bagi tempoh sekurang-kurangnya 3 bulan terlebih dahulu di menu 'Pengisytiharan Pendaratan' sebelum membuat permohonan.");

                            }
                        }
                    </script>
                    @endpush


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
                                <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%" scope="col">Bil.</th>
                                            <th scope="col">Tarikh Permohonan</th><th scope="col">No. Kad Pengenalan</th>
                                            <th scope="col">Jenis Permohonan</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">No. Rujukan</th>
                                            <th scope="col">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($applications->count())
                                        @foreach ($applications as $key => $application)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $application->created_at->format('d/m/Y') }}</td>
<td>{{ $application->user->username}}</td>
                                            <!-- Updated Date Format -->
                                            <td>{{ $application->applicationType->name ?? 'Tidak Diketahui' }}</td>
                                            <td>
                                                <span class="btn col-md
                                                            @if (in_array($application->applicationStatus->code, $appealFeedback)) bg-danger
                                                            @elseif (in_array($application->applicationStatus->code, $draftFeedback)) btn-warning
                                                            @elseif (in_array($application->applicationStatus->code, $negativeFeedback)) btn-warning
                                                            @else bg-success @endif
                                                        " style="pointer-events: none; cursor: default;">
                                                    {{ $application->applicationStatus->name ?? 'Tidak Diketahui' }}
                                                </span>
                                            </td>

                                            <td>{{ $application->no_rujukan }}</td>

                                            <td>
                                                @if (!empty($application->fetchPin) && !empty($application->fetchPin->pin_number))
                                                    <div class="mb-2">
                                                        <span class="badge bg-info text-white" title="Nombor Pin">
                                                            PIN: {{ $application->fetchPin->pin_number }}
                                                        </span>
                                                    </div>
                                                @endif
                                                
                                                <!-- Only show the button if the status code matches one of the feedback arrays -->
                                                @if (in_array($application->applicationStatus->code, $negativeFeedback))
                                                <button class="btn btn-warning col-md"
                                                    onclick="window.location.href='{{ route('kadPendaftaran.permohonan-08.negativeFeedback', $application->id) }}'">
                                                    <i class="far fa-edit pr-1"></i>
                                                </button>
                                                @elseif (in_array($application->applicationStatus->code,
                                                $draftFeedback))
                                                <button class="btn btn-warning col-md"
                                                    onclick="window.location.href='{{ route('kadPendaftaran.permohonan-08.negativeFeedback', $application->id) }}'">
                                                    <i class="fa fa-search pr-1"></i>
                                                </button>
                                                @elseif (in_array($application->applicationStatus->code,
                                                $appealFeedback))
                                                <!-- Uncomment this section if you want to show the appeal button -->
                                                <button class="btn btn-danger col-md"
                                                    onclick="window.location.href='{{ route('kadPendaftaran.permohonan-08.appealFeedback', $application->id) }}'">
                                                    <i class="fas fa-redo pr-1"></i>
                                                </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="7">Tiada permohonan ditemui.</td>
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
