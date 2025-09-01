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
                        <h3 class="mb-0">Senarai Jetty Dan Pangkalan</h3>
                        <small class="text-muted">Tambah jeti dan pindah pangkalan</small>
                    </div>
                </div>

                <div class="col-md-3 text-md-end text-start">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('master-data.jetty-base.index') }}">Data Utama</a>
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
                                    <form method="POST" action="{{ route('master-data.jetty-base.store') }}">
                                        @csrf

                                        <!-- Negeri -->
                                        <div class="mb-3">
                                            <label for="state_id" class="form-label">Negeri <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="state_id" name="state_id"
                                                data-url="{{ route('master-data.jetty-base.getDistricts', ['state_id' => ':state_id']) }}"
                                                required>

                                                <!-- Placeholder (not uppercase) -->
                                                <option value="">Pilih Negeri</option>

                                                <!-- State options (uppercase) -->
                                                @foreach($states as $id => $name)
                                                <option value="{{ $id }}" class="text-uppercase" {{ old('state_id')==$id
                                                    ? 'selected' : '' }}>
                                                    {{ strtoupper($name) }}
                                                </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <!-- Daerah -->
                                        <div class="mb-3">
                                            <label for="district_id" class="form-label">Daerah <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="district_id" name="district_id" required>
                                                <option value="">Pilih Daerah</option>
                                            </select>
                                        </div>


                                        <!-- Parlimen -->
                                        <div class="mb-3">
                                            <label for="parliament_id" class="form-label">Parlimen <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="parliament_id" name="parliament_id"
                                                data-url="{{ route('master-data.jetty-base.getParliaments', ['state_id' => ':state_id']) }}"
                                                required>
                                                <option value="">Pilih Parlimen</option>
                                                <!-- options will be populated via JS -->
                                            </select>
                                        </div>


                                        <!-- DUN -->
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">DUN<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="dun_id" name="dun_id"
                                                    data-url="{{ route('master-data.jetty-base.getDuns', ['parliament_id' => ':parliament_id']) }}"
                                                    required>
                                                    <option value="">Pilih DUN</option>
                                                </select>
                                            </div>



                                            <!-- Nama Jeti / Pangkalan -->
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Jeti / Pangkalan <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ old('name') }}"
                                                    placeholder="Masukkan nama jeti / pangkalan" required>
                                            </div>

                                            <br>

                                            <div class="text-center d-flex justify-content-center gap-3">
                                                <a href="{{ route('master-data.jetty-base.index') }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> Simpan
                                                </button>
                                            </div>
                                    </form>

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

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
        const stateSelect = document.getElementById('state_id');
        const districtSelect = document.getElementById('district_id');
        const parliamentSelect = document.getElementById('parliament_id');

        stateSelect.addEventListener('change', function () {
            const state_id = this.value;

            // ----- Handle Daerah -----
            const districtUrl = this.getAttribute('data-url').replace(':state_id', state_id);
            districtSelect.innerHTML = '<option value="">-- Sila Pilih Daerah --</option>';

            if (state_id) {
                fetch(districtUrl)
                    .then(response => response.json())
                    .then(data => {
                        for (const [id, name] of Object.entries(data)) {
                            const option = new Option(name.toUpperCase(), id);
                            option.classList.add('text-uppercase');
                            districtSelect.add(option);
                        }
                    })
                    .catch(error => console.error('Error loading districts:', error));
            }

            // ----- Handle Parlimen -----
            const parliamentUrl = parliamentSelect.getAttribute('data-url').replace(':state_id', state_id);
            parliamentSelect.innerHTML = '<option value="">-- Sila Pilih Parlimen --</option>';

            if (state_id) {
                fetch(parliamentUrl)
                    .then(response => response.json())
                    .then(data => {
                        for (const [id, name] of Object.entries(data)) {
                            const option = new Option(name.toUpperCase(), id);
                            option.classList.add('text-uppercase');
                            parliamentSelect.add(option);
                        }
                    })
                    .catch(error => console.error('Error loading parliaments:', error));
            }
        });
    });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const stateSelect = document.getElementById('state_id');
        const districtSelect = document.getElementById('district_id');
        const parliamentSelect = document.getElementById('parliament_id');
        const dunSelect = document.getElementById('dun_id');

        // Function to reset and populate a select dropdown
        function populateDropdown(selectElement, placeholder, data) {
            selectElement.innerHTML = `<option value="">${placeholder}</option>`;
            for (const [id, name] of Object.entries(data)) {
                const option = new Option(name.toUpperCase(), id);
                option.classList.add('text-uppercase');
                selectElement.add(option);
            }
        }

        // When Negeri changes, fetch Daerah and Parlimen
        stateSelect.addEventListener('change', function () {
            const state_id = this.value;

            // Clear all dependent dropdowns
            districtSelect.innerHTML = '<option value="">-- Sila Pilih Daerah --</option>';
            parliamentSelect.innerHTML = '<option value="">-- Sila Pilih Parlimen --</option>';
            dunSelect.innerHTML = '<option value="">-- Sila Pilih DUN --</option>';

            if (!state_id) return;

            // Fetch Daerah
            const districtUrl = stateSelect.getAttribute('data-url').replace(':state_id', state_id);
            fetch(districtUrl)
                .then(response => response.json())
                .then(data => populateDropdown(districtSelect, '-- Sila Pilih Daerah --', data))
                .catch(error => console.error('Error loading districts:', error));

            // Fetch Parlimen
            const parliamentUrl = parliamentSelect.getAttribute('data-url').replace(':state_id', state_id);
            fetch(parliamentUrl)
                .then(response => response.json())
                .then(data => populateDropdown(parliamentSelect, '-- Sila Pilih Parlimen --', data))
                .catch(error => console.error('Error loading parliaments:', error));
        });

        // When Parlimen changes, fetch DUN
        parliamentSelect.addEventListener('change', function () {
            const parliament_id = this.value;

            dunSelect.innerHTML = '<option value="">-- Sila Pilih DUN --</option>';

            if (!parliament_id) return;

            const dunUrl = dunSelect.getAttribute('data-url').replace(':parliament_id', parliament_id);
            fetch(dunUrl)
                .then(response => response.json())
                .then(data => populateDropdown(dunSelect, '-- Sila Pilih DUN --', data))
                .catch(error => console.error('Error loading DUNs:', error));
        });
    });
    </script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endpush
