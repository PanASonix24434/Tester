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
                <div class="col-md">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">{{ $applicationType->name_ms }}</h3>
                        <small>{{ $moduleName->name }} - {{ $roleName }}</small>
                    </div>
                </div>
                <div class="col-md-3 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="http://127.0.0.1:8000/gantiKulit/laporanLpi-06">{{
                                    \Illuminate\Support\Str::ucfirst(strtolower($applicationType->name)) }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $moduleName->name }}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Permohonan</a></li> --}}

                        </ol>
                    </nav>
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">

                        {{-- card 1 --}}

                        <div class="card card-primary">
                            <div class="card-header "></div>
                            <div class="card-body">

                                <div class="border p-5" style="border-radius: 20px">
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <table class="table-borderless table">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-3">Nama Pemohon</td>
                                                        <td class="col-md-1">:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $userDetail->name ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Kad Pengenalan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $userDetail->icno ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pangkalan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $jetty->jetty_name ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Pendaftaran Vesel</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $vessel->registration_number ?? 'Tiada Vesel' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <table class="table-borderless table">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-3">Jenis Permohonan</td>
                                                        <td class="col-md-1">:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->applicationType->name_ms ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. Rujukan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->no_rujukan ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tarikh Permohonan</td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $application->created_at?->format('d-m-Y') ?? 'Tidak Diketahui' }}"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="card card-primary card-tabs">

                                    <div class="card-header pb-0">

                                        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link custom-nav-link active" id="tab1-link"
                                                    aria-disabled="true"> Pelupusan</a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="card-body">

                                        <div class="tab-content" id="pills-tabContent">

                                            <div class="tab-pane fade show active" id="content-tab1" role="tabpanel"
                                                aria-labelledby="tab1-link">
                                                <form id="form-tab1"
                                                    action="{{ route('gantiKulit.laporanLpiLupus-06.store_tab1', $application->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <section>
                                                        <div class="mb-3">
                                                            <h4>Maklumat Pelupusan</h4>
                                                            <small class="text-muted">
                                                                Bahagian ini memaparkan maklumat berkaitan tarikh,
                                                                lokasi, kaedah pelupusan vesel serta gambar sebelum dan
                                                                selepas pelupusan.
                                                            </small>
                                                            <hr>
                                                        </div>

                                                        <!-- SECTION 1: Tarikh Pelupusan -->
                                                        <div class="mb-4">
                                                            <h5 class="fw-bold">Tarikh Pelupusan</h5>
                                                         <input type="date" name="disposal_date" class="form-control"
    value="{{ old('disposal_date', $dispose->disposal_time ?? '') }}"
    max="{{ \Carbon\Carbon::now()->toDateString() }}">

                                                        </div>

                                                        <!-- SECTION 2: Lokasi Pelupusan -->
                                                        <div class="mb-4">
                                                            <h5 class="fw-bold">Lokasi Pelupusan</h5>
                                                            <input type="text" name="disposal_location"
                                                                class="form-control"
                                                                placeholder="Contoh: Kampung Nelayan, Mukim A"
                                                                value="{{ old('disposal_location', $dispose->disposal_location ?? '') }}">
                                                        </div>

                                                        <!-- SECTION 3: Kaedah Pelupusan -->
                                                        <div class="mb-4">
                                                            <h5 class="fw-bold">Kaedah Pelupusan</h5>
                                                            <select name="disposal_method" class="form-select">
                                                                <option value="">Sila Pilih Kaedah Pelupusan</option>
                                                                <option value="BAKAR" {{ old('disposal_method',
                                                                    $dispose->disposal_method ?? '') == 'BAKAR' ?
                                                                    'selected' : '' }}>BAKAR</option>
                                                                <option value="POTONG" {{ old('disposal_method',
                                                                    $dispose->disposal_method ?? '') == 'POTONG' ?
                                                                    'selected' : '' }}>POTONG</option>
                                                                <option value="TANAM" {{ old('disposal_method',
                                                                    $dispose->disposal_method ?? '') == 'TANAM' ?
                                                                    'selected' : '' }}>TANAM</option>
                                                                <option value="TENGGELAM" {{ old('disposal_method',
                                                                    $dispose->disposal_method ?? '') == 'TENGGELAM' ?
                                                                    'selected' : '' }}>TENGGELAM</option>
                                                            </select>
                                                        </div>

                                                        <!-- Upload Borang Kehadiran -->
                                                        @php
                                                        $uploadedFileName = !empty($dispose->attendance_form_image)
                                                        ? basename($dispose->attendance_form_image)
                                                        : 'Pilih Fail';
                                                        @endphp

                                                        <div class="mb-4">
                                                            <h5 class="fw-bold">Borang Kehadiran</h5>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="custom-file" style="flex-grow: 1;">
                                                                    <input type="file" name="attendance_form"
                                                                        id="attendance_form" class="custom-file-input"
                                                                        accept=".pdf,image/*">
                                                                    <label class="custom-file-label"
                                                                        for="attendance_form">{{ $uploadedFileName
                                                                        }}</label>
                                                                </div>

                                                                @if (!empty($dispose->attendance_form_image))
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#attendanceModal">
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                                @endif
                                                            </div>

                                                            <small class="text-muted">Format dibenarkan: PDF, JPG, PNG.
                                                                Saiz maksima: 2MB.</small>

                                                            @if (!empty($dispose->attendance_form_image))


                                                            <!-- Modal Preview -->
                                                            <div class="modal fade" id="attendanceModal" tabindex="-1"
                                                                aria-labelledby="attendanceModalLabel"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-xl modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="attendanceModalLabel">Pratonton
                                                                                Borang Kehadiran</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Tutup"></button>
                                                                        </div>
                                                                        <div class="modal-body" style="height: 80vh;">
                                                                            <iframe
                                                                                src="{{ route('gantiKulit.laporanLpiLupus-06.viewInspectionDocument', ['id' => $dispose->id, 'field' => 'attendance_form_image']) }}"
                                                                                style="width: 100%; height: 100%; border: none;"></iframe>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        @push('scripts')
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('attendance_form');
        const label = input?.nextElementSibling;
        if (input && label) {
            input.addEventListener('change', function () {
                label.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
            });
        }
    });
                                                        </script>
                                                        @endpush


                                                    </section>

                                                    <br>

                                                    <section>
                                                        <div class="mb-3">
                                                            <h4>Gambar Pelupusan</h4>
                                                            <small class="text-muted">
                                                                Bahagian ini memaparkan gambar vesel sebelum dan selepas
                                                                pelupusan.
                                                            </small>
                                                            <hr>
                                                        </div>

                                                        <!-- SECTION 4: Gambar Sebelum Pelupusan -->
                                                        <div class="mb-4">
                                                            <h5 class="fw-bold">Gambar Sebelum Pelupusan</h5>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="custom-file" style="flex-grow: 1;">
                                                                    <input type="file" name="vessel_image_before"
                                                                        id="vessel_image_before"
                                                                        class="custom-file-input" accept="image/*">
                                                                    <label class="custom-file-label"
                                                                        for="vessel_image_before">
                                                                        {{ !empty($dispose->before_disposal_image) ?
                                                                        basename($dispose->before_disposal_image) :
                                                                        'Pilih Fail' }}
                                                                    </label>
                                                                </div>

                                                                @if (!empty($dispose->before_disposal_image))
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#beforeImageModal">
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                                @endif
                                                            </div>

                                                            <small class="text-muted">Format dibenarkan: JPG, PNG. Saiz
                                                                maksima: 2MB.</small>

                                                            @if (!empty($dispose->before_disposal_image))


                                                            <!-- Modal Preview -->
                                                            <div class="modal fade" id="beforeImageModal" tabindex="-1"
                                                                aria-labelledby="beforeImageModalLabel"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-xl modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="beforeImageModalLabel">Pratonton
                                                                                Gambar Sebelum Pelupusan</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Tutup"></button>
                                                                        </div>
                                                                        <div class="modal-body" style="height: 80vh;">
                                                                            <iframe
                                                                                src="{{ route('gantiKulit.laporanLpiLupus-06.viewInspectionDocument', ['id' => $dispose->id, 'field' => 'before_disposal_image']) }}"
                                                                                style="width: 100%; height: 100%; border: none;"></iframe>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>

                                                        <!-- SECTION 5: Gambar Selepas Pelupusan -->
                                                        <div class="mb-4">
                                                            <h5 class="fw-bold">Gambar Selepas Pelupusan</h5>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="custom-file" style="flex-grow: 1;">
                                                                    <input type="file" name="vessel_image_after"
                                                                        id="vessel_image_after"
                                                                        class="custom-file-input" accept="image/*">
                                                                    <label class="custom-file-label"
                                                                        for="vessel_image_after">
                                                                        {{ !empty($dispose->after_disposal_image) ?
                                                                        basename($dispose->after_disposal_image) :
                                                                        'Pilih Fail' }}
                                                                    </label>
                                                                </div>

                                                                @if (!empty($dispose->after_disposal_image))
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#afterImageModal">
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                                @endif
                                                            </div>

                                                            <small class="text-muted">Format dibenarkan: JPG, PNG. Saiz
                                                                maksima: 2MB.</small>

                                                            @if (!empty($dispose->after_disposal_image))


                                                            <!-- Modal Preview -->
                                                            <div class="modal fade" id="afterImageModal" tabindex="-1"
                                                                aria-labelledby="afterImageModalLabel"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-xl modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="afterImageModalLabel">Pratonton
                                                                                Gambar Selepas Pelupusan</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Tutup"></button>
                                                                        </div>
                                                                        <div class="modal-body" style="height: 80vh;">
                                                                            <iframe
                                                                                src="{{ route('gantiKulit.laporanLpiLupus-06.viewInspectionDocument', ['id' => $dispose->id, 'field' => 'after_disposal_image']) }}"
                                                                                style="width: 100%; height: 100%; border: none;"></iframe>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </section>
                                                    @push('scripts')
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
        ['vessel_image_before', 'vessel_image_after'].forEach(function (id) {
            const input = document.getElementById(id);
            const label = input?.nextElementSibling;
            if (input && label) {
                input.addEventListener('change', function () {
                    label.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih Fail';
                });
            }
        });
    });
                                                    </script>
                                                    @endpush

                                                </form>


                                            </div>

                                        </div>

                                        {{-- card --}}

                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="d-flex justify-content-end gap-3">
                                    <!-- Back and Next Buttons -->
                                    <div class="d-flex gap-3">
                                        <button id="backTabBtn" type="button" class="btn btn-light"
                                            style="width:120px">Kembali</button>

                                        <!-- Simpan Buttons for Each Tab -->
                                        <button id="simpanBtn1" type="submit" class="btn btn-warning" form="form-tab1"
                                            style="width:120px; display:none">Simpan</button>
                                        <button id="simpanBtn2" type="submit" class="btn btn-warning" form="form-tab2"
                                            style="width:120px; display:none">Simpan</button>
                                        {{-- <button id="simpanBtn3" type="submit" class="btn btn-warning"
                                            form="form-tab3" style="width:120px; display:none">Simpan</button>
                                        <button id="simpanBtn4" type="submit" class="btn btn-warning" form="form-tab4"
                                            style="width:120px; display:none">Simpan</button> --}}
                                        <button id="simpanBtn5" type="submit" class="btn btn-warning" form="form-tab5"
                                            style="width:120px; display:none">Simpan</button>

                                        <button id="nextTabBtn" type="button" class="btn btn-light"
                                            style="width:120px">Seterusnya</button>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-3">
                                        <!-- Final Submission Form -->
                                        <form id="form-submit-final"
                                            action="{{ route('gantiKulit.laporanLpiLupus-06.store', $application->id) }}"
                                            method="POST">
                                            @csrf
                                        </form>

                                        <!-- Hantar Button -->
                                        <button id="hantarBtn" type="submit" class="btn btn-success"
                                            form="form-submit-final" style="width:120px; display:none">Hantar</button>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
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

