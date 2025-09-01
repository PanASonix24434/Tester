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

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Jeti / Pangkalan <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name') }}" placeholder="Masukkan nama jeti / pangkalan"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="state_id" class="form-label">Negeri <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="state_id" name="state_id"
                                                data-url="{{ route('master-data.jetty-base.getDistricts', ['state_id' => ':state_id']) }}"
                                                required>
                                                <option value="">Pilih Negeri</option>
                                                @foreach($states as $id => $name)
                                                <option value="{{ $id }}" {{ old('state_id')==$id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="district_id" class="form-label">Daerah <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="district_id" name="district_id" required>
                                                <option value="">Pilih Daerah</option>
                                            </select>
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


    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const stateSelect = document.getElementById('state_id');
        const districtSelect = document.getElementById('district_id');

        stateSelect.addEventListener('change', function () {
            const state_id = this.value;
            const urlTemplate = this.getAttribute('data-url');
            const finalUrl = urlTemplate.replace(':state_id', state_id);

            console.log("Fetching districts from:", finalUrl);

            districtSelect.innerHTML = '<option value="">-- Sila Pilih Daerah --</option>';

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
