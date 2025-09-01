@extends('layouts.app')

@push('styles')
<style type="text/css">
</style>

<style>
    .nav-link {
        border-bottom: none !important;
    }

    .nav.nav-tabs {
        border-bottom: none !important;
    }

    .nav-link.active {
        background-color: white !important;
    }

    /* Disable hover effect and interaction for custom nav links */
    .custom-nav-link:hover {
        background-color: white !important;
        /* Keep the background color as is during hover */
    }

    /* Disable all interactions with custom nav links */
    .custom-nav-link {
        pointer-events: none;
        /* Disable all interactions with the nav link */
    }

    /* Override the default btn-primary color */
    .btn-primary {
        background-color: #007bff !important;
        /* Set background color to #007bff */
        border-color: #007bff !important;
        /* Set border color to #007bff */
        color: white !important;
        /* Ensure text is white */
    }

    /* Optional: Change hover effect */
    .btn-primary:hover {
        background-color: #0056b3 !important;
        /* Darker blue on hover */
        border-color: #0056b3 !important;
        /* Darker border on hover */
    }
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
                        <small>{{ $moduleName->name }} - {{ $roleName }}</small>
                    </div>
                </div>
                <div class="col-md-6 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a
                                    href="http://127.0.0.1:8000/lesenBaharu/semakanDokumen-01">{{
                                    \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $moduleName->name }}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Permohonan</a></li> --}}

                        </ol>
                    </nav>
                </div>

            </div>
            <div>
                <div class="row">
                    <div class="col-12 ">

                        <div class="card card-danger">
                            <div class="card-header pb-0">
                                <h5 class="card-title  mb-3">Rayuan</h5>
                            </div>

                            <form method="POST" id="submitPermohonan"
                                action="{{ route('lesenBaharu.permohonan-01.storeAppeal', ['application' => $application->id]) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">
                                    {{-- Section 1: Officer's Comment --}}
                                    <h5 class="fw-bold mb-1">Ulasan Pegawai</h5>
                                    <small class="text-muted">Pandangan atau ulasan pegawai terhadap permohonan
                                        ini.</small>
                                    <hr>
                                    <div class="border rounded p-3 bg-light mb-4">
                                        {{ $applicationLogs->remarks ?? 'Tiada ulasan disediakan.' }}
                                    </div>

                                    {{-- Section 2: Applicant Appeal Input --}}

                                    <label class="fw-bold mb-1">Rayuan Pemohon <span
                                            class="text-danger">*</span></label><br>
                                    <small class="text-muted">Sila nyatakan alasan rayuan anda dan lampirkan dokumen
                                        sokongan jika ada.</small>
                                    <hr>

                                    <div class="form-group mb-3">
                                        {{-- <label for="appeal_text" class="form-label">Alasan Rayuan <span
                                                class="text-danger">*</span></label> --}}
                                        <textarea name="appeal_text" id="appeal_text" rows="5" class="form-control"
                                            placeholder="Contoh: Saya ingin merayu kerana..."
                                            required>{{ old('appeal_text') }}</textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="appeal_attachment" class="form-label">Dokumen Sokongan</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="appeal_attachment"
                                                name="appeal_attachment" accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="appeal_attachment">Pilih Fail</label>
                                        </div>
                                        <small class="text-muted">Muat naik dokumen seperti surat sokongan. Format: PDF,
                                            JPG, PNG. Saiz maksimum: 2MB.</small>
                                    </div>
                                </div>

                                @push('scripts')
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const input = document.getElementById('appeal_attachment');
                                        const label = input.nextElementSibling;

                                        input.addEventListener('change', function () {
                                            label.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
                                        });
                                    });
                                </script>
                                @endpush

                            </form>

                            <div class="card-footer text-end ">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light col-md-1"
                                        onclick="window.history.back();">Kembali</button>
                                    <button type="submit" class="btn btn-success col-md-1"
                                        form="submitPermohonan">Hantar</button>
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

{{-- Convert Data --}}
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
