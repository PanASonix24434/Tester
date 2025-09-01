@extends('layouts.app')

@section('content')

<!-- Page Content -->
<div id="app-content">

    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row d-flex align-items-center mb-4">
                <div class="col-md-9">
                    <div>
                        <h3 class="mb-0">Pejabat Perikanan Daerah</h3>
                        <small class="text-muted">Maklumat pejabat urusan perikanan mengikut daerah.</small>
                    </div>
                </div>

                <div class="col-md-3 text-md-end text-start">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('master-data.fisheries-office.index') }}">Data Utama</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tambah Data
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div>

                <div class="row">
                    <div class="col-12">

                        <!-- Card -->
                        <div class="card mb-4">

                            <div class="card-body">
                                <div class="card-body">
                                    <form method="POST" action="{{ route('master-data.fisheries-office.store') }}">
                                        @csrf

                                        <!-- Negeri -->
                                        <div class="mb-3">
                                            <label for="state_id" class="form-label">Negeri <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="state_id" name="state_id"
                                                data-url="{{ route('master-data.fisheries-office.getDistricts', ['state_id' => ':state_id']) }}"
                                                required>
                                                <option value="" disabled selected>Pilih Negeri</option>
                                                @foreach($states as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Daerah -->
                                        <div class="mb-3">
                                            <label for="district_id" class="form-label">Daerah <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="district_id" name="district_id">
                                                <option value="" disabled selected>Pilih Daerah</option>
                                                <!-- Populated dynamically via JS/AJAX if needed -->
                                            </select>
                                        </div>

                                        <!-- Jenis Pejabat -->
                                        <div class="mb-3">
                                            <label for="office_type" class="form-label">Jenis Pejabat <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="office_type" name="office_type" required>
                                                <option value="" disabled selected>Pilih Jenis Pejabat</option>
                                                <option value="state">Pejabat Negeri</option>
                                                <option value="district">Pejabat Daerah</option>
                                            </select>
                                        </div>


                                        <!-- Pejabat Perikanan Negeri -->
                                        <div class="mb-3" id="state_office_field" style="display: none;">
                                            <label for="negeri_office_id" class="form-label">
                                                Pejabat Perikanan Negeri <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="negeri_office_id" name="negeri_office_id">
                                                <option value="" disabled selected>Sila pilih Pejabat Perikanan Negeri
                                                </option>
                                                <option value="-">-</option>
                                                @foreach($stateOffices as $name => $id)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Pejabat Perikanan Daerah -->
                                        <div class="mb-3" id="district_office_field" style="display: none;">
                                            <label for="daerah_office_id" class="form-label">
                                                Pejabat Perikanan Daerah <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="daerah_office_id" name="daerah_office_id">
                                                <option value="" disabled selected>Pilih Pejabat Perikanan Daerah
                                                </option>
                                                <option value="-">-</option>
                                                @foreach($districtOffices as $name => $id)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <br>

                                        <div class="text-center d-flex justify-content-center gap-3">
                                            <a href="{{ route('master-data.fisheries-office.index') }}"
                                                class="btn btn-secondary">
                                                <i class="fas fa-arrow-left me-1"></i> Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-1"></i> Simpan
                                            </button>
                                        </div>
                                    </form>

                                    <!-- JavaScript to toggle Pejabat Daerah visibility & required fields -->
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
        const officeType = document.getElementById('office_type');
        const stateOfficeField = document.getElementById('state_office_field');
        const stateOffice = document.getElementById('negeri_office_id');
        const districtOfficeField = document.getElementById('district_office_field');
        const districtOffice = document.getElementById('daerah_office_id');

        function toggleOfficeInputs() {
            const type = officeType.value;

            // Reset visibility
            stateOfficeField.style.display = 'none';
            districtOfficeField.style.display = 'none';

            // Reset required
            stateOffice.required = false;
            districtOffice.required = false;

            if (type === 'state') {
                stateOfficeField.style.display = 'block';
                stateOffice.required = true;
            }

            if (type === 'district') {
                stateOfficeField.style.display = 'block';
                districtOfficeField.style.display = 'block';
                stateOffice.required = true;
                districtOffice.required = true;
            }
        }

        toggleOfficeInputs();
        officeType.addEventListener('change', toggleOfficeInputs);
    });
                                    </script>

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const stateSelect = document.getElementById('state_id');
        const districtSelect = document.getElementById('district_id');

        stateSelect.addEventListener('change', function () {
            const state_id = this.value;
            const urlTemplate = this.getAttribute('data-url');
            const finalUrl = urlTemplate.replace(':state_id', state_id);

            console.log("Fetching districts from:", finalUrl);

            districtSelect.innerHTML = '<option value="">Sila Pilih Daerah</option>';

            if (state_id) {
                fetch(finalUrl)
                    .then(response => response.json())
                    .then(data => {
                        for (const [id, name] of Object.entries(data)) {
                            const option = new Option(name, id);
                            districtSelect.add(option);
                        }
                    })
                    .catch(error => console.error('Error loading districts:', error));
            }
        });
    });
    </script>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endpush
