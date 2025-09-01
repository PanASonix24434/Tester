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
                <div class="col-md">

                    <div class="mb-5">
                        <h3 class="mb-0">PERMOHONAN PEMBAHARUAN LESEN LEBIH 1 TAHUN</h3>
                    </div>

                </div>
                <div class="col-md-3 align-content-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="d-flex   justify-content-end">
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a
                                    href="http://127.0.0.1:8000/lebihTahun/permohonan-07">Pembaharuan Lesen Lebih 1 Tahun</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Permohonan</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Permohonan</a></li> --}}

                        </ol>
                    </nav>
                </div>
            </div>
            <div>
                <form id="submitPermohonan" method="POST" enctype="multipart/form-data"
                    action="{{ route('lebihTahun.permohonan-07.store') }}">
                    @csrf
                    <!-- Content -->

                    <div class="card">

                        <div class="card-header">
                            <div class="col-form-label m-0 p-0">Permohonan</div>
                        </div>

                        <div class="card-body">

                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-maklumat-peralatan-tab" data-bs-toggle="pill"
                                        href="#pills-maklumat-peralatan" role="tab"
                                        aria-controls="pills-maklumat-peralatan" aria-selected="false">Maklumat
                                        Peralatan</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="pills-dokumen-sokongan-tab" data-bs-toggle="pill"
                                        href="#pills-dokumen-sokongan" role="tab" aria-controls="pills-dokumen-sokongan"
                                        aria-selected="false">Dokumen
                                        Sokongan</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="pills-pejabat-urusan-tab" data-bs-toggle="pill"
                                        href="#pills-pejabat-urusan" role="tab" aria-controls="pills-pejabat-urusan"
                                        aria-selected="false">Pejabat Urusan </a>
                                </li>

                            </ul>
                            <hr>

                            <div class="tab-content p-4" id="pills-tabContent">

                                <div class="tab-pane fade show active" id="pills-maklumat-peralatan" role="tabpanel"
                                    aria-labelledby="pills-maklumat-peralatan-tab">
                                    <div class="card-header mb-3 pl-0">
                                        <h4>Peralatan Menangkap Ikan</h4>
                                    </div>
                                    <br>
                                    <!-- Main Equipment Section -->
                                    <h5>Peralatan Utama</h5>
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%">Bil</th>
                                                <th class="col-md-5">Peralatan Utama</th>
                                                <th>Kuantiti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($equipmentMain as $index => $submission)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $submission->equipment->name }}</td>
                                                <td>{{ $submission->quantity }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <hr>
                                    <br>
                                    <!-- Additional Equipment Section -->
                                    <h5>Peralatan Tambahan</h5>
                                    <table class="table" id="additionalEquipmentTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%">Bil</th>
                                                <th class="col-md-5">Peralatan Tambahan</th>
                                                <th>Kuantiti</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($equipmentAdditional as $index => $equipment)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $equipment->equipment->name}}</td>
                                                <td>{{ $equipment->quantity }}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="pills-dokumen-sokongan" role="tabpanel"
                                    aria-labelledby="pills-dokumen-sokongan-tab">
                                    <div class="card-header pl-0">
                                        <h4>Gambar Peralatan Baru</h4>
                                    </div>
                                    <br>
                                    @if(isset($equipmentFiles) && $equipmentFiles->isNotEmpty())
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%">Bil</th>
                                                <th class="col-md-4">Nama Fail</th>
                                                <th class="col-md-4">Keterangan</th>
                                                <th class="col-md-3">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($equipmentFiles as $index => $file)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $file->name }}</td>
                                                <td>{{ $file->description }}</td>
                                                <td>
                                                    <a href="{{ route('lebihTahun.permohonan-07.viewFile', $file->id) }}"
                                                        target="_blank" class="btn btn-primary">
                                                        Papar
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <div class="mb-3">
                                        <p class="text-center">Tidak ada gambar peralatan baru yang dimuat naik.</p>
                                    </div>
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="pills-pejabat-urusan" role="tabpanel"
                                    aria-labelledby="pills-pejabat-urusan-tab">
                                    <div class="card-header pl-0">
                                        <h4>Pejabat Urusan</h4>
                                    </div>
                                    <br>
                                    @if(isset($application))
                                    <table class="table ">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%">Bil</th>
                                                <th>Pejabat Urusan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>{{ $application->entity->entity_name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <small class="text-muted">
                                        Silakan ke pejabat urusan yang dipilih untuk melakukan urusan.
                                    </small>
                                    @else
                                    <div class="form-group">
                                        <p>Tidak ada pejabat urusan yang dipilih.</p>
                                    </div>
                                    @endif
                                </div>

                                <div class="text-right"> <button class="btn btn-success col-md-1" type="button"
                                        onclick="window.location.href='{{ route('lebihTahun.permohonan-07.storeDraft') }}'">Hantar</button>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Content -->
            </div>
        </div>
        </form>
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

                // Display success message from Laravel session
                var msgSuccess = '{{ Session::get('success') }}';
                var existSuccess = '{{ Session::has('success') }}';
                if (existSuccess) {
                    alert(msgSuccess);
                }

                // Display error message from Laravel session
                var msgError = '{{ Session::get('error') }}';
                var existError = '{{ Session::has('error') }}';
                if (existError) {
                    alert(msgError);
                }
        </script>

        <!-- JavaScript for Dynamic Document Rows -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                    let tableBody = document.getElementById("documentTable").getElementsByTagName('tbody')[0];

                    function updateRowNumbers() {
                        let rows = tableBody.getElementsByTagName('tr');
                        for (let i = 0; i < rows.length; i++) {
                            rows[i].querySelector(".row-counter").textContent = i + 1;
                        }
                    }

                    document.getElementById("addRow").addEventListener("click", function() {
                        let newRow = tableBody.insertRow();
                        newRow.innerHTML = `
                <td class="row-counter"></td>
                <td>
                    <input class="form-control" name="uploadFile[]" type="file" accept=".pdf,.jpg,.png" required>
                    <small class="form-text text-muted">Format PDF, JPG, atau PNG (maksimum 2MB).</small>
                </td>
                <td><input type="text" name="file_description[]" class="form-control" required></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-trash"></i></button>
                </td>
            `;
                        updateRowNumbers();
                    });

                    tableBody.addEventListener("click", function(event) {
                        if (event.target.classList.contains("removeRow")) {
                            event.target.closest("tr").remove();
                            updateRowNumbers();
                        }
                    });

                    updateRowNumbers();
                });
        </script>

        <!-- JavaScript for Dynamic Table Rows -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#additionalEquipmentTable tbody');
            const addButton = document.getElementById('addEquipmentRow');
            const maxRows = 5;
            // Initialize rowCount based on any pre-existing rows (edit mode) or 0 (new form)
            let rowCount = tableBody.querySelectorAll('tr').length;
        
            // Update row numbering after any change
            function updateRowNumbers() {
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    row.querySelector('.row-number').textContent = index + 1;
                });
            }
        
            // Enable or disable remove buttons based on the row count
            function updateRemoveButtons() {
                const removeButtons = tableBody.querySelectorAll('.remove-row');
                removeButtons.forEach(btn => {
                    btn.disabled = (rowCount <= 1);
                });
            }
        
            // Function to add a new row with a dropdown for additional equipment
            function addRow() {
                if (rowCount >= maxRows) return;
                rowCount++;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="row-number">${rowCount}</td>
                    <td>
                         <select name="additionalEquipment[]" class="form-control" required>
                                <option value="">-- Pilih Peralatan Utama --</option>
                                @foreach($equipmentAdditional as $equipmentAddtional)
                                <option value="{{ $equipmentAddtional->id }}">{{ $equipmentAddtional->name }}
                                </option>
                                @endforeach
                            </select>
                    </td>
                    <td>
                        <input type="number" name="additionalEquipmentQuantity[]" class="form-control" placeholder="0" min="1" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row" title="Buang baris">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);
                updateRowNumbers();
                updateRemoveButtons();
                if (rowCount >= maxRows) {
                    addButton.disabled = true;
                }
            }
        
            // If no rows exist (new form), add the initial row; otherwise, update row numbering for editing
            if (rowCount === 0) {
                addRow();
            } else {
                updateRowNumbers();
                updateRemoveButtons();
            }
        
            // Handle the "Tambah Baris" button click
            addButton.addEventListener('click', function() {
                addRow();
            });
        
            // Handle removal of a row
            tableBody.addEventListener('click', function(e) {
                if (e.target && (e.target.matches('.remove-row') || e.target.closest('.remove-row'))) {
                    if (rowCount > 1) {
                        const tr = e.target.closest('tr');
                        tr.remove();
                        rowCount--;
                        addButton.disabled = false;
                        updateRowNumbers();
                        updateRemoveButtons();
                    }
                }
            });
        });
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        @endpush