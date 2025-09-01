@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<style type="text/css"></style>
<style>
    /* Target the DataTables length dropdown */
    #companyTable_length {
        margin-left: -1%;
    }

    /* Remove bold styling for 'Papar rekod per halaman' */
    #companyTable_length label {
        font-weight: normal;
    }

    /* Change 'Cari' to 'Carian' and make it not bold */
    #companyTable_filter label {
        font-weight: normal;
        display: inline-block;
        margin-right: 8px;
    }

    #companyTable_filter input {
        font-weight: normal;
        width: 150px; /* Make the search input smaller */
    }

   /* Remove all borders from the table */
#companyTable {
    width: 100%; /* Ensure the table takes the full width */
    border-collapse: collapse;
    border: none; /* Remove all borders */
}

#companyTable th, #companyTable td {
    border-top: 1px solid #ddd; /* Keep horizontal borders on top */
    border-bottom: 1px solid #ddd; /* Keep horizontal borders on bottom */
    border-left: none;  /* Remove vertical left borders */
    border-right: none; /* Remove vertical right borders */
}

#companyTable td:first-child, #companyTable th:first-child {
    border-left: none; /* Ensure no left border for the first column */
}

#companyTable td:last-child, #companyTable th:last-child {
    border-right: none; /* Ensure no right border for the last column */
}

/* Adjust the width of the table to ensure it fits within the card */
.table-responsive {
    padding-right: 0; /* Remove any padding */
    margin-right: 0; /* Remove any margin */
}
</style>
@endpush

@section('content')
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                    <h3>Profil Syarikat/Koperasi/Persatuan</h3>
                    </div>
                </div>
            </div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        
        
                <!-- Single Column: Card with Form Inside -->
                <div class="col-lg-12">
                  <div class="card card-primary" style="outline: 2px solid lightgray;">
                    <div class="card-header" style="padding-bottom: 2px;">
                            <h6 style="color: white; font-size: 0.9rem;"> SENARAI SYARIKAT BERDAFTAR</h6>
                        </div>
                                        <div class="col-12">
                                                        <div class="form-group">
                                            <div id="shareholder-list" class="table-responsive">
                                            <table id="companyTable" class="table dataTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 5%;">Bil</th>
                                                        <th>Nama Syarikat</th>
                                                        <th>No. Pendaftaran Syarikat</th>
                                                        <th>Kategori</th>
                                                        <th>Daerah</th>
                                                        <th>Negeri</th>
                                                        <th>Status</th>
                                                        <th>Tindakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($companies->isNotEmpty())
                                                        @foreach($companies as $company)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $company->company_name }}</td>
                                                                <td>{{ $company->pendaftaranPerniagaan->company_reg_no ?? 'N/A' }}</td>
                                                                <td>{{ strtoupper($ownership[$company->ownership] ?? 'N/A') }}</td>
                                                                <td>{{ $company->district }}</td>
                                                                <td>{{ strtoupper($state[$company->state] ?? 'N/A') }}</td>                                                              <td>
                                                                    @if($company->company_status == 1)
                                                                        <span class="badge bg-success">Aktif</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="{{ route('profile.maklumatSyarikat', ['company_id' => $company->id]) }}" 
                                                                    class="btn btn-link p-0" 
                                                                    style="color: #28a745;">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="9" class="text-center">Tiada syarikat didaftarkan.</td>
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
<!-- DataTables JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#companyTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            lengthMenu: [5, 10, 25],
            language: {
                search: "Cari:",
                lengthMenu: "Papar _MENU_ rekod per halaman",
                zeroRecords: "Tiada data dijumpai",
                info: "Paparan _PAGE_ dari _PAGES_",
                infoEmpty: "Tiada data tersedia",
                infoFiltered: "(ditapis dari _MAX_ rekod keseluruhan)"
            }
        });
    });
</script>

<!-- SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showAlert(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message
        });
    }
</script>
@endpush