{{-- <script>
    let currentTab = 1;
    const totalTabs = 2;

    function toggleButtons() {
        // Toggle Simpan buttons
        for (let i = 1; i <= totalTabs; i++) {
            const simpanBtn = document.getElementById(`simpanBtn${i}`);
            if (simpanBtn) {
                simpanBtn.style.display = (currentTab === i) ? "inline-block" : "none";
            }
        }

        // Toggle Hantar button
        const hantarBtn = document.getElementById("hantarBtn");
        if (hantarBtn) {
            hantarBtn.style.display = (currentTab === totalTabs) ? "inline-block" : "none";
        }

        // Toggle Seterusnya (Next) button
        const nextBtn = document.getElementById("nextTabBtn");
        if (nextBtn) {
            nextBtn.style.display = (currentTab === totalTabs) ? "none" : "inline-block";
        }
    }

    document.getElementById("nextTabBtn").addEventListener("click", () => {
        if (currentTab === totalTabs) return alert("Ini adalah tab terakhir.");

        document.getElementById(`tab${currentTab}-link`).classList.remove("active");
        document.getElementById(`content-tab${currentTab}`).classList.remove("show", "active");

        currentTab++;

        document.getElementById(`tab${currentTab}-link`).classList.add("active");
        document.getElementById(`content-tab${currentTab}`).classList.add("show", "active");

        toggleButtons();
    });

    document.getElementById("backTabBtn").addEventListener("click", () => {
        if (currentTab === 1) return alert("Ini adalah tab pertama.");

        document.getElementById(`tab${currentTab}-link`).classList.remove("active");
        document.getElementById(`content-tab${currentTab}`).classList.remove("show", "active");

        currentTab--;

        document.getElementById(`tab${currentTab}-link`).classList.add("active");
        document.getElementById(`content-tab${currentTab}`).classList.add("show", "active");

        toggleButtons();
    });

    toggleButtons(); // Initial state
</script> --}}
<script>
    const currentTab = 1;

    function toggleButtons() {
        // Show only Simpan button for tab 1
        const simpanBtn = document.getElementById("simpanBtn1");
        if (simpanBtn) simpanBtn.style.display = "inline-block";

        // Show Hantar button
        const hantarBtn = document.getElementById("hantarBtn");
        if (hantarBtn) hantarBtn.style.display = "inline-block";

        // Hide Next and Back buttons since only 1 tab exists
        const nextBtn = document.getElementById("nextTabBtn");
        if (nextBtn) nextBtn.style.display = "none";

        const backBtn = document.getElementById("backTabBtn");
        if (backBtn) backBtn.style.display = "none";
    }

    document.addEventListener("DOMContentLoaded", toggleButtons);
</script>

@endpush
